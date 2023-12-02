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

// Verifica se 'search_query' foi definido no GET, se não, define como vazio
$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// Prepara a consulta SQL
$sql = "SELECT ID FROM filmes WHERE titulo LIKE ?";
$stmt = $conn->prepare($sql);
$search_term = "%" . $search_query . "%";
$stmt->bind_param("s", $search_term);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $filme = $result->fetch_assoc();
    header('Location: detalhes_filme.php?id=' . $filme["ID"]);
    exit;
} else {
    echo "Nenhum filme encontrado.";
}

$stmt->close();
$conn->close();
?>
