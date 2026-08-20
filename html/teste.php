<?php

require_once 'conexao.php';
require_once 'funcoes/funcoes.php'; 
$quebra = PHP_SAPI === 'cli' ? PHP_EOL : '<br>';

function verificarLogin(){
    // return isset($_SESSION['usuario']);
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
    exit;
    }
}

// =====================================================
// USUÁRIO
// =====================================================

$nome = 'Usuario teste';
$email = 'teste@teste.com';
$num = '123456789';
$matricula = '123123';
$admin = '0';

// A função enviada recebe 5 parâmetros. O campo admin possui valor padrão 0 no banco.
$resultado = salvarUsuario($conexao, $nome, $email, $num, $matricula);
if ($resultado) {
    echo 'salvarUsuario: funcionou' . $quebra;
} else {
    echo 'salvarUsuario: erro' . $quebra;
}

$idusuario = $conexao->insert_id;

$resultado = pesquisarUsuarioId($conexao, $idusuario);
if ($resultado) {
    echo 'pesquisarUsuarioId: funcionou' . $quebra;
} else {
    echo 'pesquisarUsuarioId: erro' . $quebra;
}

$resultado = pequisarUsuarioNome($conexao, $nome);
if ($resultado && $resultado->num_rows > 0) {
    echo 'pequisarUsuarioNome: funcionou' . $quebra;
} else {
    echo 'pequisarUsuarioNome: erro' . $quebra;
}

$resultado = listarUsuario($conexao);
if (is_array($resultado)) {
    echo 'listarUsuario: funcionou' . $quebra;
} else {
    echo 'listarUsuario: erro' . $quebra;
}

$nomeEditado = 'Usuario teste editado';
$resultado = editarUsuario($conexao, $nomeEditado, $email, $num, $matricula, $idusuario);
if ($resultado) {
    echo 'editarUsuario: funcionou' . $quebra;
} else {
    echo 'editarUsuario: erro' . $quebra;
}

// =====================================================
// CATEGORIA
// =====================================================

$nomeCategoria = 'Categoria teste ' . time();

$resultado = salvarCategoria($conexao, $nomeCategoria);
if ($resultado) {
    echo 'salvarCategoria: funcionou' . $quebra;
} else {
    echo 'salvarCategoria: erro' . $quebra;
}

$idcategoria = $conexao->insert_id;

$resultado = pesquisarCategoriaId($conexao, $idcategoria);
if ($resultado) {
    echo 'pesquisarCategoriaId: funcionou' . $quebra;
} else {
    echo 'pesquisarCategoriaId: erro' . $quebra;
}

$resultado = pesquisarCategoriaNome($conexao, $nomeCategoria);
if ($resultado && $resultado->num_rows > 0) {
    echo 'pesquisarCategoriaNome: funcionou' . $quebra;
} else {
    echo 'pesquisarCategoriaNome: erro' . $quebra;
}

$resultado = listarCategorias($conexao);
if (is_array($resultado)) {
    echo 'listarCategorias: funcionou' . $quebra;
} else {
    echo 'listarCategorias: erro' . $quebra;
}

$resultado = editarCategoria($conexao, $nomeCategoria . ' editada', $idcategoria);
if ($resultado) {
    echo 'editarCategoria: funcionou' . $quebra;
} else {
    echo 'editarCategoria: erro' . $quebra;
}

// =====================================================
// ANÚNCIO
// =====================================================

$titulo = 'Anuncio teste ' . time();
$descricao = 'Descricao do anuncio de teste';
$estado = 'Bom';
$tipo = 'Venda';
$preco = 100.00;
$periodoaluguel = 'Mensal';
$troca = 'Nao';
$status = 'Ativo';

$resultado = salvarAnuncio(
    $conexao,
    $titulo,
    $descricao,
    $estado,
    $tipo,
    $preco,
    $periodoaluguel,
    $troca,
    $idcategoria,
    $status,
    $idusuario
);
if ($resultado) {
    echo 'salvarAnuncio: funcionou' . $quebra;
} else {
    echo 'salvarAnuncio: erro' . $quebra;
}

$idanuncio = $conexao->insert_id;

$resultado = pesquisarAnuncioId($conexao, $idanuncio);
if ($resultado) {
    echo 'pesquisarAnuncioId: funcionou' . $quebra;
} else {
    echo 'pesquisarAnuncioId: erro' . $quebra;
}

$resultado = listarAnuncios($conexao);
if (is_array($resultado)) {
    echo 'listarAnuncios: funcionou' . $quebra;
} else {
    echo 'listarAnuncios: erro' . $quebra;
}

// =====================================================
// FAVORITO
// =====================================================

$resultado = salvarFavorito($conexao, $idusuario, $idanuncio);
if ($resultado) {
    echo 'salvarFavorito: funcionou' . $quebra;
} else {
    echo 'salvarFavorito: erro' . $quebra;
}

$resultado = pesquisarFavoritoId($conexao, $idusuario, $idanuncio);
if ($resultado) {
    echo 'pesquisarFavoritoId: funcionou' . $quebra;
} else {
    echo 'pesquisarFavoritoId: erro' . $quebra;
}

$resultado = listarFavoritos($conexao);
if (is_array($resultado)) {
    echo 'listarFavoritos: funcionou' . $quebra;
} else {
    echo 'listarFavoritos: erro' . $quebra;
}

$resultado = deletarFavorito($conexao, $idusuario, $idanuncio);
if ($resultado) {
    echo 'deletarFavorito: funcionou' . $quebra;
} else {
    echo 'deletarFavorito: erro' . $quebra;
}

// =====================================================
// IMAGEM
// =====================================================

$resultado = listarImagem($conexao);
if (is_array($resultado)) {
    echo 'listarImagem: funcionou' . $quebra;
} else {
    echo 'listarImagem: erro' . $quebra;
}

$resultado = pesquisarImagemId($conexao, 999999);
if ($resultado === null) {
    echo 'pesquisarImagemId: funcionou' . $quebra;
} else {
    echo 'pesquisarImagemId: erro' . $quebra;
}

// =====================================================
// EXCLUSÃO DOS DADOS CRIADOS PELO TESTE
// =====================================================

$resultado = deletarAnuncio($conexao, $idanuncio);
if ($resultado) {
    echo 'deletarAnuncio: funcionou' . $quebra;
} else {
    echo 'deletarAnuncio: erro' . $quebra;
}

$resultado = deletarCategoria($conexao, $idcategoria);
if ($resultado) {
    echo 'deletarCategoria: funcionou' . $quebra;
} else {
    echo 'deletarCategoria: erro' . $quebra;
}

$resultado = deletarUsuario($conexao, $idusuario);
if ($resultado) {
    echo 'deletarUsuario: funcionou' . $quebra;
} else {
    echo 'deletarUsuario: erro' . $quebra;
}

?>
