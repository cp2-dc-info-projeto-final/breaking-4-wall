<?php
$message = "";
$errorMessage = "";

// Informações de conexão com o banco de dados
$servername = "localhost"; // Endereço do servidor de banco de dados
$username_db = "cadastrados"; // Nome de usuário do banco de dados
$password_db = "123"; // Senha do banco de dados
$database = "CADASTRO"; // Nome do banco de dados

// Crie uma conexão com o banco de dados
$conn = new mysqli($servername, $username_db, $password_db, $database);

// Verifique se ocorreu algum erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Incluir código para processar o envio do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]); // Remova espaços no início e no fim
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $erro = false; // Inicializar a variável $erro

    // Validação do nome
    if (empty($nome) || !preg_match("/\s/", $nome)) {
        $errorMessage = "Preencha seu nome completo com sobrenome.";
        $erro = true;
    }

    // Validação do email
    if (strlen($email) < 8 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Preencha um email válido com pelo menos 8 caracteres.";
        $erro = true;
    }

    // Validação da senha
    if (strlen($senha) < 8) {
        $errorMessage = "A senha deve ter pelo menos 8 caracteres.";
        $erro = true;
    }

    // Verificar se o email já está cadastrado
    $stmt = $conn->prepare("SELECT email FROM cadastrados WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errorMessage = "Este endereço de email já está cadastrado.";
        $erro = true;
    }

    $stmt->close();

    if (!$erro) {
        // Criptografar a senha antes de inseri-la no banco de dados
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Usar consultas preparadas para evitar injeção de SQL
        $stmt = $conn->prepare("INSERT INTO cadastrados (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senhaHash);

        if ($stmt->execute()) {
            $message = "O usuário foi cadastrado com sucesso.";
            // Redirecionar para a página de index após o cadastro
            header("Location: index.html");
            exit; // Não se esqueça do exit após redirecionar
        } else {
            $message = "Erro ao inserir dados: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Feche a conexão com o banco de dados quando não precisar mais dela
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Adicione os estilos CSS atualizados -->
    <style>
        body {
            background-color: #561237;
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh; /* Defina a altura da tela inteira */
        }

        .container {
            max-width: 400px;
            padding: 20px;
            background-color: #123456;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .registration-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .registration-form label {
            color: #FFFFFF;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .registration-form input[type="text"],
        .registration-form input[type="email"],
        .registration-form input[type="password"] {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #444;
            background-color: #FFF;
            color: #000;
        }

        .custom-button {
            background-color: rgb(255, 0, 119);
            color: #FFF;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .custom-button:hover {
            background-color: #ff3399;
        }

        .registration-form p a {
            color: #99ccff;
        }

        .registration-form p a:hover {
            color: #FFF;
            text-decoration: underline;
        }

        .registration-form p {
            color: #FFF;
        }

        /* Adicione este estilo para a mensagem de erro */
        .error-message {
            color: #fff;
            background-color: #ff4d4d;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="cadastro.php" method="POST" class="registration-form">
            <h2>Cadastro Usuário</h2>
            
            <?php if (!empty($errorMessage)) : ?>
                <div class="error-message">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" required>
           
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
           
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
           
            <button type="submit" class="custom-button">Cadastrar</button>
        </form>
    </div>
</body>
</html>
