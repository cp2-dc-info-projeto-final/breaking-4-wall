<?php
session_start(); // Inicia a sessão para verificar o login do usuário

// Configuração das variáveis de conexão com o banco de dados
$servername = "localhost";
$username = "cadastrados";
$password = "123";
$dbname = "CADASTRO";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filmeId = isset($_GET['id']) ? $_GET['id'] : die('ID do filme não foi especificado.');

// Consulta para obter detalhes do filme
$stmt_filme = $conn->prepare("SELECT Titulo, AnoLancamento, Diretor, Sinopse FROM Filmes WHERE ID = ?");
$stmt_filme->bind_param("i", $filmeId);

// Verifica se a preparação da declaração foi bem-sucedida
if ($stmt_filme === false) {
    die('Erro na preparação da consulta do filme: ' . $conn->error);
}

$stmt_filme->execute();
$result_filme = $stmt_filme->get_result();
if ($result_filme->num_rows == 0) {
    die('Nenhum filme encontrado com o ID especificado.');
}

$filme = $result_filme->fetch_assoc();

// Consulta para buscar os atores do filme
$stmt_atores = $conn->prepare("SELECT a.ID, a.Nome FROM Atores a JOIN Atuacoes at ON a.ID = at.AtorID WHERE at.FilmeID = ?");
$stmt_atores->bind_param("i", $filmeId);
$stmt_atores->execute();
$result_atores = $stmt_atores->get_result();
$atores = $result_atores->fetch_all(MYSQLI_ASSOC);

// Consulta para buscar as categorias do filme
$stmt_categorias = $conn->prepare("SELECT c.Nome FROM Categorias c JOIN filmescategorias fc ON c.ID = fc.CategoriaID WHERE fc.FilmeID = ?");
$stmt_categorias->bind_param("i", $filmeId);
$stmt_categorias->execute();
$result_categorias = $stmt_categorias->get_result();
$categorias = $result_categorias->fetch_all(MYSQLI_ASSOC);

// Consulta para buscar os comentários do filme com nome do usuário
$stmt_comentarios = $conn->prepare("SELECT c.comentario, u.nome AS nome_usuario FROM comentarios c JOIN cadastrados u ON c.usuario_id = u.ID WHERE c.filme_id = ?");
$stmt_comentarios->bind_param("i", $filmeId);

// Verifica se a preparação da declaração foi bem-sucedida
if ($stmt_comentarios === false) {
    die('Erro na preparação da consulta de comentários: ' . $conn->error);
}

$stmt_comentarios->execute();
$result_comentarios = $stmt_comentarios->get_result();
$comentarios = $result_comentarios->fetch_all(MYSQLI_ASSOC);

// Fechar as declarações preparadas
$stmt_filme->close();
$stmt_atores->close();
$stmt_categorias->close();
$stmt_comentarios->close();

