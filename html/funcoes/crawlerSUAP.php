<?php

session_start();

require '../vendor/autoload.php';

use DiDom\Document;

const SUAP_BASE = 'https://suap.ifgoiano.edu.br';
const SUAP_LOGIN_URL = SUAP_BASE . '/accounts/login/?next=/';
const COOKIE_FILE = __DIR__ . '/suap_cookies.txt';
const DEBUG = false;

function debug(string $msg): void
{
    if (!DEBUG) return;
    $time = date('Y-m-d H:i:s');
    echo "[DEBUG {$time}] {$msg}\n";
}

function suapClient()
{
    static $curlSession = null;
    static $logado = false;

    if ($curlSession === null) {
        debug("Inicializando cURL com cookie: " . COOKIE_FILE);
        $curlSession = curl_init();
        curl_setopt_array($curlSession, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_COOKIEJAR => COOKIE_FILE,
            CURLOPT_COOKIEFILE => COOKIE_FILE,
            CURLOPT_USERAGENT => 'UnioCrawler/1.0',
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_TIMEOUT => 60,
        ]);
    }

    if (!$logado) {
        debug("Ainda não logado. Chamando suapLogin()...");
        suapLogin($curlSession);
        $logado = true;
        debug("Login efetuado com sucesso.");
    }

    return $curlSession;
}

function suapLogin($curlSession): void
{
    $usuarioSUAP = $_SESSION['usuario'] ?? null;
    $senhaSUAP = $_SESSION['senha'] ?? null;

    if (!$usuarioSUAP || !$senhaSUAP ) {
        debug("Usuário ou senha do SUAP não encontrados na sessão.");
        throw new RuntimeException('Usuário ou senha do SUAP não encontrados na sessão.');
    }

    debug("Iniciando login no SUAP para o usuário: {$usuarioSUAP }");

    curl_setopt_array($curlSession, [
        CURLOPT_URL => SUAP_LOGIN_URL,
        CURLOPT_HTTPGET => true,
        CURLOPT_POST => false,
    ]);

    $loginHTML = curl_exec($curlSession);

    if ($loginHTML === false) {
        $err = curl_error($curlSession);
        debug("Erro ao abrir página de login: {$err}");
        throw new RuntimeException('Erro ao abrir página de login: ' . $err);
    }

    $documentHTML = new Document($loginHTML);
    $csrf = '';
    $csrfInput = $documentHTML->first('input[name=csrfmiddlewaretoken]');
    if ($csrfInput) {
        $csrf = $csrfInput->attr('value');
        debug("csrfmiddlewaretoken encontrado: {$csrf}");
    }

    $post = [
        'username' => $usuarioSUAP ,
        'password' => $senhaSUAP ,
    ];
    if ($csrf !== '') {
        $post['csrfmiddlewaretoken'] = $csrf;
    }

    debug("Enviando POST de autenticação...");
    curl_setopt_array($curlSession, [
        CURLOPT_URL => SUAP_LOGIN_URL,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($post),
        CURLOPT_REFERER => SUAP_LOGIN_URL,
    ]);

    $responseSession = curl_exec($curlSession);
    if ($responseSession === false) {
        $err = curl_error($curlSession);
        debug("Falha ao autenticar no SUAP: {$err}");
        throw new RuntimeException('Falha ao autenticar no SUAP: ' . $err);
    }

    if (strpos($responseSession, 'Acesso ao Suap') !== false) {
        debug("Ainda parece estar na tela de login. Credenciais podem estar erradas.");
        throw new RuntimeException('Ainda parece estar na tela de login. Credenciais podem estar erradas.');
    }
}

