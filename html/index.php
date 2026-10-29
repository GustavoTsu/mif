<?php
session_start();
require_once "conexao.php";
require_once "funcoes/funcoes.php";
verificarLogin();

// Mapa categoria (slug) => id no banco. AJUSTE para os IDs reais.
$mapaCategorias = [
    "jalecos"     => 2,
    "uniformes"   => 3,
    "livros"      => 4,
    "eletronicos" => 5,
    "informatica" => 6,
    "esportes"    => 7,
    "outros"      => 8,
];

$categoriaAtual = $_GET["categoria"] ?? "todos";
$busca = isset($_GET["busca"]) ? trim($_GET["busca"]) : "";

if ($busca !== "") {

    $anuncios = pesquisarAnuncioNome($conexao, $busca);
} else {

    $filtro = [];

    if (!empty($_GET["filtro_tipo"])) {
        $filtro["filtro_tipo"] = $_GET["filtro_tipo"];
    }

    if (isset($_GET["filtro_preco_min"]) && $_GET["filtro_preco_min"] !== "") {
        $filtro["filtro_preco_min"] = $_GET["filtro_preco_min"];
    }

    if (isset($_GET["filtro_preco_max"]) && $_GET["filtro_preco_max"] !== "") {
        $filtro["filtro_preco_max"] = $_GET["filtro_preco_max"];
    }

    if (!empty($_GET["filtro_estado"]) && is_array($_GET["filtro_estado"])) {
        $filtro["filtro_estado"] = $_GET["filtro_estado"];
    }

    if (!empty($_GET["filtro_ordenar"])) {
        $filtro["filtro_ordenar"] = $_GET["filtro_ordenar"];
    }

    if (isset($mapaCategorias[$categoriaAtual])) {
        $filtro["filtro_categoria"] = $mapaCategorias[$categoriaAtual];
    }

    $anuncios = listarAnuncios($conexao, $filtro);
}
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
        <form id="formbusca" class="barra-busca" action="/index.php" method="GET">
            <input id="busca" name="busca" type="text" placeholder="Buscar produtos" value="<?php echo htmlspecialchars($busca); ?>"
                <button type="submit">Buscar</button>
        </form>
        <nav>
            <a href="produto/cadastro-produto.php" class="btn-anunciar">+ Anunciar</a>
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

        <?php
        $lista = [
            "todos" => "Todos",
            "jalecos" => "Jalecos",
            "uniformes" => "Uniformes",
            "livros" => "Livros",
            "eletronicos" => "Eletrônicos",
            "informatica" => "Informática",
            "esportes" => "Esportes",
            "outros" => "Outros",
        ];
        ?>
        <div class="categorias">
            <?php foreach ($lista as $slug => $nome): ?>
                <a href="index.php?categoria=<?php echo $slug; ?>"
                    class="categoria-item <?php echo $categoriaAtual === $slug ? 'ativa' : ''; ?>">
                    <?php echo $nome; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="layout-com-filtro mt-16">


            <!-- ========================================= -->
            <!-- FILTROS -->
            <!-- ========================================= -->

            <aside class="painel-filtros">

                <h3>
                    Filtros
                </h3>


                <form
                    id="form-filtros"
                    action="/index.php"
                    method="GET">


                    <!-- TIPO -->

                    <div class="grupo-filtro">

                        <label for="filtro-tipo">
                            Tipo de anúncio
                        </label>

                        <select
                            id="filtro-tipo"
                            name="filtro_tipo">

                            <option value="">
                                Todos
                            </option>

                            <option
                                value="venda"
                                <?php
                                if (
                                    isset($_GET["filtro_tipo"]) &&
                                    $_GET["filtro_tipo"] === "venda"
                                ) {
                                    echo "selected";
                                }
                                ?>>
                                Venda
                            </option>

                            <option
                                value="aluguel"
                                <?php
                                if (
                                    isset($_GET["filtro_tipo"]) &&
                                    $_GET["filtro_tipo"] === "aluguel"
                                ) {
                                    echo "selected";
                                }
                                ?>>
                                Aluguel
                            </option>

                            <option
                                value="troca"
                                <?php
                                if (
                                    isset($_GET["filtro_tipo"]) &&
                                    $_GET["filtro_tipo"] === "troca"
                                ) {
                                    echo "selected";
                                }
                                ?>>
                                Troca
                            </option>

                        </select>

                    </div>


                    <!-- PREÇO MÍNIMO -->

                    <div class="grupo-filtro">

                        <label for="filtro-preco-min">
                            Preço mínimo (R$)
                        </label>

                        <input
                            type="number"
                            id="filtro-preco-min"
                            name="filtro_preco_min"
                            placeholder="0,00"
                            min="0"
                            step="0.01"
                            value="<?php
                                    echo isset($_GET["filtro_preco_min"])
                                        ? htmlspecialchars($_GET["filtro_preco_min"])
                                        : "";
                                    ?>">

                    </div>


                    <!-- PREÇO MÁXIMO -->

                    <div class="grupo-filtro">

                        <label for="filtro-preco-max">
                            Preço máximo (R$)
                        </label>

                        <input
                            type="number"
                            id="filtro-preco-max"
                            name="filtro_preco_max"
                            placeholder="Sem limite"
                            min="0"
                            step="0.01"
                            value="<?php
                                    echo isset($_GET["filtro_preco_max"])
                                        ? htmlspecialchars($_GET["filtro_preco_max"])
                                        : "";
                                    ?>">

                    </div>


                    <!-- ESTADO -->

                    <div class="grupo-filtro">

                        <label>
                            Estado do item
                        </label>


                        <div class="opcao-check">

                            <input
                                type="checkbox"
                                id="estado-novo"
                                name="filtro_estado[]"
                                value="novo"
                                <?php
                                if (
                                    isset($_GET["filtro_estado"]) &&
                                    in_array("novo", $_GET["filtro_estado"])
                                ) {
                                    echo "checked";
                                }
                                ?>>

                            <label for="estado-novo">
                                Novo
                            </label>

                        </div>


                        <div class="opcao-check">

                            <input
                                type="checkbox"
                                id="estado-seminovo"
                                name="filtro_estado[]"
                                value="seminovo"
                                <?php
                                if (
                                    isset($_GET["filtro_estado"]) &&
                                    in_array("seminovo", $_GET["filtro_estado"])
                                ) {
                                    echo "checked";
                                }
                                ?>>

                            <label for="estado-seminovo">
                                Seminovo
                            </label>

                        </div>


                        <div class="opcao-check">

                            <input
                                type="checkbox"
                                id="estado-usado"
                                name="filtro_estado[]"
                                value="usado"
                                <?php
                                if (
                                    isset($_GET["filtro_estado"]) &&
                                    in_array("usado", $_GET["filtro_estado"])
                                ) {
                                    echo "checked";
                                }
                                ?>>

                            <label for="estado-usado">
                                Usado
                            </label>

                        </div>

                    </div>


                    <!-- ORDENAÇÃO -->

                    <div class="grupo-filtro">

                        <label for="filtro-ordenar">
                            Ordenar por
                        </label>

                        <select
                            id="filtro-ordenar"
                            name="filtro_ordenar">

                            <option
                                value="recentes"
                                <?php
                                if (
                                    !isset($_GET["filtro_ordenar"]) ||
                                    $_GET["filtro_ordenar"] === "recentes"
                                ) {
                                    echo "selected";
                                }
                                ?>>
                                Mais recentes
                            </option>

                            <option
                                value="preco_asc"
                                <?php
                                if (
                                    isset($_GET["filtro_ordenar"]) &&
                                    $_GET["filtro_ordenar"] === "preco_asc"
                                ) {
                                    echo "selected";
                                }
                                ?>>
                                Menor preço
                            </option>

                            <option
                                value="preco_desc"
                                <?php
                                if (
                                    isset($_GET["filtro_ordenar"]) &&
                                    $_GET["filtro_ordenar"] === "preco_desc"
                                ) {
                                    echo "selected";
                                }
                                ?>>
                                Maior preço
                            </option>

                            <option
                                value="avaliacao"
                                <?php
                                if (
                                    isset($_GET["filtro_ordenar"]) &&
                                    $_GET["filtro_ordenar"] === "avaliacao"
                                ) {
                                    echo "selected";
                                }
                                ?>>
                                Melhor avaliação
                            </option>

                        </select>

                    </div>


                    <!-- CATEGORIA OCULTA -->

                    <?php

                    if (isset($_GET["categoria"])) {

                    ?>

                        <input
                            type="hidden"
                            name="categoria"
                            value="<?php echo htmlspecialchars($_GET["categoria"]); ?>">

                    <?php

                    }

                    ?>


                    <button
                        class="btn btn-verde btn-bloco"
                        type="submit">
                        Aplicar filtros
                    </button>


                    <a
                        href="index.php"
                        class="btn btn-outline btn-bloco mt-8">
                        Limpar filtros
                    </a>

                </form>

            </aside>


            <!-- ========================================= -->
            <!-- RESULTADOS -->
            <!-- ========================================= -->

            <div class="area-resultados">

                <div class="mt-24 text-center">

                    <?php

                    barraNavegacao($anuncios);

                    ?>

                </div>


                <div class="grid-produtos">

                    <?php

                    Anunciosformatados(
                        $conexao,
                        $anuncios
                    );

                    ?>

                </div>


                <div class="mt-24 text-center">

                    <?php

                    barraNavegacao($anuncios);

                    ?>

                </div>

            </div>

        </div>

    </div>


    <footer>

        <p>
            MIF &mdash; Marketplace do Instituto Federal Goiano
            &copy; 2025
        </p>

    </footer>

</body>

</html>