<?php
// Dados de conexão ao banco de dados
$servername = "localhost";
$username = "cadastrados";
$password = "123";
$dbname = "CADASTRO";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchQuery = $_GET["search_query"];
$searchTerm = "%" . $conn->real_escape_string($searchQuery) . "%";

$stmt = $conn->prepare("SELECT ID, Titulo FROM Filmes WHERE Titulo LIKE ?");
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // Se apenas um filme for encontrado, redirecione para a página de detalhes
    $row = $result->fetch_assoc();
    $filmeId = $row['ID'];
    header("Location: detalhes_filme.php?id=" . $filmeId);
    exit();
} elseif ($result->num_rows > 1) 
?>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1a1a2e;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .filme-list-container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #2c2f33;
            border: 1px solid #676767;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        h2 {
            color: #e4e6eb;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            background: linear-gradient(45deg, #ff0084, #3300ff);
            color: white;
            padding: 0.5em;
            margin-bottom: 0.5em;
            border-radius: 4px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        p {
            color: #b9bbbe;
        }
    </style>

    <title>Sua Página de Filmes</title>
</head>

<body>
    <?php

    // Se múltiplos filmes forem encontrados, liste-os
    echo "<div class='filme-list-container'>";
    echo "<h2>Filmes Encontrados:</h2>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li><a href='detalhes_filme.php?id=" . $row['ID'] . "'>" . htmlspecialchars($row['Titulo']) . "</a></li>";
    }
    echo "</ul>";
    echo "</div>";
    ?>
</body>

</html>

<?php
// Fechar conexão
$conn->close();
?>
