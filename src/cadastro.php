<?php
$message = "";

// Informações de conexão com o banco de dados
$servername = "localhost"; // Endereço do servidor de banco de dados
$username_db = "cadastro"; // Nome de usuário do banco de dados
$password_db = "123"; // Senha do banco de dados
$database = "CADASTRO"; // Nome do banco de dados

// Crie uma conexão com o banco de dados
$conn = new mysqli("localhost", "cadastrado", "123", "CADASTRO");

// Verifique se ocorreu algum erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Incluir código para processar o envio do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    
    $erro = false; // Inicializar a variável $erro

    // Validação do nome
    if (empty($nome) || strpos($nome, " ") === false) {
        echo "Preencha seu nome completo com sobrenome.<br>";
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

    // Verificar se o email já está cadastrado
    $stmt = $conn->prepare("SELECT email FROM cadastrados WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Este endereço de email já está cadastrado.<br>";
        $erro = true;
    }

    $stmt->close();

    if (!$erro) {
        $stmt = $conn->prepare("INSERT INTO cadastrados (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senha);

        if ($stmt->execute()) {
            $message = "O usuário foi cadastrado com sucesso.";
        } else {
            $message = "Erro ao inserir dados: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Feche a conexão com o banco de dados quando não precisar mais dela
$conn->close();
?> 
