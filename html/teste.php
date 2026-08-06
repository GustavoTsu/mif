<?php
require_once 'conexao.php';
require_once 'funcoes/funcoes.php';

$id = 1 ;

$resultado = pesquisarUsuarioId($conexao, $id) ;
if ($resultado) {
     print_r($resultado);
}
else {
    echo "error";
}
?>