<?php
session_start();

require_once 'conecta.php';

// Verifica se o ID do administrador está na sessão e se é válido
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('Location: login_adm.php');
    exit;
}

$adminId = $_SESSION['admin_id'];

// Busca as informações do administrador logado no banco de dados
$sqlAdminLogado = "SELECT usuario, email FROM Administradores WHERE id = ?";
$stmtAdminLogado = $conn->prepare($sqlAdminLogado);
if (!$stmtAdminLogado) {
    // Trata o erro adequadamente (pode ser uma questão do banco de dados ou SQL)
    die('Erro na preparação da consulta: ' . $conn->error);
}
$stmtAdminLogado->bind_param("i", $adminId);
$stmtAdminLogado->execute();
$resultAdminLogado = $stmtAdminLogado->get_result();

$adminInfo = [];
if ($resultAdminLogado->num_rows > 0) {
    $adminInfo = $resultAdminLogado->fetch_assoc();
} else {
    // Caso não encontre o administrador, redirecione para a página de login.
    header('Location: login_adm.php');
    exit;
}
$stmtAdminLogado->close();

// O restante do seu código HTML segue aqui...
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração - Perfil</title>
    <style>
        /* Estilos Gerais */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }

        /* Estilização da Sidebar */
        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background: #252839; /* Um azul escuro como base da sidebar */
            color: #fff;
            padding: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ff6b6b; /* Um rosa-avermelhado para o título, como na logo */
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li a {
            color: #ddd;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover {
            background: #ff6b6b; /* Realçar com rosa-avermelhado ao passar o mouse */
            color: #fff;
        }

        /* Conteúdo Principal */
        .content {
            margin-left: 250px;
            padding: 20px;
            color: #333;
        }

        .content h1 {
            color: #ff6b6b; /* Título da página com a cor rosa-avermelhada */
        }

        /* Estilização da Tabela */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #4a4e69; /* Azul mais claro para cabeçalho da tabela */
            color: white;
        }

        td {
            background-color: #fff; /* Fundo branco para as células */
        }

        /* Botões */
        button {
            padding: 10px 15px;
            margin-right: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            outline: none; /* Remove o contorno ao focar */
        }

        .edit-btn {
            background-color: #4ecdc4; /* Verde-azulado para botão editar */
            color: white;
        }

        .delete-btn {
            background-color: #ff6b6b; /* Rosa-avermelhado para botão excluir */
            color: white;
        }

        .edit-btn:hover {
            background-color: #3b9b8f; /* Verde-azulado escuro ao passar o mouse */
        }

        .delete-btn:hover {
            background-color: #e55050; /* Vermelho escuro ao passar o mouse */
        }

        /* Resposta para dispositivos móveis */
        @media (max-width: 768px) {
            .sidebar {
                width: 100px; /* Menos largura para sidebar em telas menores */
            }

            .content {
                margin-left: 120px;
            }

            .sidebar h2,
            .sidebar ul li a {
                font-size: smaller; /* Texto menor para ajustar ao sidebar mais estreito */
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
<h2>Painel de Administração</h2>
    <ul>
        <li><a href="index.html">Início</a></li>
        <li><a href="lista_filmes.php">Filmes</a></li>
        <li><a href="cadastro_filmes.html">Cadastro de Filmes</a></li>
        <li><a href="cadastro_atores.html">Cadastro de Atores</a></li>
        <li><a href="lista_cadastrados.php">Cadastrados</a></li>
        
    </ul>
</div>

<div class="content">
    <h1>Perfil do Administrador</h1>
    
    <div class="perfil-admin">
        <p>Nome: <?php echo htmlspecialchars($adminInfo['usuario']); ?></p>
        <p>Email: <?php echo htmlspecialchars($adminInfo['email']); ?></p>
        <p><a href="editar_administrador.php?id=<?php echo $adminId; ?>" class="edit-btn">Editar Perfil</a></p>
        <p><a href="excluir_admin.php?id=<?php echo $adminId; ?>" class="delete-btn" onclick="return confirm('Tem certeza que deseja excluir este administrador?');">Excluir Perfil</a></p>
    </div>

</div>

</body>
</html>
