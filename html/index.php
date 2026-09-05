<?php
session_start();
require_once "funcoes/funcoes.php";
verificarLogin();

$anuncios = listarAnuncios($conexao);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIF — Marketplace do Instituto Federal</title>
    <link rel="stylesheet" href="/style.css">
</head>

<body>

<header>
    <a href="index.php" class="logo">M<span>IF</span></a>
    <div class="barra-busca">
        <input type="text" placeholder="Buscar produtos">
        <button type="button">Buscar</button>
    </div>
    <nav>
        <a href="produto/produto/cadastro-produto.php" class="btn-anunciar">+ Anunciar</a>
    </nav>
</header>

<section class="hero-banner">
    <h1>Marketplace do Instituto Federal Goiano</h1>
    <p>Venda, alugue ou troque com outros estudantes do IF. Simples e sem taxas.</p>
    <a href="produto/cadastro-produto.php" class="btn btn-ciano">Anunciar agora</a>
</section>

<div class="container">
    <div class="titulo-pagina mt-8">
        <h2 class="text-title">Categorias</h2>
    </div>

    <div class="categorias">
        <a href="index.php?categoria=todos" class="categoria-item ativa">Todos</a>
        <a href="index.php?categoria=jalecos" class="categoria-item">Jalecos</a>
        <a href="index.php?categoria=uniformes" class="categoria-item">Uniformes</a>
        <a href="index.php?categoria=livros" class="categoria-item">Livros</a>
        <a href="index.php?categoria=eletronicos" class="categoria-item">Eletrônicos</a>
        <a href="index.php?categoria=informatica" class="categoria-item">Informática</a>
        <a href="index.php?categoria=esportes" class="categoria-item">Esportes</a>
        <a href="index.php?categoria=outros" class="categoria-item">Outros</a>
    </div>

    <div class="layout-com-filtro mt-16">
        <aside class="painel-filtros">
            <h3>Filtros</h3>
            <div class="grupo-filtro">
                <label for="filtro-tipo">Tipo de anúncio</label>
                <select id="filtro-tipo">
                    <option value="">Todos</option>
                    <option value="venda">Venda</option>
                    <option value="aluguel">Aluguel</option>
                    <option value="troca">Troca</option>
                </select>
            </div>
            <div class="grupo-filtro">
                <label for="filtro-preco-min">Preço mínimo (R$)</label>
                <input type="number" id="filtro-preco-min" placeholder="0,00" min="0" step="0.01">
            </div>
            <div class="grupo-filtro">
                <label for="filtro-preco-max">Preço máximo (R$)</label>
                <input type="number" id="filtro-preco-max" placeholder="Sem limite" min="0" step="0.01">
            </div>
            <div class="grupo-filtro">
                <label>Estado do item</label>
                <div class="opcao-check">
                    <input type="checkbox" id="estado-novo" value="novo">
                    <label for="estado-novo">Novo</label>
                </div>
                <div class="opcao-check">
                    <input type="checkbox" id="estado-seminovo" value="seminovo">
                    <label for="estado-seminovo">Seminovo</label>
                </div>
                <div class="opcao-check">
                    <input type="checkbox" id="estado-usado" value="usado">
                    <label for="estado-usado">Usado</label>
                </div>
            </div>
            <div class="grupo-filtro">
                <label for="filtro-ordenar">Ordenar por</label>
                <select id="filtro-ordenar">
                    <option value="recentes">Mais recentes</option>
                    <option value="preco-asc">Menor preço</option>
                    <option value="preco-desc">Maior preço</option>
                    <option value="avaliacao">Melhor avaliação</option>
                </select>
            </div>
            <button class="btn btn-verde btn-bloco" type="button">Aplicar filtros</button>
            <button class="btn btn-outline btn-bloco mt-8" type="button">Limpar filtros</button>
        </aside>


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
