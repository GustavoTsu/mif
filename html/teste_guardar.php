<?php
require_once 'conexao.php';
require_once 'funcoes/funcoes.php';


//TESTE DELETAR USUARIO: OK
$idUsuario = 1;

$resultado = deletarUsuario($conexao, $idUsuario);
if ($resultado) {
    echo "Removido";
}
else {
    echo "error";
}

//TESTE LISTAR USUARIO; OK


$resultado = listarusuario($conexao);
if ($resultado) {
    echo "<pre>";
    print_r($resultado);
    echo "</pre";

}
else {
    echo "erro";
}




















































































































?>