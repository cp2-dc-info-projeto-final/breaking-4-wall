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
        body {
            background-color: #561237; /* Cor de fundo para o body */
            font-family: Arial, sans-serif;
            color: #fff; /* Cor do texto para o body */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #123456; /* Cor de fundo para o container */
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #fff; /* Cor do texto para h2 */
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }

        label {
            color: #fff; /* Cor do texto para label */
            font-weight: bold;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #444; /* Cor da borda para campos de entrada */
            background-color: #FFF; /* Cor de fundo para campos de entrada */
            color: #000; /* Cor do texto para campos de entrada */
            box-sizing: border-box;
        }

        button {
            background-color: #FF0077; /* Cor de fundo para botões */
            color: #fff; /* Cor do texto para botões */
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            width: 100%;
        }

        button:hover {
            background-color: #CC0066; /* Cor de fundo alterada no hover do botão */
        }

        button[type="button"] {
            background-color: #d9534f;
        }

        button[type="button"]:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <div class="container">
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
            <button type="button" onclick="location.href='login.php'">Voltar</button>
            <button type="submit">Continuar</button>
        </form>
    </div>
</body>
</html>
