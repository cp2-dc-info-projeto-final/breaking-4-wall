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
        /* Estilos existentes */
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

/* Estilos adicionados para os botões de ação */
.action-btn {
    color: white;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 5px;
    margin-right: 8px;
    display: inline-block; /* Adicionado para melhor alinhamento dos botões */
    font-size: 0.9em; /* Adicionado para garantir que o tamanho do texto seja adequado */
}

.edit-btn {
    background-color: #ffc107;
}

.delete-btn {
    background-color: #dc3545;
}

/* Adicionando estilos de hover para feedback ao usuário */
.action-btn:hover {
    opacity: 0.9; /* Efeito de transparência ao passar o mouse */
    text-decoration: none; /* Garante que o texto não será sublinhado ao passar o mouse */
}

/* Adicionando estilo para o cursor para melhorar a UX */
.action-btn:hover {
    cursor: pointer;
}

    </style>
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
                    <th>Ações</th> <!-- Cabeçalho para os botões de ação -->
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["ID"]; ?></td>
                    <td><?php echo $row["Titulo"]; ?></td>
                    <td><?php echo $row["AnoLancamento"]; ?></td>
                    <td><?php echo $row["Diretor"]; ?></td>
                    <td><?php echo $row["Sinopse"]; ?></td>
                    <td>
                        <a href="editar_filme.php?id=<?php echo $row['ID']; ?>" class="action-btn edit-btn">Editar</a>
                        <a href="excluir_filme.php?id=<?php echo $row['ID']; ?>" class="action-btn delete-btn" onclick="return confirm('Tem certeza que deseja excluir este filme?');">Excluir</a>
                    </td>
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

