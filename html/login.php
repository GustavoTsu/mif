<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar — MIF</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <a href="index.html" class="logo">M<span>IF</span></a>
        <nav>
            <a href="index.html">Voltar ao início</a>
        </nav>
    </header>

    <div class="container">
        <div class="caixa-central" style="max-width: 500px;">

            <h1>Entrar no MIF</h1>
            <p class="subtitulo">Use sua matrícula e senha do IF Goiano</p>
            <form action="loginSUAP.php" method="POST">
                <div class="form-grupo">
                    <label for="matriculaUsuario">Matrícula</label>
                    <input type="matricula" id="matriculaUsuario" name="matriculaUsuario" placeholder="Sua matrícula"
                        required>
                </div>
                <div class="form-grupo">
                    <label for="senhaUsuario">Senha</label>
                    <input type="password" id="senhaUsuario" name="senhaUsuario" placeholder="Sua senha" required>
                </div>
                <button type="submit" class="btn btn-verde btn-bloco">Entrar</button>
            </form>
        </div>

        <p class="text-center text-small text-cinza mt-16">
            MIF &mdash; Marketplace do Instituto Federal Goiano
        </p>
    </div>
    </div>

    <footer>
        <p>MIF &mdash; Marketplace do Instituto Federal Goiano &copy; 2025</p>
    </footer>

</body>

</html>