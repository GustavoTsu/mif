<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar — MIF</title>
    <link rel="stylesheet" href="/style.css">
</head>

<body>

    <header>
        <a href="index.php" class="logo">M<span>IF</span></a>
        <nav>
            <a href="index.php">Voltar ao início</a>
        </nav>
    </header>

    <div class="container">
        <div class="caixa-central" style="max-width: 500px;">

            <h1>Entrar no MIF</h1>
            <p class="subtitulo">Use sua matrícula e senha do IF Goiano</p>
            <form action="loginSUAP.php" method="POST">
                <div class="form-grupo">
                    <label>Matrícula</label>
                    <input type="text" id="matriculaUsuario" name="matriculaUsuario" placeholder="Sua matrícula"
                        required>
                </div>
                <div class="form-grupo">
                    <label>Senha</label>
                    <input type="password" id="senhaUsuario" name="senhaUsuario" placeholder="Sua senha" required>
                    <label>
                                <input type="checkbox" id="mostrar-senha"/>
                                <span>Mostrar senha</span>    
                    </label> 
                </div>
                <button type="submit" class="btn btn-verde btn-bloco">Entrar</button>
            </form>
        </div>

    </div>

    <footer>
        <p>MIF &mdash; Marketplace do Instituto Federal Goiano &copy; 2025</p>
    </footer>

    <script>
        let btn = document.getElementById("mostrar-senha")
        btn.addEventListener('click', function () {
            let input = document.getElementById('senhaUsuario')
            if (input.getAttribute('type') == 'password') {
            input.setAttribute('type', 'text')
            } else {
            input.setAttribute('type', 'password')
            }
        })
</script>

</body>

</html>