<?php
$servername = "localhost";
$username = "cadastrados"; // Seu nome de usuário do banco de dados
$password = "123"; // Sua senha do banco de dados
$dbname = "CADASTRO"; // Nome do seu banco de dados

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
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
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #ffffff; /* Alterado para branco */
            color: #000000; /* Alterado para preto */
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #ff4081;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #000000; /* Alterado para preto */
        }
        th {
            background-color: #7b1fa2;
            color: #ffffff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Alterado para cinza claro */
        }
        tr:hover {
            background-color: #e0e0e0; /* Alterado para cinza mais claro */
        }

        /* Estilos para os botões de editar e excluir */
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block; /* Para os botões ficarem lado a lado */
            margin-right: 5px; /* Espaçamento entre os botões */
        }
        .edit-btn {
            background-color: #7b1fa2; /* Alterado para roxo */
        }
        .delete-btn {
            background-color: #f44336; /* Mantido vermelho */
        }
        .edit-btn:hover, .delete-btn:hover {
            opacity: 0.9;
        }
        a {
            color: #007BFF; /* Alterado para azul */
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Lista de Filmes</h1>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Ano de Lançamento</th>
                    <th>Diretor</th>
                    <th>Sinopse</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["ID"]; ?></td>
                    <td><a href="detalhes_filme.php?id=<?php echo $row['ID']; ?>"><?php echo $row["Titulo"]; ?></a></td>
                    <td><?php echo $row["AnoLancamento"]; ?></td>
                    <td><?php echo $row["Diretor"]; ?></td>
                    <td><?php echo $row["Sinopse"]; ?></td>
                    <td>
                        <a href="editar_filme.php?id=<?php echo $row['ID']; ?>" class="edit-btn">Editar</a>
                        <a href="excluir_filme.php?id=<?php echo $row['ID']; ?>" class="delete-btn">Excluir</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum filme encontrado.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>

</body>
</html>
