<?php
session_start();
require_once "../funcoes/funcoes.php";
verificarLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dados do Perfil</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body class="iframe-body" style="background: #fff; padding: 20px;">
    <form action="#" method="POST" enctype="multipart/form-data">
        <div class="form-card">
            <h2 class="secao-titulo">Informações pessoais</h2>
            <div class="form-grupo">
                <label for="nome">Nome completo *</label>
                <input type="text" id="nome" name="nome" required value="João Silva">
            </div>
            <div class="form-grupo">
                <label for="email-readonly">E-mail institucional</label>
                <input type="email" id="email-readonly" value="joao@estudante.ifgoiano.edu.br" readonly class="bg-readonly pointer-none">
            </div>
            <div class="form-linha">
                <div class="form-grupo">
                    <label for="campus">Campus *</label>
                    <select id="campus" name="campus" required>
                        <option value="morrinhos" selected>Morrinhos</option>
                        <option value="ceres">Ceres</option>
                    </select>
                </div>
                <div class="form-grupo">
                    <label for="curso">Curso *</label>
                    <input type="text" id="curso" name="curso" required value="Técnico em Química">
                </div>
            </div>
            <button type="submit" class="btn btn-verde">Salvar alterações</button>
        </div>
    </form>
</body>
</html>
