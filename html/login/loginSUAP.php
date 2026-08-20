<?php
    session_start();
    require_once "funcoes/funcoes.php";
    require_once "conexao.php";


    if (!empty($_POST['matriculaUsuario']) && !empty($_POST['senhaUsuario'])) {
        $matriculaUsuario = filter_input(INPUT_POST, 'matriculaUsuario', FILTER_UNSAFE_RAW);
        $senhaUsuario = filter_input(INPUT_POST, 'senhaUsuario', FILTER_UNSAFE_RAW);

        $apiSuap = 'https://suap.ifgoiano.edu.br/api/token/pair';
        
        $dadosUsuario = json_encode([
            'username' => $matriculaUsuario,
            'password' => $senhaUsuario],
            JSON_UNESCAPED_UNICODE
        );

        $curlSession = curl_init($apiSuap);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_POST, true);
        curl_setopt($curlSession, CURLOPT_POSTFIELDS, $dadosUsuario);
        curl_setopt($curlSession, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curlSession, CURLOPT_TIMEOUT, 30);

        $responseSession = curl_exec($curlSession);

        $httpCode = curl_getinfo($curlSession, CURLINFO_HTTP_CODE);
        curl_close($curlSession);

        if ($httpCode == 200) {

            $result = json_decode($responseSession, true);
            $token = $result['access'] ?? null;


            if ($token) {
                $_SESSION['usuarioLogado'] = true;
                $_SESSION['usuario'] = $_POST['matriculaUsuario'];
                $_SESSION['senha'] = $_POST['senhaUsuario'];
                

                header("Location: index.php?login=deucerto"); // Redirecionar para a página principal
                exit;
            } else {
                header("Location: index.php?msg=Ocorreu um erro durante a autenticação no SUAP.");
                exit;
            }
        } else if ($httpCode == 401) {
            header("Location: index.php?msg=Usuário ou senha incorretos.");
            exit;
        } else {
            header("Location: index.php?msg=Ocorreu um erro interno do SUAP ao processar o login.");
            exit;
        }
    } else {
        header("Location: index.php?msg=Informe os dados de acesso.");
        exit;
    }
?>