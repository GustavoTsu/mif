<?php
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";

$idanuncio = $_GET['idanuncio'];

deletarAnuncio($conexao, $idanuncio);

header('Location: ../index.php');
exit;