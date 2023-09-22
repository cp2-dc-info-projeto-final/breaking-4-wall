<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Informações de conexão com o banco de dados
    $servername = "localhost"; // Endereço do servidor de banco de dados
    $username_db = "cadastro"; // Nome de usuário do banco de dados
    $password_db = "123"; // Senha do banco de dados
    $database = "CADASTRO"; // Nome do banco de dados

    // Crie uma conexão com o banco de dados
    $conn = new mysqli($servername, $username_db, $password_db, $database);

    // Verifique se ocorreu algum erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $email = $_POST["email"];
    $senha = $_POST["senha"];
    
    // Você deve implementar a lógica de autenticação aqui, por exemplo:
    // Consultar o banco de dados para verificar se o email e a senha correspondem a um usuário registrado.
    // Se a autenticação for bem-sucedida, você pode redirecionar o usuário para a página de perfil, por exemplo.

    // Exemplo simples de autenticação (não seguro - apenas para fins de demonstração)
    $stmt = $conn->prepare("SELECT * FROM cadastrados WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        // Autenticação bem-sucedida
        session_start();
        $_SESSION["email"] = $email;
        header("Location: perfil.php"); // Redirecione para a página de perfil
        exit();
    } else {
        $message = "Email ou senha incorretos. Tente novamente.";
    }

    $stmt->close();
    $conn->close();
}
?>
