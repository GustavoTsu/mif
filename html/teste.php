<?php
require_once 'conexao.php';
require_once 'funcoes/funcoes.php';


$nome = "carro";

$resultado = salvarFavorito($conexao, $nome);
if ($resultado) {
     echo "usuario salvo";
}
else {
    echo "error";
}
?>