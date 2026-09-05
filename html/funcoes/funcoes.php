<?php
require_once __DIR__ . '/../conexao.php';

function verificarLogin(){
    // return isset($_SESSION['usuario']);
    if (!isset($_SESSION['usuario'])) {
        header("Location: /login/login.php");
    exit;
    }
}



function verificarAdmin()
{
    return (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1);
}
function logout()
{
    session_destroy();
}
function salvarUsuario($conexao, $nome, $email, $numero, $matricula)
{
    $sql = "INSERT INTO usuario (nome, email, numero, matricula) VALUES (?, ?, ?, ?)";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'ssss', $nome, $email, $numero, $matricula);

    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
};
function deletarUsuario($conexao, $idusuario)
{
    $sql = "DELETE FROM usuario WHERE idusuario = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idusuario);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);

    return $funcionou; //true ou false
} //testado e averiguado 100% pelo Sun

function editarUsuario($conexao, $nome, $email, $numero, $matricula , $idusuario)
{
    $sql = "UPDATE usuario SET nome=?, email=?, numero=?, matricula=? WHERE idusuario=?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'ssssi', $nome, $email, $numero, $matricula, $idusuario);

    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
};

function listarUsuario($conexao)
{
    $sql = "SELECT * FROM usuario";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $lista_usuario = [];
    while ($usuario = mysqli_fetch_assoc($resultado)) {
        $lista_usuario[] = $usuario;
    }

    mysqli_stmt_close($comando);
    return $lista_usuario;
}

function pesquisarUsuarioId($conexao, $idusuario)
{
    $sql = "SELECT * FROM usuario WHERE idusuario =?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idusuario);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $usuario = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $usuario;
};

function pesquisarUsuarioMatricula($conexao, $matricula)
{
    $sql = "SELECT * FROM usuario WHERE matricula =?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $matricula);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $usuario = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $usuario;
};


function pesquisarUsuarioNome($conexao, $nome)
{
    $sql = "SELECT * FROM usuario WHERE nome LIKE ?";
    $stmt = mysqli_prepare($conexao, $sql);
    $nomeBusca = '%' . $nome . '%';
    $stmt->bind_param("s", $nomeBusca);
    $stmt->execute();
        $resultado = $stmt->get_result();
    $lista = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $lista[] = $linha;
    }

    $stmt->close();
    return $lista;
    }


function salvarCategoria($conexao, $nome)
{
    $sql = "INSERT INTO categoria (nome) VALUES (?)";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 's', $nome);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);

    return $funcionou; //true ou false
};

function deletarCategoria($conexao, $idcategoria)
{
    $sql = "DELETE FROM categoria WHERE idcategoria = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idcategoria);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);

    return $funcionou; //true ou false
};

function editarCategoria($conexao, $nome, $idcategoria)
{
    $sql = "UPDATE categoria SET nome = ? WHERE idcategoria = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'si', $nome, $idcategoria);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
};

function listarCategorias($conexao)
{
    $sql = "SELECT * FROM categoria";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $lista_categorias = [];
    while ($categoria = mysqli_fetch_assoc($resultado)) {
        $lista_categorias[] = $categoria;
    }

    mysqli_stmt_close($comando);
    return $lista_categorias;
};


function pesquisarCategoriaId($conexao, $idcategoria)
{
    $sql = "SELECT * FROM categoria WHERE idcategoria =?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idcategoria);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $categoria = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $categoria;
};

function pesquisarCategoriaNome($conexao, $nome)
{
    $sql = "SELECT * FROM categoria WHERE nome LIKE ?";
    $stmt = mysqli_prepare($conexao, $sql);
    $nomeBusca = '%' . $nome . '%';
    $stmt->bind_param("s", $nomeBusca);
    $stmt->execute();
        $resultado = $stmt->get_result();
    $lista = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $lista[] = $linha;
    }

    $stmt->close();
    return $lista;
    }



