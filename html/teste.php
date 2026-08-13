<?php
require_once 'conexao.php';
require_once 'funcoes/funcoes.php';


$n = "carro";

$resultado = salvarAnuncio($conexao, $titulo, $descricao, $estado, $tipo, $preco, $periodoaluguel, $troca, $idcategoria, $status, $idusuario);
if ($resultado) {
     echo "usuario salvo";
}
else {
    echo "error";
}
?>