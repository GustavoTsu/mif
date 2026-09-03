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
    <a href="index.php" class="logo">M<span>IF</span></a>
    <div class="barra-busca">
        <input type="text" placeholder="Buscar produtos...">
        <button type="button">Buscar</button>
    </div>
    <nav>
        <a href="login.php">Entrar</a>
        <a href="cadastro-produto.php" class="btn-anunciar">+ Anunciar</a>
    </nav>
</header>

<div class="container">

    <div class="layout-produto">
        <div class="coluna-fotos">
            <div class="galeria-produto">
                <div class="foto-placeholder-grande">Foto principal do produto</div>
                <div class="miniaturas">
                    <div class="miniatura ativa flex align-center justify-center text-xsmall text-cinza">1</div>
                    <div class="miniatura flex align-center justify-center text-xsmall text-cinza">2</div>
                    <div class="miniatura flex align-center justify-center text-xsmall text-cinza">3</div>
                </div>
            </div>
        </div>

        <div class="coluna-info">
            <div class="info-produto">
                <span class="tipo-badge badge-venda text-small">Venda</span>
                <h1 class="mt-8">Jaleco de laboratório M</h1>
                <div class="preco-destaque">R$ 35,00</div>
                <p class="descricao">
                    Jaleco branco de laboratório, tamanho M, usado apenas no 1º ano.
                    Em ótimo estado, sem manchas ou rasgos.
                </p>

                <table class="detalhes-tabela">
                    <tr><td>Categoria</td><td>Jalecos</td></tr>
                    <tr><td>Estado do item</td><td>Seminovo</td></tr>
                    <tr><td>Tipo</td><td>Venda</td></tr>
                    <tr><td>Publicado em</td><td>01/04/2025</td></tr>
                    <tr><td>Código do anúncio</td><td>#<!-- BANCO: produto.id --></td></tr>
                </table>
                <a href="vendedor.php?id=1" class="btn btn-outline btn-bloco">Ver perfil do vendedor</a>

                <?php
                if(1 == 1) {
                echo '<a <p style="margin: 10px 0px;" href="vendedor.php?id=1" class="btn btn-outline-vermelho btn-bloco">Encerrar</a>  ';
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
        <div class="avatar-placeholder">J</div>
        <div>
            <div class="nome-vendedor">
                <a href="vendedor.php?id=1">João Silva</a>
            </div>
        </div>
        <div class="ml-auto">
            <a href="vendedor.php?id=1" class="btn btn-outline">Ver perfil</a>
        </div>
    </div>

    <hr class="divider">
    <h2 class="secao-titulo">Mais anúncios deste vendedor</h2>
    <div class="grid-produtos">
        <a href="produto.php" class="card-produto">
            <div class="foto-placeholder">Sem foto</div>
            <div class="info-card">
                <span class="tipo-badge badge-venda">Venda</span>
                <div class="titulo-card">Livro de Química Orgânica</div>
                <div class="preco-card">R$ 50,00</div>
            </div>
        </a>
    </div>
</div>

<footer>
    <p>MIF &mdash; Marketplace do Instituto Federal Goiano &copy; 2025</p>
</footer>

</body>
</html>
