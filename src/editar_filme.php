<?php
session_start();
require_once 'conecta.php';

// Verifique se o usuário está logado como administrador
if (!isset($_SESSION['admin_id'])) {
    header('Location: login_adm.php');
    exit;
}

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
    <!-- Metadados e links para CSS -->
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
