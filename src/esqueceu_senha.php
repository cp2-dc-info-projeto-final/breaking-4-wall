<?php
include "conecta.php";
session_start();
?>
<!doctype html>
<html lang="pt-br">
<head>
    <title>Esqueci a senha | Breaking4Wall</title>
    <meta charset="utf-8">
    <style>
        /* Estilos globais e da navbar existentes... */

        /* Estilo do corpo da página com a nova cor de fundo */
        body {
            background-color: #561237; /* Cor de fundo atualizada baseada na imagem */
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        /* Estilo do container do formulário de cadastro */
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #123456; /* Cor de fundo para o container do formulário */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        /* Estilos para o formulário de cadastro */
        .registration-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Estilo para os rótulos do formulário */
        .registration-form label {
            color: #FFFFFF; /* Cor do texto para contraste com o fundo escuro */
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Estilo para os campos de entrada */
        .registration-form input[type="text"],
        .registration-form input[type="email"],
        .registration-form input[type="password"] {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #444; /* Cor de borda ajustada para contraste */
            background-color: #FFF;
            color: #000;
        }

        /* Estilo para o botão de cadastro */
        .custom-button {
            background-color: rgb(255, 0, 119); /* Cor que complementa a navbar */
            color: #FFF;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .custom-button:hover {
            background-color: #ff3399; /* Tom mais escuro da cor do botão */
        }

        /* Estilo para o link de redefinição de senha */
        .registration-form p a {
            color: #99ccff;
        }

        .registration-form p a:hover {
            color: #FFF;
            text-decoration: underline;
        }

        /* Mensagem de feedback após o cadastro */
        .registration-form p {
            color: #FFF;
        }
    </style>
</head>
<body>
    <h2>Recuperação de Senha</h2>
    <?php
        if (isset($_SESSION['msg_rec'])) {
            echo "<p>" . $_SESSION['msg_rec'] . "</p>";
            unset($_SESSION['msg_rec']);
        }
    ?>
    <form action="recuepera.php" method="POST">
        <input type="hidden" name="operacao" value="enviar-email">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Digite seu email" required>
        <br>
        <button type="button" onclick="location.href='login.php'">Voltar</button>
        <button type="submit">Continuar</button>
    </form>
</body>
</html>
