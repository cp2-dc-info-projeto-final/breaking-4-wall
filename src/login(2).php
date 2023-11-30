<?php
session_start();
$message = "";

$servername = "localhost";
$username_db = "cadastrados";
$password_db = "123";
$database = "CADASTRO";

$conn = new mysqli($servername, $username_db, $password_db, $database);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Aqui, a consulta foi alterada para incluir a verificação de administrador
    $stmt = $conn->prepare("SELECT id, senha, eh_admin FROM cadastrados WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password, $eh_admin);
    $stmt->fetch();

    if (password_verify($senha, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['eh_admin'] = $eh_admin; // Armazena se o usuário é admin
        $_SESSION['login_successful'] = true;
    } else {
        $message = "Senha incorreta. Tente novamente.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <form action="login.php" method="POST" class="registration-form">
            <h2>Login</h2>
            <?php if (!empty($message)) : ?>
                <p style="color: red;"><?php echo $message; ?></p>
            <?php endif; ?>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
            <button type="submit" class="custom-button">Entrar</button>
        </form>
    </div>

    <?php if (!empty($_SESSION['login_successful'])): ?>
        <p>Login concluído. Redirecionando...</p>
        <script>
            setTimeout(function() {
                window.location.href = 'index.html';
            }, 5000);
        </script>
        <?php unset($_SESSION['login_successful']); ?>
    <?php endif; ?>
</body>
</html>

