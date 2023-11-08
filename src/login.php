<?php
$message = "";

$servername = "localhost"; // Endereço do servidor de banco de dados
$username_db = "cadastrado"; // Nome de usuário do banco de dados
$password_db = "123"; // Senha do banco de dados
$database = "CADASTRO"; // Nome do banco de dados

// Crie uma conexão com o banco de dados
$conn = new mysqli("localhost", "cadastrados", "123", "CADASTRO");

// Verifique se ocorreu algum erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Incluir código para processar o envio do formulário de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Verificar as credenciais do usuário
    $stmt = $conn->prepare("SELECT id, senha FROM cadastrados WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();
    
    if (password_verify($senha, $hashed_password)) {
        header("location: index.html");
    } else {
        $message = "Credenciais inválidas. Tente novamente.";
    }
    
    $stmt->close();
}

// Feche a conexão com o banco de dados quando não precisar mais dela
$conn->close();
?>
