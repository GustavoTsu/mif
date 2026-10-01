<?php
session_start();
require_once "../funcoes/funcoes.php";
verificarLogin();



$id_usuario = 1;
if (isset($_GET["id"])) {
    $id_usuario = $_GET["id"];
}
$anuncios = filtrarAnuncios($conexao, "id_anunciante", $id_usuario);

$usuario = pesquisarUsuarioId($conexao, $id_usuario) ?? pesquisarAnuncioId($conexao, 1);


$id = $usuario['idusuario'];
$nome = $usuario['nome'];
$numero = $usuario['numero'];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>João Silva — Perfil — MIF</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<header>
    <a href="/index.php" class="logo">M<span>IF</span></a>
    <form id="formbusca" class="barra-busca" action="/index.php" method="GET">
        <input id="busca" name="busca" type="text" placeholder="Buscar produtos">
        <button type="submit">Buscar</button>
    </form>
    <nav>
        <a href="/produto/cadastro-produto.php" class="btn-anunciar">+ Anunciar</a>
    </nav>
</header>

<div class="container">
    

    <div class="perfil-vendedor-topo">
        <div class="avatar-grande"><?php echo $nome[0]; ?></div>
        <div class="dados-vendedor flex-1">
            <h1><?php echo $nome; ?></h1>
           
            <div class="stats">
                <div class="stat-item">
                    <div class="stat-numero"><?php echo sizeof($anuncios); ?></div>
                    <div class="stat-label">Anúncios</div>
                </div>
            </div>
        </div>

        <div class="flex flex-column gap-10 align-end">
            <div class="text-big text-verde text-right">Contato: <?php echo $numero; ?></div>
        </div>
    </div>

    <!-- ABAS QUE CONTROLAM O IFRAME -->
    <div class="tabs-iframe">
        <span class="tab-item">Anúncios<span class="badge-count"><?php echo sizeof($anuncios); ?></span></span>
    </div>

    <!-- IFRAME CENTRALIZADO -->
<div class="iframe-body" style="background: #fff; padding: 20px;">
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
</div>
</div>

<footer>
    <p>MIF &mdash; Marketplace do Instituto Federal Goiano &copy; 2025</p>
</footer>

</body>
</html>
