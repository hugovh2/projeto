<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redireciona o usuário de volta para a página de login
    header("Location: login.php");
    exit();
}

// Verifica a permissão de visualização de usuários
$permissao_login = $_SESSION['permissao_login'] ?? false;
$permissao_usuario_add = $_SESSION['permissao_usuario_add'] ?? false;
$permissao_usuario_editar = $_SESSION['permissao_usuario_editar'] ?? false;
$permissao_usuario_deletar = $_SESSION['permissao_usuario_deletar'] ?? false;

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tabela";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se foi fornecido um termo de pesquisa
if (isset($_GET['pesquisa']) && !empty($_GET['pesquisa'])) {
    $pesquisa = $_GET['pesquisa'];
    // Constrói a consulta SQL com a cláusula WHERE para buscar os usuários pelo nome
    $sql = "SELECT * FROM usuario WHERE nome LIKE '%$pesquisa%'";
} else {
    $sql = "SELECT * FROM usuario";
}

// Consulta os usuários cadastrados
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div id="site">
        <header>
            <h1>USUÁRIOS</h1>
            <form class="busca" action="">
                <i><img src="images/lupa.svg"></i>
                <input type="text" name="pesquisa" placeholder="Pesquisar..." value="<?php echo isset($_GET['pesquisa']) ? $_GET['pesquisa'] : ''; ?>">
            </form>
            <figure></figure>
            <a class="sair" href="login.php">sair</a>
        </header>

        <ul>
            <li class="titulo">
                <div class="texto nome">Nome</div>
                <div class="texto cpf">CPF</div>
                <div class="texto email">E-MAIL</div>
                <div class="texto data">DATA</div>
                <div class="texto status">STATUS</div>
                <?php if ($permissao_usuario_editar) { ?>
                    <div class="editar"></div>
                <?php } ?>
                <?php if ($permissao_usuario_deletar) { ?>
                    <div class="deletar"></div>
                <?php } ?>
            </li>
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <li>
                        <div class="texto nome"><?php echo $row['nome']; ?></div>
                        <div class="texto cpf"><?php echo $row['cpf']; ?></div>
                        <div class="texto email"><?php echo $row['email']; ?></div>
                        <div class="texto data"><?php echo $row['data']; ?></div>
                        <div class="texto status"><?php echo $row['status']; ?></div>
                        <?php if ($permissao_usuario_editar) { ?>
                            <div class="editar"><a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a></div>
                        <?php } ?>
                        <?php if ($permissao_usuario_deletar) { ?>
                            <div class="deletar"><a href="deletar.php?id=<?php echo $row['id']; ?>">Deletar</a></div>
                        <?php } ?>
                    </li>
                <?php }
            } else { ?>
                <li class="mensagem">Nenhum usuário encontrado.</li>
            <?php } ?>
        </ul>

        <?php if ($permissao_usuario_add) { ?>
            <a href="cadastrar.php" class="botao_add">Adicionar novo</a>
        <?php } ?>

        <footer>
            <div class="texto">© 2023 - Todos os direitos reservados</div>
        </footer>
    </div>
</body>

</html>
