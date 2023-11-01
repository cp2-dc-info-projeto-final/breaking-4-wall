<?php
// Inclua o código de conexão com o banco de dados
require_once("conexao.php");

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário
    $titulo = $_POST["titulo"];
    $ano_lancamento = $_POST["ano_lancamento"];
    $diretor = $_POST["diretor"];
    $sinopse = $_POST["sinopse"];

    // Valide os dados (você pode adicionar mais validações conforme necessário)
    if (empty($titulo)) {
        echo "O campo Título é obrigatório.";
    } else {
        // Prepare a instrução SQL para inserção dos dados na tabela Filmes
        $sql = "INSERT INTO Filmes (Titulo, AnoLancamento, Diretor, Sinopse) VALUES (?, ?, ?, ?)";

        // Crie uma declaração preparada
        $stmt = $conexao->prepare($sql);

        // Verifique se a preparação foi bem-sucedida
        if ($stmt) {
            // Vincule os parâmetros e execute a inserção
            $stmt->bind_param("siss", $titulo, $ano_lancamento, $diretor, $sinopse);

            if ($stmt->execute()) {
                echo "Filme cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar o filme: " . $stmt->error;
            }

            // Feche a declaração preparada
            $stmt->close();
        } else {
            echo "Erro na preparação da declaração SQL: " . $conexao->error;
        }
    }
} else {
    // Redirecione para a página de cadastro se o formulário não foi enviado
    header("Location: cadastro_filmes.html");
    exit();
}

// Feche a conexão com o banco de dados
$conexao->close();
?>

