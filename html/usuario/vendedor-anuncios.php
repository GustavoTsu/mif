<?php
session_start();
require_once "../funcoes/funcoes.php";
verificarLogin();
$anuncios = filtrarAnuncios($conexao, "id_anunciante", $idusuario);
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
        <div class="area-resultados">
            <div class="mt-24 text-center">
                <?php
                    barraNavegacao($anuncios)
                ?>
            </div>

            <div class="grid-produtos">
                <?php
                    Anunciosformatados($conexao, $anuncios)
                ?>
            </div>

            <div class="mt-24 text-center">
                <?php
                    barraNavegacao($anuncios)
                ?>
            </div>
        </div>
</body>
</html>
