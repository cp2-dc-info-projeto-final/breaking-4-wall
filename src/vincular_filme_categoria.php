<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vincular Filme a Categoria</title>
<style>
      body { font-family: Arial, sans-serif; }
    .container { width: 300px; padding: 16px; background-color: white; }
    select, button {
        width: 100%;
        padding: 10px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }
    button {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        opacity: 0.9;
    }
    button:hover {
        opacity:1;
    }
</style>
</head>
<body>

<div class="container">
  <form action="processa_vinculo.php" method="POST">
    <label for="filme">Filme:</label>
    <select id="filme" name="filmeID">
      <!-- Opções de filmes serão preenchidas pelo PHP abaixo -->
    </select>

    <label for="categoria">Categoria:</label>
    <select id="categoria" name="categoriaID">
      <!-- Opções de categorias serão preenchidas pelo PHP abaixo -->
    </select>

    <button type="submit">Vincular</button>
  </form>
</div>

<?php
// Código PHP para buscar as opções de filmes e categorias do banco de dados.

$servername = "localhost";
$username = "vitor";
$password = "1234567";
$dbname = "cadastro";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa a conexão
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

// Imprimir as opções de filmes e categorias
echo '<script>';
echo 'document.getElementById("filme").innerHTML = `' . $filmes_options . '`;';
echo 'document.getElementById("categoria").innerHTML = `' . $categorias_options . '`;';
echo '</script>';
?>

</body>
</html>
