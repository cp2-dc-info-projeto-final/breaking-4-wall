<?php
$message = "";

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
    $usuario = trim($_POST["usuario"]); // Remova espaços no início e no fim
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $erro = false; // Inicializar a variável $erro

    // Validação do usuário
    if (empty($usuario)) {
        echo "Preencha o campo de usuário.<br>";
        $erro = true;
    }

    // Validação do email
    if (strlen($email) < 8 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Preencha um email válido com pelo menos 8 caracteres.<br>";
        $erro = true;
    }

    // Validação da senha
    if (strlen($senha) < 8) {
        echo "A senha deve ter pelo menos 8 caracteres.<br>";
        $erro = true;
    }

    // Verificar se o email já está cadastrado nas tabelas Administradores ou cadastrados
    $stmt = $conn->prepare("SELECT email FROM Administradores WHERE email = ? UNION SELECT email FROM cadastrados WHERE email = ?");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Este endereço de email já está cadastrado.<br>";
        $erro = true;
    }

    $stmt->close();

    if (!$erro) {
        // Criptografar a senha antes de inseri-la no banco de dados
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Usar consultas preparadas para evitar injeção de SQL
        $stmt = $conn->prepare("INSERT INTO Administradores (usuario, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $usuario, $email, $senhaHash);

        if ($stmt->execute()) {
            $message = "O usuário foi cadastrado com sucesso.";
            // Redirecionar para a página de index após o cadastro
            header("Location: login.php");
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Cadastro Administrador</title>
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
    <div class="container">
        <form action="cadastro_adm.php" method="POST" class="registration-form">
            <h2>Cadastro</h2>
            
            <!-- Bloco de mensagem após o cadastro -->
            <?php if (!empty($message)) : ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>

            <label for="usuario">Nome</label>
            <input type="text" id="usuario" name="usuario" required>
           
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
           
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
           
            <button type="submit" class="custom-button">Cadastrar</button>

            
</html>
