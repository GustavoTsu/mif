<?php
require_once 'conexao.php';
require_once 'funcoes/funcoes.php';



$resultado = listarCategorias($conexao);
if ($resultado) {
    print_r($resultado);
    echo "</pre";

}
else {
    echo "erro";
}
?>