function salvarImagem($conexao, $caminho, $idanuncio)
{
    $sql = "INSERT INTO imagem (caminho, idanuncio) VALUES (?, ?)";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'si', $caminho, $idanuncio);
    $arquivo = $_FILES['foto']['name'];

    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png'];

    if(!in_array($extensao, $permitidas)){ 
        return false;
    }

    if($arquivo['size']> 1024 * 1024 * 2){ // permite até 2MB
        return false;
    }

    $nomeArquivo = uniqid() . "_" . $arquivo['name'];
    $caminho = "/fotos" . $nomeArquivo; // uploads/capas/13516516has5_arvore.png

    if (move_uploaded_file($arquivo['tmp_name'], $caminho)){
        $funcionou = mysqli_stmt_execute($comando);
        mysqli_stmt_close($comando);
        return $caminho;
            
    }
    
};

function deletarImagem($conexao, $idimagem)
{
    $sql = "DELETE FROM imagem WHERE idimagem = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idimagem);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);

    return $funcionou; //true ou false
};

function listarImagem($conexao)
{
    $sql = "SELECT * FROM imagem";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $lista_imagens = [];
    while ($imagem = mysqli_fetch_assoc($resultado)) {
        $lista_imagens[] = $imagem;
    }

    mysqli_stmt_close($comando);
    return $lista_imagens;
};

function pesquisarImagemId($conexao, $idimagem)
{
    $sql = "SELECT * FROM imagem WHERE idimagem =?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idimagem);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $imagem = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $imagem;
};

function pesquisarImagemAnuncio($conexao, $idanuncio) {
    $sql = "SELECT * FROM imagem WHERE idanuncio =?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idanuncio);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $imagem = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $imagem;
}

function editarImagem($conexao, $caminho, $idanuncio)
{
    $sql = "UPDATE imagem SET caminho=?, idanuncio=? WHERE idimagem=?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'si', $caminho, $idanuncio);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
};
function salvarFavorito($conexao, $idusuario, $idanuncio)
{
    $sql = "INSERT INTO favorito (idusuario, idanuncio) VALUES (?,?)";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'ii', $idusuario, $idanuncio);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);

    return $funcionou; //true ou false
};

function deletarFavorito($conexao, $idusuario, $idanuncio)
{
    $sql = "DELETE FROM favorito WHERE idusuario = ? AND idanuncio = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'ii', $idusuario, $idanuncio);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);

    return $funcionou; //true ou false
};

function pesquisarFavoritoId($conexao, $idusuario, $idanuncio)
{
    $sql = "SELECT * FROM favorito WHERE idusuario = ? AND idanuncio = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'ii', $idusuario, $idanuncio);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $favorito = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $favorito;
};

function pesquisarFavoritoNome($conexao, $nome)
{
    $sql = "SELECT * FROM favorito WHERE nome LIKE ?";
    $stmt = mysqli_prepare($conexao, $sql);
    $nomeBusca = '%' . $nome . '%';
    $stmt->bind_param("s", $nomeBusca);
    $stmt->execute();
        $resultado = $stmt->get_result();
    $lista = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $lista[] = $linha;
    }

    $stmt->close();
    return $lista;
    }



function listarFavoritos($conexao)
{
    $sql = "SELECT * FROM favorito";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $lista_favoritos = [];
    while ($favorito = mysqli_fetch_assoc($resultado)) {
        $lista_favoritos[] = $favorito;
    }

    mysqli_stmt_close($comando);
    return $lista_favoritos;
};

function editarFavorito($conexao, $idusuario, $idanuncio)
{
    $sql = "UPDATE favorito SET idusuario=? , idanuncio=? WHERE idusuario = ? AND idanuncio = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'ii', $idusuario, $idanuncio);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
};

function salvarAnuncio($conexao, $titulo, $descricao, $estado, $tipo, $preco, $periodoaluguel, $troca, $idcategoria, $status, $idusuario)
{
    $sql = "INSERT INTO anuncio (titulo, descricao, estado, tipo, preco, periodoaluguel, troca, idcategoria, status, idusuario) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, 'ssssdssisi', $titulo, $descricao, $estado, $tipo, $preco, $periodoaluguel, $troca, $idcategoria, $status, $idusuario);
    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    return $funcionou;
};

