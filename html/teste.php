<?php

require_once 'conexao.php';
require_once 'funcoes/funcoes.php'; 

verificarLogin();


// USUÁRIO


$nome = 'Usuario teste';
$email = 'teste@teste.com';
$num = '123456789';
$matricula = '123123';
$admin = '0';

// A função enviada recebe 5 parâmetros. O campo admin possui valor padrão 0 no banco.
$resultado = salvarUsuario($conexao, $nome, $email, $num, $matricula);
if ($resultado) {
    echo 'salvarUsuario: funcionou <br>';
} else {
    echo 'salvarUsuario: erro <br>';
}

$idusuario = mysqli_insert_id($conexao);

$resultado = pesquisarUsuarioId($conexao, $idusuario);
if ($resultado) {
    echo 'pesquisarUsuarioId: funcionou <br>';
} else {
    echo 'pesquisarUsuarioId: erro <br>';
}

$resultado = pesquisarUsuarioMatricula($conexao, $matricula);
if ($resultado) {
    echo 'pesquisarUsuarioId: funcionou <br>';
} else {
    echo 'pesquisarUsuarioId: erro <br>';
}


$resultado = pesquisarUsuarioNome($conexao, $nome);
if ($resultado && mysqli_num_rows($resultado) > 0) {
    echo 'pequisarUsuarioNome: funcionou <br>';
} else {
    echo 'pequisarUsuarioNome: erro <br>';
}

$resultado = listarUsuario($conexao);
if (is_array($resultado)) {
    echo 'listarUsuario: funcionou <br>';
} else {
    echo 'listarUsuario: erro <br>';
}

$nomeEditado = 'Usuario teste editado';
$resultado = editarUsuario($conexao, $nomeEditado, $email, $num, $matricula, $idusuario);
if ($resultado) {
    echo 'editarUsuario: funcionou <br>';
} else {
    echo 'editarUsuario: erro <br>';
}


// CATEGORIA


$nomeCategoria = 'Categoria teste ' ;

$resultado = salvarCategoria($conexao, $nomeCategoria);
if ($resultado) {
    echo 'salvarCategoria: funcionou <br>';
} else {
    echo 'salvarCategoria: erro <br>';
}

$idcategoria = mysqli_insert_id($conexao);

$resultado = pesquisarCategoriaId($conexao, $idcategoria);
if ($resultado) {
    echo 'pesquisarCategoriaId: funcionou <br>';
} else {
    echo 'pesquisarCategoriaId: erro <br>';
}

$resultado = pesquisarCategoriaNome($conexao, $nomeCategoria);
if ($resultado && mysqli_num_rows($resultado) > 0) {
    echo 'pesquisarCategoriaNome: funcionou <br>';
} else {
    echo 'pesquisarCategoriaNome: erro <br>';
}

$resultado = listarCategorias($conexao);
if (is_array($resultado)) {
    echo 'listarCategorias: funcionou <br>';
} else {
    echo 'listarCategorias: erro <br>';
}

$resultado = editarCategoria($conexao, $nomeCategoria . ' editada', $idcategoria);
if ($resultado) {
    echo 'editarCategoria: funcionou <br>';
} else {
    echo 'editarCategoria: erro <br>';
}


// ANÚNCIO


$titulo = 'Anuncio teste ' ;
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
    echo 'salvarAnuncio: funcionou <br>';
} else {
    echo 'salvarAnuncio: erro <br>';
}

$idanuncio = mysqli_insert_id($conexao);

$resultado = pesquisarAnuncioId($conexao, $idanuncio);
if ($resultado) {
    echo 'pesquisarAnuncioId: funcionou <br>';
} else {
    echo 'pesquisarAnuncioId: erro <br>';
}

$resultado = listarAnuncios($conexao);
if (is_array($resultado)) {
    echo 'listarAnuncios: funcionou <br>';
} else {
    echo 'listarAnuncios: erro <br>';
}


// FAVORITO


$resultado = salvarFavorito($conexao, $idusuario, $idanuncio);
if ($resultado) {
    echo 'salvarFavorito: funcionou <br>';
} else {
    echo 'salvarFavorito: erro <br>';
}

$resultado = pesquisarFavoritoId($conexao, $idusuario, $idanuncio);
if ($resultado) {
    echo 'pesquisarFavoritoId: funcionou <br>';
} else {
    echo 'pesquisarFavoritoId: erro <br>';
}

$resultado = listarFavoritos($conexao);
if (is_array($resultado)) {
    echo 'listarFavoritos: funcionou <br>';
} else {
    echo 'listarFavoritos: erro <br>';
}

$resultado = deletarFavorito($conexao, $idusuario, $idanuncio);
if ($resultado) {
    echo 'deletarFavorito: funcionou <br>';
} else {
    echo 'deletarFavorito: erro <br>';
}


// IMAGEM


$resultado = listarImagem($conexao);
if (is_array($resultado)) {
    echo 'listarImagem: funcionou <br>';
} else {
    echo 'listarImagem: erro <br>';
}

$resultado = pesquisarImagemId($conexao, 999999);
if ($resultado === null) {
    echo 'pesquisarImagemId: funcionou <br>';
} else {
    echo 'pesquisarImagemId: erro <br>';
}


// EXCLUSÃO DOS DADOS CRIADOS PELO TESTE


$resultado = deletarAnuncio($conexao, $idanuncio);
if ($resultado) {
    echo 'deletarAnuncio: funcionou <br>';
} else {
    echo 'deletarAnuncio: erro <br>';
}

$resultado = deletarCategoria($conexao, $idcategoria);
if ($resultado) {
    echo 'deletarCategoria: funcionou <br>';
} else {
    echo 'deletarCategoria: erro <br>';
}

$resultado = deletarUsuario($conexao, $idusuario);
if ($resultado) {
    echo 'deletarUsuario: funcionou <br>';
} else {
    echo 'deletarUsuario: erro <br>';
}

?>
