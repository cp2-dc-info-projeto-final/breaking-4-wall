<?php
session_start();
require_once 'conecta.php';

// Verifica se o usuário está logado e se o ID foi passado
if (!isset($_GET['id'], $_SESSION['admin_id']) || $_GET['id'] != $_SESSION['admin_id']) {
    // Se não estiver logado ou o ID não corresponder, não faça nada (nenhuma mensagem será exibida)
    // Você pode adicionar lógica adicional aqui, se necessário
}

$adminId = $_GET['id'];

// Inicia uma transação para garantir a integridade dos dados
$conn->begin_transaction();

try {
    // Prepara a consulta SQL para excluir o administrador
    $sql = "DELETE FROM Administradores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception('Não foi possível preparar a declaração: ' . $conn->error);
    }

    // Vincula o parâmetro e executa a consulta
    $stmt->bind_param('i', $adminId);
    $stmt->execute();
    
    // Verifica se a exclusão foi bem-sucedida
    if ($stmt->affected_rows > 0) {
        // Se você estiver usando sessões para armazenar informações do administrador, limpe-as aqui
        unset($_SESSION['admin_id']);
        // Commit da transação
        $conn->commit();
        // Redireciona para a página de login ou para a lista de administradores
        header('Location: cadastro_adm.php');
        exit;
    } else {
        throw new Exception('Nenhum administrador foi excluído.');
    }
} catch (Exception $e) {
    // Se ocorrer algum erro, desfaz as alterações
    $conn->rollback();
    // Você pode registrar ou lidar com o erro de alguma forma, mas evite exibir detalhes sensíveis no navegador
} finally {
    // Fecha a declaração e a conexão
    $stmt->close();
    $conn->close();
}
?>
