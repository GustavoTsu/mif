<?php
session_start();
require_once "funcoes/funcoes.php";
verificarLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Anúncios do Vendedor</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body class="iframe-body" style="background: #fff; padding: 20px;">
    <div class="categorias mb-16">
        <a href="#" class="categoria-item ativa">Todos</a>
        <a href="#" class="categoria-item">Venda</a>
        <a href="#" class="categoria-item">Aluguel</a>
    </div>
    <div class="grid-produtos">
        <a href="/produto/produto.php" target="_parent" class="card-produto">
            <div class="foto-placeholder">Sem foto</div>
            <div class="info-card">
                <span class="tipo-badge badge-venda">Venda</span>
                <div class="titulo-card">Jaleco de laboratório M</div>
                <div class="preco-card">R$ 35,00</div>
            </div>
        </a>
    </div>
</body>
</html>
