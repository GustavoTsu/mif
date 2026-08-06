<?php
require_once 'conexao.php';
require_once 'funcoes/funcoes.php';

$idUsuario = 1;

$resultado = deletarUsuario($conexao, $idUsuario);
if ($resultado) {
    echo "Removido";
}
else {
    echo "error";
}
?>