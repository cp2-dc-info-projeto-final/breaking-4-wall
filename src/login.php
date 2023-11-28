<?php
session_start(); // Inicia a sessão

$message = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Informações de conexão com o banco de dados
    $servername = "localhost";
    $username_db = "cadastrados";
    $password_db = "123";
    $database = "CADASTRO";

    // Cria uma conexão com o banco de dados
    $conn = new mysqli($servername, $username_db, $password_db, $database);

    // Verifica se ocorreu algum erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST["email"]);
    $senha = $_POST["senha"];

    // Prepara a consulta SQL para evitar injeção de SQL
    $stmt = $conn->prepare("SELECT id, nome, email, senha FROM cadastrados WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha'])) {
            // Senha correta, registra o usuário como logado
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user["id"];
            $_SESSION["nome"] = $user["nome"];
            $_SESSION["email"] = $user["email"];

            // Redireciona para a página de perfil
            header("Location: perfil.php");
            exit;
        } else {
            $message = "Senha inválida.";
        }
    } else {
        $message = "Nenhuma conta encontrada com esse e-mail.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <form action="login.php" method="POST" class="login-form">
            <h2>Login</h2>

            <!-- Mensagem de erro ou sucesso -->
            <?php if (!empty($message)) : ?>
                <p><?php echo $message; ?></p>
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
