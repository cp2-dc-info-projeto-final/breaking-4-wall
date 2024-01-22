<?php
session_start();

require_once 'conecta.php';

// Verifica se o usuário está logado e se é um administrador
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header('Location: login.php');
    exit;
}

$adminId = $_SESSION["id"];

// Busca as informações do administrador logado na tabela Administradores
$sqlAdminLogado = "SELECT usuario, email FROM Administradores WHERE id = ?";
$stmtAdminLogado = $conn->prepare($sqlAdminLogado);

if (!$stmtAdminLogado) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmtAdminLogado->bind_param("i", $adminId);
$stmtAdminLogado->execute();
$resultAdminLogado = $stmtAdminLogado->get_result();

if ($resultAdminLogado->num_rows > 0) {
    $adminInfo = $resultAdminLogado->fetch_assoc();
} else {
    // Se não encontrar o administrador, redireciona para o login
    header('Location: login.php');
    exit;
}

$stmtAdminLogado->close();
?>

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
            background-color: #E6E6FA; /* Lilás claro para harmonizar com o roxo */
            color: #000000; /* Cor preta */
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #7b1fa2; /* Roxo mais escuro */
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff; /* Cor branca */
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #000000; /* Cor preta */
        }
        th {
            background-color: #7b1fa2; /* Roxo mais escuro */
            color: #ffffff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Cor cinza claro */
        }
        tr:hover {
            background-color: #e0e0e0; /* Cor cinza mais claro */
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
            background-color: #7b1fa2; /* Roxo mais escuro */
        }
        .delete-btn {
            background-color: #f44336; /* Cor vermelha */
        }
        .edit-btn:hover, .delete-btn:hover {
            opacity: 0.9;
        }
        a {
            color: #007BFF; /* Cor azul */
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
</body>
</html>

    </style>
</head>
<body>

</body>
</html>

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