function listarAnuncios($conexao)
{
    $sql = "SELECT * FROM anuncio";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $lista_anuncios = [];
    while ($anuncio = mysqli_fetch_assoc($resultado)) {
        $lista_anuncios[] = $anuncio;
    }

    mysqli_stmt_close($comando);
    return $lista_anuncios;
};

function deletarAnuncio($conexao, $idanuncio)
{
    $sql = "DELETE FROM anuncio WHERE idanuncio = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idanuncio);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);

    return $funcionou; //true ou false
};

function editarAnuncio($conexao, $titulo, $descricao, $estado, $tipo, $preco, $periodoaluguel, $troca, $idcategoria, $status, $idusuario)
{
    $sql = "UPDATE anuncio (titulo, descricao, estado, tipo, preco, periodoaluguel, troca, idcategoria, status, idusuario) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, 'ssssdssisi', $titulo, $descricao, $estado, $tipo, $preco, $periodoaluguel, $troca, $idcategoria, $status, $idusuario);
    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    return $funcionou;
};

function pesquisarAnuncioId($conexao, $idanuncio)
{
    $sql = "SELECT * FROM anuncio WHERE idanuncio =?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idanuncio);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $anuncio = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $anuncio;
};

function pesquisarAnuncioNome($conexao, $nome)
{
    $sql = "SELECT * FROM anuncio WHERE nome LIKE ?";
    $stmt = mysqli_prepare($conexao, $sql);
    $nomeBusca = '%' . $nome . '%';
    $stmt->bind_param("s", $nomeBusca);
    $stmt->execute();
        $resultado = $stmt->get_result();
    $lista = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $lista[] = $linha;
    }

    $stmt->close();
    return $lista;
    }



function filtrarAnuncios($conexao, $filtragem, $filtro) {
    if (!in_array($filtragem, ["tipo", "categoria", "id_anunciante", "preco"])) {
        return;
    }
    if ($filtragem = "id_anunciante") {
    $sql = "SELECT * FROM anuncio WHERE idusuario = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    $stmt->bind_param("i", $filtro);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $lista = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $lista[] = $linha;
    }

    $stmt->close();
    return $lista;
    }

}

function Anunciosformatados($conexao, $anuncios) { # tem que ser array por favor lembra disso

if (!isset($_GET["pagina"])) {
$_GET["pagina"] = 1;
}
$numero_pg = ($_GET["pagina"] * 8) ?? 8;
$i = $numero_pg - 8;

if ($i > 0) { # se for maior que 0 significa que não tá na pagina 1, e não pode começar no endereço 8 pq já é o ultimo da pg 1
    $i++;
}
if ($numero_pg >= sizeof($anuncios)) { #o ultimo  endereço for maior ou igual a ao tamnho do array significa que o ultimo endereço tá fora do range do array, e  o ultimo endereço tem que ser == tamanho do array - 1
    $numero_pg = sizeof($anuncios) - 1;
}

while ($i <= $numero_pg) {
    
    $anuncio = $anuncios[$i];

    $i++;

    $id = $anuncio['idanuncio'];
    $titulo = $anuncio['titulo'];
    $descricao = $anuncio['descricao'];
    $estado = $anuncio['estado'];
    $tipo = $anuncio['tipo'];
    $preco = $anuncio['preco'];
    $periodoaluguel = $anuncio['periodoaluguel'] ?? "";
    $troca = $anuncio['troca'];
    $status = $anuncio['status'];
    $datahora = date('d/m/Y H:i', strtotime($anuncio['datahora']));


    $idcategoria = $anuncio['idcategoria'];
    $categoria = pesquisarCategoriaId($conexao, $idcategoria);

    $idusuario = $anuncio['idusuario'];
    $usuario = pesquisarUsuarioId($conexao, $idusuario);

    $imagem = pesquisarImagemAnuncio($conexao, $id);
    $imagem = $imagem["caminho"] ?? "sem imagem";
    

    echo "
                    <a href='produto/produto.php?id=". $id ."' class='card-produto'>
                        <div class='foto-placeholder'><img src='/imagens/" . $imagem . "' alt='sem imagem'></div>
                        <div class='info-card'>
                            <span class='tipo-badge badge-venda'>".$tipo."</span>
                            <div class='titulo-card'>".$titulo."</div>
                            <div class='preco-card'>R$ ".$preco."</div>
                            <div class='campus-card'>".$datahora."</div>
                        </div>
                    </a>
                
    ";
}
}

