<?php
session_start();

$servername = "localhost";
$username_db = "cadastrados";
$password_db = "123";
$database = "CADASTRO";
$loginSuccessful = false;
$message = "";

// Criar conexão
$conn = new mysqli($servername, $username_db, $password_db, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se os dados foram enviados pelo método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Preparar a consulta SQL
    $stmt = $conn->prepare("SELECT id, senha FROM cadastrados WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($senha, $hashed_password)) {
            // Senha correta, inicia a sessão
            $_SESSION['user_id'] = $id;
            $_SESSION['user_email'] = $email;
            $_SESSION['login_successful'] = true; // Adiciona esta linha
            // Não redirecione aqui
        } else {
            // Senha incorreta
            $message = "Senha incorreta. Tente novamente.";
        }
        
    } else {
        $message = "Usuário não encontrado.";
    }

    $stmt->close();
}
$conn->close();

// Redirecionamento após login bem-sucedido
if ($loginSuccessful) {
    echo "<p>Login concluído. Redirecionando...</p>";
    echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 5000);</script>";
    exit;
}
s
