<?php

function deletarUsuario($conexao, $idusuario) {
    $sql = "DELETE FROM usuario WHERE idusuario = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idusuario);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    
    return $funcionou; //true ou false
}

function listarusuario($conexao) {
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

function salvarUsuario($conexao, $nome, $email, $numero, $matricula) {
    $sql = "INSERT INTO usuario (nome, email, numero, matricula, admin) VALUES (?, ?, ?, ?, ?)";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'sssss', $nome, $email, $numero, $matricula);
    
    $funcionou = mysqli_stmt_execute($comando);
    
    mysqli_stmt_close($comando);
    return $funcionou;
};

function editarUsuario($conexao, $nome, $email, $numero, $matricula, $idusuario) {
    $sql = "UPDATE usuario SET nome=?, email=?, numero=?, matricula=? admin=? WHERE idusuario=?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'sssssi', $nome, $email, $numero, $matricula, $idusuario);
    
    $funcionou = mysqli_stmt_execute($comando);
    
    mysqli_stmt_close($comando);
    return $funcionou;
};

function deletarFavorito($conexao, $idusuario, $idanuncio) {
    $sql = "DELETE FROM favorito WHERE idusuario = ? AND idanuncio = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'ii', $idusuario, $idanuncio);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    
    return $funcionou; //true ou false
};

function listarFavoritos($conexao) {
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

function salvarFavorito($conexao, $idusuario, $idanuncio) {
    $sql = "INSERT INTO favorito (idusuario, idanuncio) VALUES (?,?)";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'ii', $idusuario, $idanuncio);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    
    return $funcionou; //true ou false
};


function editarFavorito($conexao, $idusuario, $idanuncio) {
    $sql = "UPDATE favorito SET idusuario=? , idanuncio=? WHERE idusuario = ? AND idanuncio = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando,'ii', $idusuario, $idanuncio);
    $funcionou = mysqli_stmt_execute($comando);
    
    mysqli_stmt_close($comando);
    return $funcionou;
};

function deletarAnuncio($conexao, $idanuncio) {
    $sql = "DELETE FROM favorito WHERE idanuncio = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idanuncio);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    
    return $funcionou; //true ou false
};


function listarAnuncios($conexao) {
    $sql = "SELECT * FROM anuncio";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $lista_anuncios = [];
    while ($anuncio = mysqli_fetch_assoc($resultado)) {
        $lista_vendas[] = $anuncio;
    }

    mysqli_stmt_close($comando);
    return $lista_vendas;
};



function salvarAnuncio($conexao, $titulo, $descricao, $estado, $tipo, $preco, $periodoaluguel, $troca, $idcategoria, $status, $idusuario){
    $sql= "INSERT INTO anuncio (titulo, descricao, estado, tipo, preco, periodoaluguel, troca, idcategoria, status, idusuario) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, 'ssssdssisi', $titulo, $descricao, $estado, $tipo, $preco, $periodoaluguel, $troca, $idcategoria, $status, $idusuario);
    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    return $funcionou;
};

function editarAnuncio($conexao, $titulo, $descricao, $estado, $tipo, $preco, $periodoaluguel, $troca, $idcategoria, $status, $idusuario){
    $sql= "UPDATE anuncio (titulo, descricao, estado, tipo, preco, periodoaluguel, troca, idcategoria, status, idusuario) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, 'ssssdssisi', $titulo, $descricao, $estado, $tipo, $preco, $periodoaluguel, $troca, $idcategoria, $status, $idusuario);
    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    return $funcionou;
};



function listarImagem($conexao) {
    $sql = "SELECT * FROM imagem";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $lista_anuncios = [];
    while ($anuncio = mysqli_fetch_assoc($resultado)) {
        $lista_vendas[] = $anuncio;
    }

    mysqli_stmt_close($comando);
    return $lista_vendas;
};

function listarCategorias($conexao) {
    $sql = "SELECT * FROM categoria";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $lista_anuncios = [];
    while ($anuncio = mysqli_fetch_assoc($resultado)) {
        $lista_vendas[] = $anuncio;
    }

    mysqli_stmt_close($comando);
    return $lista_vendas;
};

function deletarCategoria($conexao, $idcategoria) {
    $sql = "DELETE FROM favorito WHERE $idcategoria = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idcategoria);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    
    return $funcionou; //true ou false
};

function salvarCategoria($conexao, $nome) {
    $sql = "INSERT INTO favorito (nome) VALUES (?)";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 's', $nome);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    
    return $funcionou; //true ou false
};


function editarCategoria($conexao, $nome, $idcategoria) {
    $sql = "UPDATE favorito SET nome = ? WHERE idcategoria = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'si', $nome, $idcategoria);
    $funcionou = mysqli_stmt_execute($comando);
    
    mysqli_stmt_close($comando);
    return $funcionou;
};




function pesquisarUsuarioId($conexao, $idusuario){
$sql = "SELECT * FROM usuario WHERE idusuario =?";
$comando = mysqli_prepare($conexao, $sql);

mysqli_stmt_bind_param($comando, 'i', $idusuario);

mysqli_stmt_execute($comando);
$resultado = mysqli_stmt_get_result($comando);

$usuario = mysqli_fetch_assoc($resultado);

mysqli_stmt_close($comando);
return $usuario;

};

function pesquisarAnuncioId($conexao,$idanuncio) {
$sql = "SELECT * FROM anuncio WHERE idanuncio =?";
$comando = mysqli_prepare($conexao, $sql);
    
mysqli_stmt_bind_param($comando, 'i', $idanuncio);
    
mysqli_stmt_execute($comando);
$resultado = mysqli_stmt_get_result($comando);
    
$anuncio = mysqli_fetch_assoc($resultado);
    
mysqli_stmt_close($comando);
return $anuncio;
};

function pesquisarfavoritoId($conexao, $idusuario, $idanuncio) {
$sql = "SELECT * FROM favorito WHERE idusuario = ? AND idanuncio = ?";
$comando = mysqli_prepare($conexao, $sql);
    
mysqli_stmt_bind_param($comando, 'i', $idusuario, $idanuncio);
    
mysqli_stmt_execute($comando);
$resultado = mysqli_stmt_get_result($comando);
    
$favorito = mysqli_fetch_assoc($resultado);
    
mysqli_stmt_close($comando);
return $favorito;
};

function pesquisarImagemId($conexao,$idimagem) {
$sql = "SELECT * FROM imagem WHERE idimagem =?";
$comando = mysqli_prepare($conexao, $sql);
    
mysqli_stmt_bind_param($comando, 'i', $idimagem);
    
mysqli_stmt_execute($comando);
$resultado = mysqli_stmt_get_result($comando);
    
$imagem = mysqli_fetch_assoc($resultado);
    
mysqli_stmt_close($comando);
return $imagem;
};

function pesquisarcategoriaId($conexao,$idcategoria) {
$sql = "SELECT * FROM categoria WHERE idcategoria =?";
$comando = mysqli_prepare($conexao, $sql);
    
mysqli_stmt_bind_param($comando, 'i', $idcategoria);
    
mysqli_stmt_execute($comando);
$resultado = mysqli_stmt_get_result($comando);
    
$categoria = mysqli_fetch_assoc($resultado);
    
mysqli_stmt_close($comando);
return $categoria;
};


?>