<?php
$host = 'localhost';
$usuario = 'administrador';
$senha = 'ney123';
$banco = 'cadastro_admin';

$conn = new mysqli('localhost', 'administrador', 'ney123', 'cadastro_admin');


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO administradores (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha_hash);

    if ($stmt->execute()) {
        echo "Administrador cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar administrador: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Acesso inválido.";
}

$conn->close();
?>
