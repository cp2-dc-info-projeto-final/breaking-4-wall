<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Altere as informações de conexão abaixo de acordo com o seu banco de dados
    $servername = "localhost"; // Endereço do servidor de banco de dados
    $username_db = "seu_usuario"; // Nome de usuário do banco de dados
    $password_db = "sua_senha"; // Senha do banco de dados
    $database = "cadastro_br4w"; // Nome do banco de dados

    // Crie uma conexão com o banco de dados
    $conn = new mysqli($servername, $username_db, $senha_db, $database);

    // Verifique se ocorreu algum erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Aqui você pode executar as operações no banco de dados, como inserir os dados do usuário.

    // Feche a conexão com o banco de dados quando não precisar mais dela
    $conn->close();

    $message = "Usuário cadastrado com sucesso!";
}

?>
