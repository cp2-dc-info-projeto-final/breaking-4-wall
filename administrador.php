<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Administrador</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/admin-dashboard.css">
</head>
<body>
    <!-- Cabeçalho -->
    <header class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Painel de Administração</a>
            </div>
            <div class="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Perfil</a></li>
                    <li><a href="#">Sair</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Corpo do Painel -->
    <div class="container-fluid">
        <div class="row">
            <!-- Barra Lateral -->
            <nav class="col-md-2">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="#">Dashboard</a></li>
                    <li><a href="#">Usuários</a></li>
                    <li><a href="#">Configurações</a></li>
                    <!-- Outros links do painel -->
                </ul>
            </nav>

            <!-- Conteúdo Principal -->
            <main class="col-md-10">
                <h1>Bem-vindo, [Nome do Administrador]</h1>
                <!-- PHP para carregar conteúdo dinâmico -->
                <?php
                // Aqui você pode incluir outros arquivos PHP ou escrever o código para mostrar o conteúdo
                ?>
            </main>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="footer">
        <p>&copy; 2023 Nome da Empresa</p>
    </footer>

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
