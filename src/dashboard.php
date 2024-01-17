<?php
session_start();

require_once 'conecta.php';

// Verifica se o usuário está logado e se é um administrador
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header('Location: login.php');
    exit;
}

$adminId = $_SESSION["id"];

// Busca as informações do administrador logado na tabela Administradores
$sqlAdminLogado = "SELECT usuario, email FROM Administradores WHERE id = ?";
$stmtAdminLogado = $conn->prepare($sqlAdminLogado);

if (!$stmtAdminLogado) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmtAdminLogado->bind_param("i", $adminId);
$stmtAdminLogado->execute();
$resultAdminLogado = $stmtAdminLogado->get_result();

if ($resultAdminLogado->num_rows > 0) {
    $adminInfo = $resultAdminLogado->fetch_assoc();
} else {
    // Se não encontrar o administrador, redireciona para o login
    header('Location: login.php');
    exit;
}

$stmtAdminLogado->close();
?>



<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração - Perfil</title>
    <style>
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
    color: #ff6b6b; /* Um rosa-avermelhado para o título */
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
    max-width: calc(100% - 250px);
    box-sizing: border-box;
}

.content h1 {
    color: #ff6b6b; /* Título da página com a cor rosa-avermelhada */
    font-size: 2.5rem; /* Tamanho do título */
    text-align: left;
    margin-bottom: 0.5em;
}

/* Estilização do Perfil do Administrador */
.perfil-admin {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    max-width: 600px; /* Ajustar conforme necessário */
    margin: 20px auto;
    text-align: left;
}

.perfil-admin p {
    font-size: 1.1rem;
    color: #333;
    line-height: 1.5;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
    margin-bottom: 10px;
}

.perfil-admin p:last-child {
    border-bottom: none;
}

.edit-btn, .delete-btn {
    text-decoration: none;
    display: inline-block;
    font-weight: bold;
    text-align: center;
    width: calc(50% - 10px);
    margin-bottom: 10px;
    padding: 10px 15px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.edit-btn {
    background-color: #4ecdc4; /* Verde-azulado para botão editar */
    color: white;
    margin-right: 20px;
}

.delete-btn {
    background-color: #ff6b6b; /* Rosa-avermelhado para botão excluir */
    color: white;
}

.edit-btn:hover, .delete-btn:hover {
    opacity: 0.8;
}

/* Resposta para dispositivos móveis */
@media (max-width: 768px) {
    .sidebar {
        width: 100px; /* Menos largura para sidebar em telas menores */
    }

    .content {
        margin-left: 120px;
        max-width: calc(100% - 120px);
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
        <li><a href="cadastro_adm.php">Cadastrado de ADM</a></li>
        <li><a href="cadastro_filmes.php">Cadastro de Filmes</a></li>
        <li><a href="cadastro_atores.php">Cadastro de Atores</a></li>
        <li><a href="vincular_atuacao.php">Vincular Atuações</a></li>
        <li><a href="lista_cadastrados.php">Cadastrados</a></li>
        <li><a href="cadastro_categoria.php">Cadastro de Categorias</a></li>
        <li><a href="vincular_filme_categoria.php">Vincular Filme e Categoria</a></li>
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
