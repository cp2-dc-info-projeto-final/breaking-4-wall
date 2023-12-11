<?php
include "conecta.php";
session_start();
?>
<!doctype html>
<html lang="pt-br">
<head>
    <title>Esqueci a senha | Breaking4Wall</title>
    <meta charset="utf-8">
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
