<?php 

require_once 'conexao.php';
require_once 'funcoes/funcoes.php';
verificarLogin();

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$estado = $_POST['estado'];
$tipo = $_POST['tipo'];
$preco = $_POST['preco'];
$periodoaluguel = $_POST['periodo_aluguel'];
$fotos = $_FILES['fotos'];

$troca = isset($_POST['troca']) ? 1 : 0;
$idcategoria = $_POST['categoria'];
$status = 1;
$idusuario = $_SESSION['idusuario'];
$datahora = date('Y-m-d H:i:s');

if (isset($_FILES['imagens'])) {
    $imagens = $_FILES['imagens'];
} else {
    $imagens = null;
}

if ($id == 0) {
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
        echo 'Anúncio publicado com sucesso!';
    } else {
      $resultado = editarAnuncio(
        $conexao,
        $id,
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
}
}

?>  