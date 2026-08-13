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


$nome = "teste2" ;
$email = "teste@teste";
$num = "123456789";
$matricula = "123123";
$admin = "0";

$resultado = salvarUsuario($conexao, $nome, $email, $num, $matricula, $admin) ;
if ($resultado) {
     echo "usuario salvo";
}
else {
    echo "error";
}


$email = "teste5@teste";


$resultado = editarUsuario($conexao, $email);
if ($resultado) {
     echo "usuario atualizadp";
}
else {
    echo "error";
}


$resultado = listarCategorias($conexao);
if ($resultado) {
echo "<pre>";
    print_r($resultado);
    echo "</pre";

}
else {
    echo "erro";
}













































































?>  