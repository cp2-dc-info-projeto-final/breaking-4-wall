<?php
session_start(); // Inicia a sessão para armazenar mensagens de feedback

// Dados de conexão ao banco de dados
$servername = "localhost";
$username = "vitor";
$password = "1234567";
$dbname = "cadastro";

// Variável para armazenar mensagens de feedback
$message = '';

// Checa se os dados foram enviados pelo formulário
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["filmeID"]) && isset($_POST["categoriaID"])) {
    // Cria a conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Checa a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $filmeID = $_POST["filmeID"];
    $categoriaID = $_POST["categoriaID"];

    // Prepara a inserção dos dados no banco
    $stmt = $conn->prepare("INSERT INTO FilmesCategorias (FilmeID, CategoriaID) VALUES (?, ?)");
    $stmt->bind_param("ii", $filmeID, $categoriaID);

    // Executa o statement
    if ($stmt->execute()) {
        $_SESSION['message'] = "Vínculo entre filme e categoria realizado com sucesso!";
    } else {
        $_SESSION['message'] = "Erro ao realizar o vínculo: " . $stmt->error;
    }

    // Fecha o statement e a conexão com o banco de dados
    $stmt->close();
    $conn->close();

    // Redireciona para a mesma página para evitar reenvio do formulário
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Se uma mensagem foi definida na sessão, armazena-a na variável $message e limpa a sessão
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vincular Filme a Categoria</title>
    <style>
    body {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        background-color: #ecf0f1;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        max-width: 350px;
        width: 100%;
    }
    h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 20px;
    }
    label {
        margin-top: 10px;
        color: #7f8c8d;
        font-weight: 600;
    }
    select, button {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #bdc3c7;
        border-radius: 4px;
        box-sizing: border-box;
    }
    button {
        background-color: #3498db;
        color: white;
        font-size: 16px;
        border: none;
        margin-top: 20px;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    button:hover {
        background-color: #2980b9;
    }
</style>
    </style>
</head>
<body>

<div class="container">
    <form action="vincular_filme_categoria.php" method="POST">
        <label for="filme">Filme:</label>
        <select id="filme" name="filmeID">
            <?php echo $filmes_options; ?>
        </select>

        <label for="categoria">Categoria:</label>
        <select id="categoria" name="categoriaID">
            <?php echo $categorias_options; ?>
        </select>

        <button type="submit">Vincular</button>
    </form>
</div>

</body>
</html>
