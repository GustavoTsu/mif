<?php
session_start();
require_once "../funcoes/funcoes.php";
verificarLogin();
if(!isset($_GET["id"])) {
    header("location: ../index.php");
}


$tipo = "id_vendedor";
$id_anuncio = $_GET["id"];

$anuncio = pesquisarAnuncioId($conexao, $id_anuncio) ?? pesquisarAnuncioId($conexao, 1);

$id = $anuncio['idanuncio'];
$titulo = $anuncio['titulo'];
$descricao = $anuncio['descricao'];
$estado = $anuncio['estado'];
$tipo = $anuncio['tipo'];
$preco = $anuncio['preco'];
$periodoaluguel = $anuncio['periodoaluguel'] ?? "";
$troca = $anuncio['troca'];
$status = $anuncio['status'];
$datahora = date('d/m/Y H:i', strtotime($anuncio['datahora']));


$idcategoria = $anuncio['idcategoria'];
$categoria = pesquisarCategoriaId($conexao, $idcategoria);
$nomeCategoria = $categoria["nome"];

$idusuario = $anuncio['idusuario'];
$usuario = pesquisarUsuarioId($conexao, $idusuario);
$nome_vendedor = $usuario["nome"];

$imagem = pesquisarImagemAnuncio($conexao, $id);
$imagem = $imagem["caminho"] ?? "sem imagem";


$anuncios = filtrarAnuncios($conexao, "id_anunciante", $idusuario);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jaleco de laboratório M — MIF</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<header>
    <a href="/index.php" class="logo">M<span>IF</span></a>
    <div class="barra-busca">
        <input type="text" placeholder="Buscar produtos...">
        <button type="button">Buscar</button>
    </div>
    <nav>
        <a href="cadastro-produto.php" class="btn-anunciar">+ Anunciar</a>
    </nav>
</header>

<div class="container">

    <div class="layout-produto">
        <div class="coluna-fotos">
            <div class="galeria-produto">
                <div class="foto-placeholder-grande"><?php echo "<img src='/imagens/" . $imagem . "' alt='sem imagem'>"; ?></div>
                <div class="miniaturas">
                    <div class="miniatura ativa flex align-center justify-center text-xsmall text-cinza">1</div>
                    <div class="miniatura flex align-center justify-center text-xsmall text-cinza">2</div>
                    <div class="miniatura flex align-center justify-center text-xsmall text-cinza">3</div>
                </div>
            </div>
        </div>

        <div class="coluna-info">
            <div class="info-produto">
                <span class="tipo-badge badge-venda text-small"><?php echo $tipo; ?></span>
                <h1 class="mt-8"><?php echo $titulo; ?></h1>
                <div class="preco-destaque">R$ <?php echo $preco;?></div>
                <p class="descricao">
                    <?php 
                    
                    ?>
                </p>

                <table class="detalhes-tabela">
                    <tr><td>Categoria</td><td><?php echo $nomeCategoria ?></td></tr>
                    <tr><td>Estado do item</td><td><?php echo $estado ?></td></tr>
                    <tr><td>Tipo</td><td><?php echo $tipo ?></td></tr>
                    <tr><td>Publicado em</td><td><?php echo $datahora ?></td></tr>
                    <tr><td>Código do anúncio</td><td><?php echo $id ?></td></tr>
                </table>
                <a href="../usuario/vendedor.php" class="btn btn-outline btn-bloco">Ver perfil do vendedor</a>

                <?php
                if(1 == 1) {
                echo '<a <p style="margin: 10px 0px;" href="../usuario/vendedor.php" class="btn btn-outline-vermelho btn-bloco">Encerrar</a>  ';
                } else {
                    echo "<p style='color:red;'>botão encerrar caso vc seja dono do anúncio</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <hr class="divider">
    <h2 class="secao-titulo">Sobre o vendedor</h2>

    <div class="card-vendedor-resumo">
        <div class="avatar-placeholder"><?php echo $nome_vendedor[0]?></div>
        <div>
            <div class="nome-vendedor">
                <a href="../usuario/vendedor.php"><?php echo $nome_vendedor?></a>
            </div>
        </div>
        <div class="ml-auto">
            <a href="../usuario/vendedor.php" class="btn btn-outline">Ver perfil</a>
        </div>
    </div>

    <hr class="divider">
    <h2 class="secao-titulo">Mais anúncios deste vendedor</h2>
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

<footer>
    <p>MIF &mdash; Marketplace do Instituto Federal Goiano &copy; 2026</p>
</footer>

</body>
</html>
