<?php
$servername = "localhost";
$username = "alvaro"; // Substitua pelo seu usuário do banco de dados
$password = "12345"; // Substitua pela sua senha do banco de dados
$dbname = "cadastro";

// Criar conexão
$conn = new mysqli("localhost", "alvaro", "12345", "cadastro");

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL para selecionar todos os filmes
$sql = "SELECT ID, Titulo, AnoLancamento, Diretor, Sinopse FROM Filmes";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Filmes</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <!-- Estilos e scripts necessários -->
</head>
<body>
    <h1>Lista de Filmes</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Ano de Lançamento</th>
                    <th>Diretor</th>
                    <th>Sinopse</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["ID"]; ?></td>
                    <td><a href="detalhes_filme.php?id=<?php echo $row['1']; ?>"><?php echo $row["Titulo"]; ?></a></td>
                    <td><?php echo $row["AnoLancamento"]; ?></td>
                    <td><?php echo $row["Diretor"]; ?></td>
                    <td><?php echo $row["Sinopse"]; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum filme encontrado.</p>
    <?php endif; ?>

    <?php
    // Fechar conexão
    $conn->close();
    ?>

</body>
</html>