function suapRequest(string $url, ?array $postData = null, ?string $referer = null): string
{
    $curlSession = suapClient();

    debug("Requisição para URL: {$url}");
    if ($postData !== null) {
        debug("Método: POST");
        debug("POST data: " . json_encode($postData, JSON_UNESCAPED_UNICODE));
        curl_setopt($curlSession, CURLOPT_POST, true);
        curl_setopt($curlSession, CURLOPT_POSTFIELDS, http_build_query($postData));
    } else {
        debug("Método: GET");
        curl_setopt($curlSession, CURLOPT_HTTPGET, true);
        curl_setopt($curlSession, CURLOPT_POST, false);
    }

    if ($referer) {
        debug("Referer: {$referer}");
        curl_setopt($curlSession, CURLOPT_REFERER, $referer);
    }

    curl_setopt($curlSession, CURLOPT_URL, $url);

    $responseSession = curl_exec($curlSession);
    if ($responseSession === false) {
        $err = curl_error($curlSession);
        debug("Erro na requisição: {$err}");
        throw new RuntimeException('Erro na requisição: ' . $url . ': ' . $err);
    }

    $permissaoSUAP = strpos($responseSession, 'Você não tem permissão para acessar essa página') !== false;
    if ($permissaoSUAP) {
        debug("Você não tem permissão para acessar essa página no SUAP. Verifique seu usuário/perfil.");
        echo "Você não tem permissão para acessar essa página no SUAP. Verifique seu usuário/perfil.";
        throw new RuntimeException("Você não tem permissão para acessar essa página no SUAP. Verifique seu usuário/perfil.");
        exit;
    }

    debug("Requisição concluída (tamanho: " . strlen($responseSession) . " bytes).");
    return $responseSession;
}

function resolveUrl(string $base, string $href): string
{
    if (preg_match('#^https?://#i', $href)) {
        return $href;
    }
    $full = rtrim($base, '/') . '/' . ltrim($href, '/');
    debug("Resolvendo URL: base={$base}, href={$href}, final={$full}");
    return $full;
}

$matriculaEstudante = $_SESSION['usuario'] ?? null;
function consultarNomeEstudante(string $matriculaEstudante): ?string
{
    $matriculaEstudante = trim($matriculaEstudante);

    if ($matriculaEstudante === '') {
        return null;
    }

    $URLEstudante = SUAP_BASE . '/edu/aluno/' . $matriculaEstudante;

    $html = suapRequest($URLEstudante);
    $document = new Document($html);

    foreach ($document->find('dt') as $dt) {
        $label = trim($dt->text());
        if ($label === 'Nome') {
            $pai = $dt->parent();
            if ($pai) {
                $dd = $pai->first('dd');
                if ($dd) {
                    $nome = trim($dd->text());
                    if ($nome === '' || $nome === '-') {
                        return null;
                    }
                    return $nome;
                }
            }
        }
    }

    return null;
}

function consultarEmailEstudante(string $matriculaEstudante): ?string
{
    $matriculaEstudante = trim($matriculaEstudante);

    if ($matriculaEstudante === '') {
        return null;
    }

    $URLEstudante = SUAP_BASE . '/edu/aluno/' . $matriculaEstudante;

    $html = suapRequest($URLEstudante);
    $document = new Document($html);

    foreach ($document->find('dt') as $dt) {
        $label = trim($dt->text());

        if ($label === 'E-mail Acadêmico') {
            $pai = $dt->parent();
            if ($pai) {
                $dd = $pai->first('dd');
                if ($dd) {
                    $p = $dd->first('p');
                    $email = $p ? trim($p->text()) : trim($dd->text());

                    if ($email === '' || $email === '-') {
                        return null;
                    }
                    return $email;
                }
            }
        }
    }

    return null;
}


function consultarTelefoneEstudante(string $matriculaEstudante): ?string
{
    $matriculaEstudante = trim($matriculaEstudante);

    if ($matriculaEstudante === '') {
        return null;
    }

    $URLEstudante = SUAP_BASE . '/edu/aluno/' . $matriculaEstudante . '/?tab=dados_pessoais';

    $html = suapRequest($URLEstudante);
    $document = new Document($html);

    foreach ($document->find('dt') as $dt) {
        $label = trim($dt->text());
        
        if ($label === 'Telefone Principal') {
            $pai = $dt->parent();
            if ($pai) {
                $dd = $pai->first('dd');
                if ($dd) {
                    $telefone = trim($dd->text());

                    if ($telefone === '' || $telefone === '-') {
                        return null;
                    }
                    return $telefone;
                }
            }
        }
    }

    return null;
}


$nome = consultarNomeEstudante($matriculaEstudante);
$email = consultarEmailEstudante($matriculaEstudante);
$telefone = consultarTelefoneEstudante($matriculaEstudante);
$usuario = pesquisarUsuarioId($conexao, $_SESSION['usuario']);
if (!$usuario) {
salvarUsuario($conexao, $nome, $email, $telefone, $matriculaEstudante);
}
$_SESSION["tipo"] = $usuario["admin"];
echo $nome;
echo "<br>";
echo $email;
echo "<br>";
echo $telefone;
echo "<br>";
?>