function barraNavegacao($anuncios) {   
if (!isset($_GET["pagina"])) {
$_GET["pagina"] = 1;
}
    $pg_atual = $_GET["pagina"] ?? 1;

    // 1. Copiamos o $_GET atual para uma nova variável
    $parametros = $_GET;

    $paginas = intdiv(sizeof($anuncios), 9); # cada pagina suporta 9 anuncios, essa linha faz a conta de quantas paginas completas existem para a quantidade de anuncios

    $f = intdiv($pg_atual, 10) *  10; #$f é o inicio, quero deixar 10 botoes de navegação por vez então começa no inicio de uma dezena

    $final = (intdiv($pg_atual, 10) + 1) * 10; # aqui calcula o final da dezena

    if ($pg_atual % 10 == 0) { #aqui é caso a pagina atual seja um numero razo como 10 20 30 40
        $final = $pg_atual;
        $f = (intdiv($pg_atual, 10) - 1) * 10;
    }

    if ($f == 0) {
            // 2. Alteramos apenas o valor da página para o botão que queremos criar (ex: página 5)
            $parametros['pagina'] = 1;

            // 3. Transformamos o array de volta em string para usar no href
            // O http_build_query vai gerar: ""
            $linkGerado = '?' . http_build_query($parametros);

        echo '<a href="'.$linkGerado.'" class="btn btn-outline">&lt;</a>'; # &lt é <
    } else {
            $parametros['pagina'] = $f-9;

            // 3. Transformamos o array de volta em string para usar no href
            // O http_build_query vai gerar: ""
            $linkGerado = '?' . http_build_query($parametros);

        echo '<a href="'.$linkGerado.'" class="btn btn-outline">&lt;</a>'; # &lt é <
    }
    
    while ($f < $paginas && $f < $final) {
        $f++;

        $parametros['pagina'] = $f;

            // 3. Transformamos o array de volta em string para usar no href
            // O http_build_query vai gerar: o link
        $linkGerado = '?' . http_build_query($parametros);
        if ($f == $pg_atual) {
            echo '<a href="'.$linkGerado.'" class="btn btn btn-verde">'.$f.'</a>';
            continue;
        }
        echo '<a href="'.$linkGerado.'" class="btn btn-outline">'.$f.'</a>';
    }

    if ($f != $final && (sizeof($anuncios) % 9) > 0) { #se $f != $final é por que se acabaram as paginas completas com nove anuncios e caso tenha um resto significa que tem mais uma pagina com menos de nove anuncios para ser exibida
        $f++;
        $parametros['pagina'] = $f;
        $linkGerado = '?' . http_build_query($parametros);
        if ($f == $pg_atual) {
            echo '<a href="'.$linkGerado.'" class="btn btn btn-verde">'.$f.'</a>';
        } else {
        echo '<a href="'.$linkGerado.'" class="btn btn-outline">'.$f.'</a>';
        }
    }

    if ($f < $paginas) {

            // 2. Alteramos apenas o valor da página para o botão que queremos criar (ex: página 5)
            $parametros['pagina'] = $f+1;

            // 3. Transformamos o array de volta em string para usar no href
            // O http_build_query vai gerar: ""
            $linkGerado = '?' . http_build_query($parametros);

        echo '<a href="'.$linkGerado.'" class="btn btn-outline">&gt;</a>'; # &gt é >
    } 
    else {
            // 2. Alteramos apenas o valor da página para o botão que queremos criar (ex: página 5)
            $parametros['pagina'] = $f;

            // 3. Transformamos o array de volta em string para usar no href
            // O http_build_query vai gerar: ""
            $linkGerado = '?' . http_build_query($parametros);

        echo '<a href="'.$linkGerado.'" class="btn btn-outline">&gt;</a>'; # &gt é >
    }

}