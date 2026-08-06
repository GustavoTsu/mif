<?php
// dados para conectar no banco de dados
$servidor = "db";
$usuario = "root";
$senha = "123";  
$banco = "banco";

// isso é uma função que se conecta ao banco
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
?>