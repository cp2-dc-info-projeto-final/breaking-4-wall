<?php
session_start(); // Inicia a sessão para verificar o login do usuário

// Configuração das variáveis de conexão com o banco de dados
$servername = "localhost";
$username = "alvaro";
$password = "12345";
$dbname = "cadastro";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Certifique-se de que um ID foi passado na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID do filme não foi especificado.');
}

$filmeId = $_GET['id'];

// Consulta atualizada para incluir as categorias
$stmt = $conn->prepare("
    SELECT f.Titulo, f.AnoLancamento, f.Diretor, f.Sinopse, GROUP_CONCAT(c.Nome SEPARATOR ', ') AS Categorias
    FROM Filmes f
    LEFT JOIN FilmesCategorias fc ON f.ID = fc.FilmeID
    LEFT JOIN Categorias c ON fc.CategoriaID = c.ID
    WHERE f.ID = ?
    GROUP BY f.ID
");
$stmt->bind_param("i", $filmeId);
$stmt->execute();
$result = $stmt->get_result();

// Se nenhum filme for encontrado, exiba uma mensagem
if ($result->num_rows === 0) {
    die('Filme não encontrado.');
}

// Pegue os dados do filme, incluindo as categorias
$filme = $result->fetch_assoc();

// Defina o caminho da imagem do poster diretamente aqui
$caminhoImagem = "mengo.png"; // Este valor deve ser o caminho correto da imagem do poster

// Feche a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($filme['Titulo']); ?></title>
    <style>
               body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .filme-container {
            background-color: #fff;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .filme-titulo {
            color: #333;
        }
        .filme-ano {
            color: #777;
        }
        .filme-diretor {
            color: #555;
        }
        .filme-sinopse {
            margin-top: 20px;
        }
        .filme-imagem {
            max-width: 100%;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="filme-container">
        <h1 class="filme-titulo"><?php echo htmlspecialchars($filme['Titulo']); ?></h1>
        <p class="filme-ano"><strong>Ano de Lançamento:</strong> <?php echo htmlspecialchars($filme['AnoLancamento']); ?></p>
        <p class="filme-diretor"><strong>Diretor:</strong> <?php echo htmlspecialchars($filme['Diretor']); ?></p>
        <div class="filme-sinopse">
            <strong>Sinopse:</strong>
            <p><?php echo htmlspecialchars($filme['Sinopse']); ?></p>
        </div>
        <!-- Adiciona a exibição das categorias aqui -->
        <p><strong>Categoria(s):</strong> <?php echo htmlspecialchars($filme['Categorias']); ?></p>
        <img class="filme-imagem" src="<?php echo $caminhoImagem; ?>" alt="Poster do filme">
    </div>
</body>
</html>