// Fechar conexão
$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title><?php echo htmlspecialchars($filme['Titulo']); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1a1a2e;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .filme-container {
            background-color: #2c2f33;
            border: 1px solid #676767;
            border-radius: 8px;
            padding: 2em;
            margin: 20px auto;
            width: 80%;
            max-width: 800px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .filme-card {
            margin-bottom: 20px;
        }

        .filme-titulo {
            font-size: 2.5em;
            color: #e4e6eb;
            text-shadow: 1px 1px 5px #000;
            margin-bottom: 0.5em;
        }

        .filme-info {
            background-color: #3a3b3c;
            border-radius: 4px;
            padding: 1em;
            margin-top: 1em;
        }

        .filme-details {
            margin-bottom: 20px;
        }

        .filme-ano,
        .filme-diretor {
            color: #b9bbbe;
            margin-bottom: 0.25em;
        }

        .filme-avaliacao {
            display: inline-block;
            margin-left: 20px;
            color: #b9bbbe;
        }

        .filme-imdb-logo {
            display: inline-block;
            margin-left: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background: linear-gradient(45deg, #ff0084, #3300ff);
            color: white;
            padding: 0.5em;
            margin-bottom: 0.5em;
            border-radius: 4px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        textarea {
            width: 100%;
            border-radius: 4px;
            border: 1px solid #555;
            padding: 0.5em;
            margin-top: 1em;
        }

        button {
            background-color: #ff0084;
            border: none;
            padding: 1em 2em;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 1em;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #3300ff;
        }

        .comentario {
            margin-top: 1em;
            border-top: 1px solid #676767;
            padding-top: 1em;
            text-align: left; /* Alinha o texto do comentário à esquerda */
        }

        .comentario p {
            margin: 0;
        }

        .comentario strong {
            color: #0099ff;
        }
        
        .numero-amarelo {
    color: #ffcc00; 
        }

    </style>
</head>

<body>
    <!-- Detalhes do Filme -->
    <div class="filme-container">
        <div class="filme-card">
            <?php
          $filmeData = array(
            1 => array('imagem' => 'spiderm.png', 'avaliacao_imdb' => '8.6'),
            2 => array('imagem' => 'john_wickd.png', 'avaliacao_imdb' => '7.7'),
            3 => array('imagem' => 'jogosmortaisd.png', 'avaliacao_imdb' => '6.6'),
            4 => array('imagem' => 'oppenheimer.png', 'avaliacao_imdb' => '8.4'),
            5 => array('imagem' => 'tuba.png', 'avaliacao_imdb' => '8.1'),
            6 => array('imagem' => 'vingadores.png', 'avaliacao_imdb' => '8.4'),
            7 => array('imagem' => 'exorcistad.png', 'avaliacao_imdb' => '8.2'),
        );

            // Obtém o ID do filme da consulta GET
            $filmeId = isset($_GET['id']) ? $_GET['id'] : null;

            // Verifica se o ID do filme é válido e existe nos dados do filme
            if ($filmeId && array_key_exists($filmeId, $filmeData)) {
                $filmeInfo = $filmeData[$filmeId];
                ?>
                <!-- Cartão <?php echo $filmeId; ?> -->
                <div class="card movie-card">
                    <a href="detalhes_filme.php?id=<?php echo $filmeId; ?>">
                        <img src="<?php echo $filmeInfo['imagem']; ?>" class="card-img-top zoom-img" alt="Filme <?php echo $filmeId; ?>">
                    </a>
                </div>
            <?php
            } else {
                // Se o ID do filme não for válido, você pode exibir uma mensagem ou redirecionar para uma página de erro.
                echo "ID do filme não válido.";
            }
            ?>
        </div>

        <div class="filme-info">
            <div class="filme-details">
                <h1 class="filme-titulo"><?php echo htmlspecialchars($filme['Titulo']); ?></h1>
                <p class="filme-ano"><strong>Ano de Lançamento:</strong> <?php echo htmlspecialchars($filme['AnoLancamento']); ?></p>
                <p class="filme-diretor"><strong>Diretor:</strong> <?php echo htmlspecialchars($filme['Diretor']); ?></p>

               <!-- Avaliação IMDb -->
                <div class="filme-avaliacao">
                    <strong>Avaliação IMDb:</strong>
                    <span class="numero-amarelo">
                        <?php echo isset($filmeInfo['avaliacao_imdb']) ? htmlspecialchars($filmeInfo['avaliacao_imdb']) : 'N/A'; ?>
                    </span>
                </div>

                <!-- Link do IMDb -->
                <div class="filme-imdb-logo">
                    <a href="https://www.imdb.com" target="_blank">
                        <img src="logo imdb.png" alt="IMDb" width="50">
                    </a>
                </div>


            <div class="filme-sinopse">
                <strong>Sinopse:</strong>
                <p><?php echo htmlspecialchars($filme['Sinopse']); ?></p>
            </div>
            <div class="filme-atores">
                <strong>Atores:</strong>
                <ul>
                    <?php foreach ($atores as $ator): ?>
                        <li><a href="detalhes_ator.php?id=<?php echo $ator['ID']; ?>"><?php echo htmlspecialchars($ator['Nome']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="filme-categorias">
                <strong>Categorias:</strong>
                <ul>
                    <?php foreach ($categorias as $categoria): ?>
                        <li><?php echo htmlspecialchars($categoria['Nome']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div id="secao-comentarios">
                <h3>Comentários</h3>
                <form action="inserir_comentario.php" method="post">
                    <input type="hidden" name="filme_id" value="<?php echo $filmeId; ?>">
                    <textarea name="comentario" placeholder="Escreva seu comentário aqui..." required></textarea>
                    <button type="submit">Enviar Comentário</button>
                </form>
                <?php foreach ($comentarios as $comentario): ?>
                    <div class="comentario">
                        <strong><?php echo htmlspecialchars($comentario['nome_usuario']); ?>:</strong>
                        <p><?php echo htmlspecialchars($comentario['comentario']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- JavaScript e Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
