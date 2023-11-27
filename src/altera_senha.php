<?php
// conecta_mysqli.inc

$servername = "localhost"; // Endereço do servidor de banco de dados
$username_db = "cadastrados"; // Nome de usuário do banco de dados
$password_db = "123"; // Senha do banco de dados
$database = "CADASTRO"; // Nome do banco de dados

// Crie uma conexão com o banco de dados
$mysqli = new mysqli($servername, $username_db, $password_db, $database);

// Verifique se ocorreu algum erro na conexão
if ($mysqli->connect_error) {
    die("Erro na conexão: " . $mysqli->connect_error);
}
?>

<html>
    <head>
        <title>Alteração de senha</title>
        <meta charset="UTF-8">
    </head>
    <style>

/* style.css */

body {
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    background-color: #e9ecef;
    color: #495057;
    margin: 0;
    padding: 40px;
}

.container {
    max-width: 400px;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
    color: #007bff;
    margin-bottom: 30px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="password"] {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    font-size: 16px;
}

input[type="submit"] {
    font-size: 16px;
    padding: 10px;
    border: none;
    border-radius: 4px;
    color: #fff;
    background-color: #007bff;
    cursor: pointer;
    transition: background-color 0.2s;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

.error-message {
    color: #dc3545;
    text-align: center;
    margin-bottom: 15px;
}


</style>
    <body>

        <?php
            if(isset($_SESSION["erro_senha"])){
                echo $_SESSION["erro_senha"];
                unset($_SESSION["erro_senha"]);
            }
        ?>

        <p><strong>Alterar senha:</strong></p>
        <form action="recebe_dados.php" method="POST">
            <input type="hidden" name="operacao" value="alterar_senha">
            <input type="hidden" name="cod_usuario" value="<?php echo $usuario['cod_usuario'] ?>">            
            <p>
                Senha atual: <input type="password" name="senha_atual" 
                size="10" placeholder="Digite a senha atual">
            </p>
            <p>
                Senha nova: <input type="password" name="senha_nova" 
                size="10" placeholder="Digite uma nova senha">
            </p>
            <p>
                Repita a senha nova: <input type="password" name="senha_rep" 
                size="30" placeholder="Digite novamente a senha nova">
            </p>
            <p><input type="submit" value="Enviar"></p>
        </form>
      
        
    </body>
</html>
