<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Filmes</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        form {
            background-color: #fff;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            display: block;
            margin-top: 20px;
            color: #666;
        }

        input[type=text],
        input[type=number],
        input[type=date], /* Adicionado o estilo para o campo de data */
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Include padding in the input width */
        }

        textarea {
            height: 100px;
            resize: vertical; /* Allows the user to resize the textarea vertically */
        }

        input[type=submit] {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #7b1fa2; /* Alterado para roxo */
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }

        input[type=submit]:hover {
            background-color: #5e1770; /* Alterado para um tom mais escuro de roxo ao passar o mouse */
        }
    </style>
</head>
<body>
    <form id="cadastroFilme" method="post" action="processa_cadastro.php">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br>

        <label for="anoLancamento">Ano de Lançamento:</label>
        <input type="date" id="anoLancamento" name="anoLancamento" required><br>

        <label for="diretor">Diretor:</label>
        <input type="text" id="diretor" name="diretor"><br>

        <label for="sinopse">Sinopse:</label>
        <textarea id="sinopse" name="sinopse"></textarea><br>

        <input type="submit" value="Cadastrar Filme">
    </form>

    <script src="cadastro.js"></script>
</body>
</html>
