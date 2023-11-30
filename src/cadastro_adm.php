<?php
require_once 'conecta.php'; // Conexão com o banco de dados

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['username'];
    $email = $_POST['email'];
    $senha = $_POST['password'];

    // Validação dos dados (opcional, mas recomendado)

    // Criptografar a senha antes de salvar no banco de dados
    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

    // Prepara a consulta SQL para inserir o administrador
    $sql = "INSERT INTO Administradores (usuario, email, senha) VALUES (?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        // Vincula variáveis à consulta preparada como parâmetros
        $stmt->bind_param("sss", $usuario, $email, $senhaCriptografada);

        // Tente executar a consulta
        try {
            if ($stmt->execute()) {
                echo "Administrador cadastrado com sucesso!";
                // Adicione um link para a página de login
                echo '<br><a href="login_adm.html">Ir para a página de login</a>';
            } else {
                echo "Erro ao cadastrar administrador: " . $stmt->error;
            }
        } catch (mysqli_sql_exception $e) {
            // Tratar exceção de chave duplicada
            if ($e->getCode() === 1062) {
                echo "Erro: Este usuário já existe.";
            } else {
                echo "Erro ao cadastrar administrador: " . $e->getMessage();
            }
        }

        // Fecha o statement
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}
?>
