<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($ator['Nome']); ?></title>
    <style>
                body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #161b2e; /* Azul escuro */
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            background-color: #2c2f44; /* Azul escuro mais claro */
            border: 1px solid #394867; /* Tom intermediário entre azul escuro e roxo */
            border-radius: 8px;
            padding: 2em;
            width: 80%;
            max-width: 800px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .title {
            font-size: 2.5em;
            color: #d3d8f3; /* Roxo claro */
            text-shadow: 1px 1px 5px #0e1239; /* Sombra no texto para efeito 3D */
            margin-bottom: 0.5em;
        }

        .info {
            color: #b9bbbe;
            margin-bottom: 0.25em;
        }

        .details-section {
            background-color: #3a3e5c; /* Roxo escuro */
            border-radius: 4px;
            padding: 1em;
            margin-top: 1em;
            text-align: left;
        }

        .details-section strong {
            color: #9f7aea; /* Roxo claro para títulos das seções */
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        .list-item {
            background: linear-gradient(45deg, #6573c3, #33425b); /* Gradiente em tons de roxo e azul escuro */
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
            background-color: #9f7aea; /* Roxo claro */
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
            background-color: #805ad5; /* Roxo mais escuro no hover */
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 1em;
            }

            .title {
                font-size: 1.8em;
            }
        }

        .comment {
            margin-top: 1em;
            border-top: 1px solid #676767;
            padding-top: 1em;
        }

        .comment p {
            margin: 0;
        }

        .comment strong {
            color: #9f7aea; /* Roxo claro */
        }
   
   </style>
</head>
<body>

  <div class="container">
    <h1>Informações do Ator</h1>
    <div id="actor-details">
      <?php
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

        // Obtém o ID do ator a partir dos parâmetros da URL
        $ator_id = isset($_GET['id']) ? $_GET['id'] : null;

        // Verifica se o ID do ator existe e exibe os detalhes
        if ($ator_id) {
          $stmt_ator = $conn->prepare("SELECT Nome, DataNascimento, Nacionalidade, Genero, Biografia FROM Atores WHERE ID = ?");
          $stmt_ator->bind_param("i", $ator_id);
          $stmt_ator->execute();
          $result_ator = $stmt_ator->get_result();

          if ($result_ator->num_rows > 0) {
            $ator = $result_ator->fetch_assoc();
            echo "
              <h2>{$ator['Nome']}</h2>
              <p><strong>Data de Nascimento:</strong> {$ator['DataNascimento']}</p>
              <p><strong>Nacionalidade:</strong> {$ator['Nacionalidade']}</p>
              <p><strong>Gênero:</strong> {$ator['Genero']}</p>
              <p><strong>Biografia:</strong> {$ator['Biografia']}</p>
            ";
          } else {
            echo "<p>Ator não encontrado</p>";
          }

          // Fechar a declaração preparada
          $stmt_ator->close();
        }

        // Fechar conexão
        $conn->close();
      ?>
    </div>
  </div>
</body>
</html>
