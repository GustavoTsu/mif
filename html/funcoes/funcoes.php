<?php
require_once 'conexao.php';
function verificarLogin()
{
    return isset($_SESSION['usuario']);
}
function verificarAdmin()
{
    return (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'admin');
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

function pequisarUsuarioNome($conexao, $nome)
{
    $sql = "SELECT * FROM usuario WHERE nome LIKE ?";
    $stmt = mysqli_prepare($conexao, $sql);
    $nomeBusca = '%' . $nome . '%';
    $stmt->bind_param("s", $nomeBusca);
    $stmt->execute();
    return $stmt->get_result();
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
    return $stmt->get_result();
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

    mysqli_stmt_bind_param($comando, 'i', $idusuario, $idanuncio);

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
    return $stmt->get_result();
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
        $lista_vendas[] = $anuncio;
    }

    mysqli_stmt_close($comando);
    return $lista_vendas;
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
    return $stmt->get_result();
}
