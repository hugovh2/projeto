<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $status = $_POST['status'];
    $permissoes = implode(',', $_POST['permissao']); // Converte o array de permissões em uma string separada por vírgula

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

    // Insere os dados na tabela usuario
    $uuid = uniqid(); // Gera um UUID único para o usuário
    $dataCriacao = date("Y-m-d H:i:s");
    $dataAtualizacao = date("Y-m-d H:i:s");

    $sql = "INSERT INTO usuario (uuid, nome, cpf, email, senha, permissao, data_criacao, data_atualizacao, status) VALUES ('$uuid', '$nome', '$cpf', '$email', '$senha', '$permissoes', '$dataCriacao', '$dataAtualizacao', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o usuário: " . $conn->error;
    }

    $conn->close();
}
?>


<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redireciona o usuário de volta para a página de login
    header("Location: login.php");
    exit();
}

// Verifica as permissões do usuário logado
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
                <div class="editar"></div>
                <div class="deletar"></div>
            </li>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Exibe os dados do usuário
                    echo '<li class="dado">';
                    echo '<div class="texto nome">' . $row['nome'] . '</div>';
                    
                    // Formata o CPF com pontos e traço
                    $cpfFormatado = substr($row['cpf'], 0, 3) . '.' . substr($row['cpf'], 3, 3) . '.' . substr($row['cpf'], 6, 3) . '-' . substr($row['cpf'], 9);
                    echo '<div class="texto cpf">' . $cpfFormatado . '</div>';
                    
                    echo '<div class="texto email">' . $row['email'] . '</div>';
                    echo '<div class="texto data">' . $row['data_criacao'] . '</div>';
                    echo '<div class="texto status">' . ($row['status'] == 1 ? 'Ativo' : 'Inativo') . '</div>';
                    echo '<div class="editar"><a href="editar.php?id=' . $row['id'] . '"><img src="images/editar.svg"></a></div>';
                    echo '<div class="deletar"><a href="deletar.php?id=' . $row['id'] . '"><img src="images/deletar.svg"></a></div>';
                    echo '</li>';
                }
            } else {
                if ($result->num_rows === 0 && !empty($pesquisa)) {
                    echo '<li class="mensagem">Nenhum resultado encontrado para a pesquisa: ' . $pesquisa . '</li>';
                } else {
                    echo '<li class="mensagem">Nenhum usuário cadastrado.</li>';
                }
            }
            ?>

        </ul>
        <div class="pagina">
            <p class="resultado"><?php echo $result->num_rows; ?> resultado(s)</p>
            <?php
            $termoPesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
            ?>
            <a href="?pesquisa=<?php echo $termoPesquisa; ?>&pagina=anterior">Anterior</a>
            <a href="?pesquisa=<?php echo $termoPesquisa; ?>&pagina=proxima">Próxima</a>
        </div>
        <a href="form.php" class="botao_add">Adicionar novo</a>
    </div>
</body>

</html>


<?php
$conn->close();
?>