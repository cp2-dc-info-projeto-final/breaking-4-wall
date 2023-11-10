<?php
$message = "";

$servername = "localhost";
$username_db = "cadastrado";
$password_db = "123";
$database = "CADASTRO";

$conn = new mysqli("localhost", "cadastrados", "123", "CADASTRO");

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $stmt = $conn->prepare("SELECT id, senha FROM cadastrados WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if (password_verify($senha, $hashed_password)) {
        header("location: index.html");
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
    <link rel="stylesheet" href="style.css">
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

</body>
</html>
