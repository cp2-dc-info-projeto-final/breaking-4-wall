<?php
// Configuração das variáveis de conexão com o banco de dados
$servername = "localhost";
$username = "alvaro";
$password = "12345";
$dbname = "cadastro";
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
} elseif ($result->num_rows > 1) {
    // Se múltiplos filmes forem encontrados, liste-os
    echo "<h2>Filmes Encontrados:</h2>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li><a href='detalhes_filme.php?id=" . $row['ID'] . "'>" . htmlspecialchars($row['Titulo']) . "</a></li>";
    }
    echo "</ul>";
} else {
    echo "<p>Filme não encontrado.</p>";
}

$conn->close();
?>
