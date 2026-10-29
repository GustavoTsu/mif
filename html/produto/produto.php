<?php
session_start();
require_once "../funcoes/funcoes.php";
verificarLogin();

$id_anuncio = 1;
if (isset($_GET["id"])) {
    $id_anuncio = $_GET["id"];
}


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
$donoAnuncio = ($_SESSION['usuario'] == $usuario['matricula']);
$podeGerenciar = $donoAnuncio || verificarAdmin();

$stmt = mysqli_prepare($conexao, "SELECT caminho FROM imagem WHERE idanuncio = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $caminho);

$fotos = [];
while (mysqli_stmt_fetch($stmt)) {
    $fotos[] = $caminho;
}
mysqli_stmt_close($stmt);

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
        <form id="formbusca" class="barra-busca" action="/index.php" method="GET">
            <input id="busca" name="busca" type="text" placeholder="Buscar produtos">
            <button type="submit">Buscar</button>
        </form>
        <nav>
            <a href="cadastro-produto.php" class="btn-anunciar">+ Anunciar</a>
        </nav>
    </header>

    <div class="container">

        <div class="layout-produto">
            <div class="coluna-fotos">
                <div class="galeria-produto">
                    <div class="foto-placeholder-grande" style="position: relative;">
                        <button class="seta esq" onclick="voltar()">&#10094;</button>
                        <img id="foto" src="/imagens/<?php echo $fotos[0] ?? ''; ?>">
                        <button class="seta dir" onclick="avancar()">&#10095;</button>
                    </div>

                </div>


                <script>
                    var fotos = <?php echo json_encode($fotos); ?>;
                    var atual = 0;

                    function mostrar() {
                        document.getElementById("foto").src = "/imagens/" + fotos[atual];
                    }

                    function avancar() {
                        atual++;
                        if (atual >= fotos.length) {
                            atual = 0;
                        }
                        mostrar();
                    }

                    function voltar() {
                        atual--;
                        if (atual < 0) {
                            atual = fotos.length - 1;
                        }
                        mostrar();
                    }
                </script>
            </div>

            <div class="coluna-info">
                <div class="info-produto">
                    <span class="tipo-badge badge-venda text-small"><?php echo $tipo; ?></span>
                    <h1 class="mt-8"><?php echo $titulo; ?></h1>
                    <div class="preco-destaque">R$ <?php echo $preco; ?></div>

                    <table class="detalhes-tabela">
                        <tr>
                            <td>Categoria</td>
                            <td><?php echo $nomeCategoria ?></td>
                        </tr>
                        <tr>
                            <td>Estado do item</td>
                            <td><?php echo $estado ?></td>
                        </tr>
                        <tr>
                            <td>Tipo</td>
                            <td><?php echo $tipo ?></td>
                        </tr>
                        <tr>
                            <td>Publicado em</td>
                            <td><?php echo $datahora ?></td>
                        </tr>
                        <tr>
                            <td>Código do anúncio</td>
                            <td><?php echo $id ?></td>
                        </tr>
                        <tr>
                            <td>Contato</td>
                            <td><?php echo $usuario["numero"]; ?></td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
        <a href="../usuario/vendedor.php" class="btn btn-outline btn-bloco">Ver perfil do vendedor</a>

        <?php if ($podeGerenciar) { ?>
            <a style="margin: 10px 0px;" href="cadastro-produto.php?idanuncio=<?php echo $id; ?>" class="btn btn-outline btn-bloco">Editar</a>
            <a href="deletar.php?idanuncio=<?php echo $id; ?>" class="btn btn-outline-vermelho btn-bloco">Encerrar</a>
        <?php } ?>
        <br>
        <h2 class="mt-8">Descrição</h1>
            <p class="card-vendedor-resumo descricao" style="white-space: pre-line;">
                <?php echo htmlspecialchars($descricao); ?>
            </p>

            <hr class="divider">
            <h2 class="secao-titulo">Sobre o vendedor</h2>

            <div class="card-vendedor-resumo">
                <div class="avatar-placeholder"><?php echo $nome_vendedor[0] ?></div>
                <div>
                    <div class="nome-vendedor">
                        <a href="../usuario/vendedor.php"><?php echo $nome_vendedor ?></a>
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