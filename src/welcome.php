<?php
// Dados de conexão ao banco de dados
$servername = "localhost";
$username = "cadastrados";
$password = "123";
$dbname = "CADASTRO";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST["email"]);
    $senha = $_POST["senha"];

    $stmt = $conn->prepare("SELECT id, nome, email, senha, is_admin FROM cadastrados WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha'])) {
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user["id"];
            $_SESSION["nome"] = $user["nome"];
            $_SESSION["email"] = $user["email"];

            // Verifica se o usuário é administrador
            if ($user['is_admin']) {
                header("Location: dashboard.php");
            } else {
                header("Location: index.html");
            }
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
    <title>Site BR4W!</title>
    <link rel="icon" type="image/png" href="logo.jpg" />
    <style>
        /* Seu CSS vai aqui */
        body {
            font-family: 'Arial', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .welcome-message {
            margin-bottom: 20px;
            text-align: center;
        }

        .welcome-message h1 {
            font-size: 2em;
            color: #333;
        }

        .navigation-links {
            display: flex;
            gap: 20px;
        }

        .navigation-links a {
            text-decoration: none;
            color: white;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navigation-links a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="welcome-message">
        <h1>Site BR4W!</h1>
    </div>

    <div class="navigation-links">
        <a href="login.php" class="btn btn-primary">Login</a>
        <a href="cadastro.html" class="btn btn-secondary">Cadastre-se</a>
        <a href="index.html" class="btn btn-success">Navegar pelo Site</a>
    </div>

</body>
</html>
