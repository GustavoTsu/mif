<?php
session_start();
require_once "../funcoes/funcoes.php";
verificarLogin();


$idanuncio = 0;
$anuncio = null;

if (isset($_GET['idanuncio'])) {
    $idanuncio = intval($_GET['idanuncio']);
    $anuncio = pesquisarAnuncioId($conexao, $idanuncio);
}

if (!empty($_POST)) {

    $tipos_permitidos   = ['venda', 'aluguel', 'troca'];
    $estados_permitidos = ['novo', 'seminovo', 'usado'];
    $status_permitidos  = ['ativo', 'pausado', 'encerrado'];

    $titulo = '';
    if (isset($_POST['titulo'])) {
        $titulo = trim($_POST['titulo']);
    }

    $descricao = '';
    if (isset($_POST['descricao'])) {
        $descricao = trim($_POST['descricao']);
    }

    $idcategoria = 0;
    if (isset($_POST['categoria'])) {
        $idcategoria = intval($_POST['categoria']);
    }

    $estado = '';
    if (isset($_POST['estado'])) {
        $estado = trim($_POST['estado']);
    }

    $tipo = '';
    if (isset($_POST['tipo'])) {
        $tipo = trim($_POST['tipo']);
    }

    $preco = 0.00;
    if (isset($_POST['preco']) && $_POST['preco'] !== '') {
        $preco = floatval($_POST['preco']);
    }

    $status = 'ativo';
    if (isset($_POST['status'])) {
        $status = trim($_POST['status']);
    }

    $periodoaluguel = '';
    if (isset($_POST['periodo_aluguel'])) {
        $periodoaluguel = trim($_POST['periodo_aluguel']);
    }

    $troca = '';
    if (isset($_POST['detalhes_troca'])) {
        $troca = trim($_POST['detalhes_troca']);
    }

    $matriculaUsuario = $_SESSION['usuario'];
    $usuario = pesquisarUsuarioMatricula($conexao, $matriculaUsuario);
    $idusuario = $usuario["idusuario"];

    if (!in_array($tipo, $tipos_permitidos)) {
        header("Location: cadastrar_produto.php?e=invalid_tipo");
        exit;
    }

    if (!in_array($estado, $estados_permitidos)) {
        header("Location: cadastrar_produto.php?e=invalid_estado");
        exit;
    }

    if (!in_array($status, $status_permitidos)) {
        header("Location: cadastrar_produto.php?e=invalid_status");
        exit;
    }

    // da block nos espertinho q tenta por preço negativo
    if ($preco < 0) {
        header("Location: cadastrar_produto.php?e=invalid_preco");
        exit;
    }

    // obrigar encher tudo 
    if ($titulo == "" || $descricao == "" || $idcategoria == 0 || $estado == "" || $tipo == "") {
        header("Location: cadastrar_produto.php?e=1");
        exit;
    }

    if (strlen($titulo) > 45) {
        header("Location: cadastrar_produto.php?e=2");
        exit;
    }

  if ($anuncio) {
        // if para saber se ta editanu ou salvanu
        $salvou = editarAnuncio(
            $conexao,
            $titulo,
            $descricao,
            $estado,
            $tipo,
            $preco,
            $periodoaluguel,
            $troca,
            $idcategoria,
            $status,
            $idanuncio
        );
    } else {

        $salvou = salvarAnuncio(
            $conexao,
            $titulo,
            $descricao,
            $estado,
            $tipo,
            $preco,
            $periodoaluguel,
            $troca,
            $idcategoria,
            $status,
            $idusuario
        );
    }

    if ($salvou) {
        $idanuncio = mysqli_insert_id($conexao);
        if (isset($_FILES['fotos'])) {
            if (!empty($_FILES['fotos']['name'][0])) {
                $totalArquivos = count($_FILES['fotos']['name']);
                $i = 0;

                while ($i < $totalArquivos) {
                    $arquivo = [
                        'name'     => $_FILES['fotos']['name'][$i],
                        'tmp_name' => $_FILES['fotos']['tmp_name'][$i],
                        'error'    => $_FILES['fotos']['error'][$i],
                        'size'     => $_FILES['fotos']['size'][$i]
                    ];

                    salvarImagem($conexao, $arquivo, $idanuncio);
                    $i++;
                }
            }
        }

        header("Location: /index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo anúncio — MIF</title>
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="/style.css">
</head>

<body>

    <header>
        <a href="index.php" class="logo">M<span>IF</span></a>
        <nav>
            <a href="./../index.php">Início</a>
        </nav>
    </header>

    <div class="container">

        <div class="titulo-pagina">
            <h1>Publicar novo anúncio</h1>
            <p>Preencha as informações do item que deseja vender, alugar ou trocar.</p>
        </div>

 <form action="cadastro-produto.php<?php if ($anuncio) echo '?idanuncio=' . $idanuncio; ?>" method="POST" enctype="multipart/form-data">
            <div class="flex gap-32 align-start">
                <div class="flex-2 min-w-0">
                    <div class="form-card">
                        <h2 class="secao-titulo">Informações do item</h2>
                        <div class="form-grupo">
                            <label for="titulo">Título do anúncio *</label>
                            <input type="text" id="titulo" name="titulo" value="<?php echo $anuncio['titulo'] ?? ''; ?>" placeholder="Ex.: Jaleco de laboratório tamanho M" required maxlength="120">
                            <span class="hint">Seja descritivo. Máximo 120 caracteres.</span>
                        </div>
 
                        <div class="form-grupo">
                            <label for="descricao">Descrição *</label>
                            <textarea id="descricao" name="descricao" placeholder="Descreva o item..." required maxlength="2000" rows="6"><?php echo $anuncio['descricao'] ?? ''; ?></textarea>
                            <span class="hint">Máximo 2000 caracteres.</span>
                        </div>
 
                        <div class="form-linha">
                            <div class="form-grupo">
                                <label for="categoria">Categoria *</label>
                                <select id="categoria" name="categoria" required>
                                    <option value="">Selecione...</option>
                                    <?php
                                    $lista_categorias = listarCategorias($conexao);
                                    $i = 0;
                                    while ($i < sizeof($lista_categorias)) {
                                        $categoria = $lista_categorias[$i];
                                        $idcategoria = $categoria["idcategoria"];
                                        $nome = $categoria["nome"];
 
                                        $selecionada = '';
                                        if (($anuncio['idcategoria'] ?? '') == $idcategoria) {
                                            $selecionada = 'selected';
                                        }
 
                                        echo '<option value="' . $idcategoria . '" ' . $selecionada . '>' . $nome . '</option>';
                                        $i++;
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-grupo">
                                <label for="estado">Estado do item *</label>
                                <select id="estado" name="estado" required>
                                    <option value="">Selecione...</option>
 
                                    <option value="novo"
                                        <?php if (($anuncio['estado'] ?? '') == 'novo') echo    'selected'; ?>>Novo</option>
 
                                    <option value="seminovo"
                                        <?php if (($anuncio['estado'] ?? '') == 'seminovo') echo 'selected'; ?>>Seminovo</option>
 
                                    <option value="usado" <?php if (($anuncio['estado'] ?? '') == 'usado') echo 'selected'; ?>>Usado</option>
                                </select>
                            </div>
                        </div>
                    </div>
 
                    <div class="form-card">
                        <h2 class="secao-titulo">Tipo de anúncio e valor</h2>
                        <div class="form-grupo">
                            <label>Tipo de anúncio *</label>
                            <div class="radio-group">
                                <label class="radio-label">
                                    <div class="radio-group">
 
                                        <label class="radio-label">
                                            <input type="radio" name="tipo" value="venda"
                                                <?php if (($anuncio['tipo'] ?? '') == 'venda') echo 'checked'; ?>
                                                required>
                                            Venda
                                        </label>
 
                                        <label class="radio-label">
                                            <input type="radio" name="tipo" value="aluguel"
                                                <?php if (($anuncio['tipo'] ?? '') == 'aluguel') echo 'checked'; ?>>
                                            Aluguel
                                        </label>
 
                                        <label class="radio-label">
                                            <input type="radio" name="tipo" value="troca"
                                                <?php if (($anuncio['tipo'] ?? '') == 'troca') echo 'checked'; ?>>
                                            Troca
                                        </label>
 
                                    </div>
                            </div>
 
                            <div class="form-grupo" id="campo-preco">
                                <label for="preco">Preço (R$)</label>
                                <input type="number" id="preco" value="<?php echo $anuncio['preco'] ?? ''; ?>" name="preco" placeholder="0,00" min="0" step="0.01">
                            </div>
 
                            <div class="form-grupo" id="campo-periodo">
                                <label for="periodo-aluguel">Período do aluguel (se aluguel)</label>
                                <select id="periodo-aluguel" name="periodo_aluguel">
                                    <option value="">Selecione...</option>
                                    <option value="dia" <?php if (($anuncio['periodo_aluguel'] ?? '') == 'dia') echo 'selected'; ?>>Por dia</option>
                                    <option value="semana" <?php if (($anuncio['periodo_aluguel'] ?? '') == 'semana') echo 'selected'; ?>>Por semana</option>
                                </select>
                            </div>
 
                            <div class="form-grupo" id="campo-troca">
                                <label for="detalhes-troca">O que deseja em troca? (Ex: notebook ou não faço troca)</label>
                                <textarea id="detalhes-troca" name="detalhes_troca" placeholder="Descreva o que você aceita em troca..." rows="3"><?php echo $anuncio['troca'] ?? ''; ?></textarea>
                            </div>
                        </div>
 
 
                    </div>
 
                    <div class="flex-1 min-w-0">
                        <div class="form-card sticky-sidebar">
                            <h2 class="secao-titulo">Fotos do item</h2>
                            <div class="form-grupo">
                                <label for="fotos">Adicionar fotos</label>
                                <input type="file" id="fotos" name="fotos[]" accept="image/*" multiple>
                                <span class="hint">Até 8 fotos. A primeira será a capa.</span>
                            </div>
 
                            <div class="foto-grid">
                                <div class="foto-add-btn">+</div>
                            </div>
 
                            <hr class="divider">
 
                            <div class="form-grupo">
                                <label for="status-anuncio">Status do anúncio</label>
                                <select id="status-anuncio" name="status">
                                    <option value="ativo" <?php if (($anuncio['status'] ?? '') == 'ativo') echo 'selected'; ?>>Ativo</option>
                                    <option value="pausado" <?php if (($anuncio['status'] ?? '') == 'pausado') echo 'selected'; ?>>Pausado</option>
                                    <option value="encerrado" <?php if (($anuncio['status'] ?? '') == 'encerrado') echo 'selected'; ?>>Encerrado</option>
                                </select>
                            </div>
 
                            <button type="submit" class="btn btn-verde btn-bloco mt-8"><?php echo $anuncio ? 'Salvar alterações' : 'Publicar anúncio'; ?></button>
                            <a href="./../index.php" class="btn btn-outline btn-bloco mt-8">Cancelar</a>
                        </div>
                    </div>
                </div>
        </form>
    </div>

    <footer>
        <p>MIF &mdash; Marketplace do Instituto Federal Goiano &copy; 2025</p>
    </footer>

</body>

</html>