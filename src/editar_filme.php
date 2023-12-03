<?php
session_start();
require_once 'conecta.php';

// Garantir que um ID de filme foi passado
if (!isset($_GET['id'])) {
    echo "ID do filme não fornecido.";
    exit;
}

$filmeId = $_GET['id'];

// Buscar informações do filme
$sql = "SELECT * FROM Filmes WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $filmeId);
$stmt->execute();
$resultado = $stmt->get_result();
$filme = $resultado->fetch_assoc();

// Verificar se o filme foi encontrado
if (!$filme) {
    echo "Filme não encontrado.";
    exit;
}

// Se o formulário foi submetido, atualize o filme
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $anoLancamento = $_POST['anoLancamento'];
    $diretor = $_POST['diretor'];
    $sinopse = $_POST['sinopse'];

    $updateSql = "UPDATE Filmes SET Titulo = ?, AnoLancamento = ?, Diretor = ?, Sinopse = ? WHERE ID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param('sissi', $titulo, $anoLancamento, $diretor, $sinopse, $filmeId);

    if ($updateStmt->execute()) {
        echo "Filme atualizado com sucesso!";
        // Redirecione para a lista de filmes após a atualização
        header('Location: lista_filmes.php');
        exit;
    } else {
        echo "Erro ao atualizar filme: " . $updateStmt->error;
    }

    $updateStmt->close();
}

$conn->close();
?>

<!-- O formulário de edição -->
<!DOCTYPE html>
<html lang="pt">
<head>
<style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #5C7AEA;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #4a69bd;
        }

        /* Estilo de erro para mensagem */
        .error-message {
            color: #D8000C;
            background-color: #FFD2D2;
            border: 1px solid #D8000C;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 4px;
        }

        /* Estilo de sucesso para mensagem */
        .success-message {
            color: #4F8A10;
            background-color: #DFF2BF;
            border: 1px solid #4F8A10;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <form action="editar_filme.php?id=<?php echo $filmeId; ?>" method="post">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($filme['Titulo']); ?>" required>

        <label for="anoLancamento">Ano de Lançamento:</label>
        <input type="number" id="anoLancamento" name="anoLancamento" value="<?php echo htmlspecialchars($filme['AnoLancamento']); ?>" required>

        <label for="diretor">Diretor:</label>
        <input type="text" id="diretor" name="diretor" value="<?php echo htmlspecialchars($filme['Diretor']); ?>" required>

        <label for="sinopse">Sinopse:</label>
        <textarea id="sinopse" name="sinopse" required><?php echo htmlspecialchars($filme['Sinopse']); ?></textarea>

        <button type="submit">Atualizar Filme</button>
    </form>
</body>
</html>
