<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "alvaro";
$password = "12345";
$dbname = "CADASTRO";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$search_query = $_GET['search_query'] ?? '';

// Prepara a consulta SQL
$sql = "SELECT ID, titulo FROM filmes WHERE titulo LIKE ?";
$stmt = $conn->prepare($sql);
$search_term = "%" . $search_query . "%";
$stmt->bind_param("s", $search_term);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($filme = $result->fetch_assoc()) {
        if (isset($filme["titulo"])) {
            // Cria um link para a página de detalhes passando o ID do filme
            echo "<a href='detalhes_filme.php?id=" . $filme["ID"] . "'>Título: " . $filme["titulo"] . "</a><br>";
        }
    }
} else {
    echo "Nenhum filme encontrado.";
}

$stmt->close();
$conn->close();
?>
