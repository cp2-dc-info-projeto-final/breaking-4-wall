<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado, caso contrário, redireciona para a página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Armazena a página atual na sessão para que possamos redirecionar o usuário de volta após o login
    $_SESSION["redirect_to"] = $_SERVER['REQUEST_URI'];
    
    // Redireciona para a página de login
    header("Location: login.php");
    exit;
}
?>
