<?php
// Configuração das variáveis de conexão com o banco de dados
$servername = "localhost";
$username = "vitor";
$password = "1234567";
$dbname = "cadastro";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Buscar filmes
$stmt_filmes = $conn->prepare("SELECT ID, Titulo FROM Filmes");
$stmt_filmes->execute();
$result_filmes = $stmt_filmes->get_result();
$filmes_options = '';
while ($filme = $result_filmes->fetch_assoc()) {
    $filmes_options .= '<option value="' . $filme['ID'] . '">' . htmlspecialchars($filme['Titulo']) . '</option>';
}
$stmt_filmes->close();

// Buscar categorias
$stmt_categorias = $conn->prepare("SELECT ID, Nome FROM Categorias");
$stmt_categorias->execute();
$result_categorias = $stmt_categorias->get_result();
$categorias_options = '';
while ($categoria = $result_categorias->fetch_assoc()) {
    $categorias_options .= '<option value="' . $categoria['ID'] . '">' . htmlspecialchars($categoria['Nome']) . '</option>';
}
$stmt_categorias->close();

// Fechar a conexão com o banco de dados
$conn->close();
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
