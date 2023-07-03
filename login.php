<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['login'];
    $senha = $_POST['senha'];

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

    // Remove pontos e traço do CPF
    $cpf = str_replace(array('.', '-'), '', $cpf);

    // Consulta o banco de dados para verificar o usuário e a senha
    $sql = "SELECT * FROM usuario WHERE REPLACE(cpf, '.', '') = '$cpf' AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Autenticação bem-sucedida
        session_start();
        $_SESSION['logged_in'] = true;

        // Redirecionar para a página inicial após o login
        header("Location: index.php");
        exit();
    } else {
        // Credenciais inválidas, exibir mensagem de erro
        $loginError = "CPF ou senha inválidos.";
    }

    $conn->close();
}

// Verifica se existem usuários cadastrados no banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tabela";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) as total FROM usuario";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalUsuarios = $row['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div id="site">
        <figure>
            <img src="images/logo.png" alt="Logo Markt Club">
        </figure>
        <form action="" method="post">
            <legend>FAÇA SEU LOGIN</legend>
            <p>Digite seu CPF no campo abaixo e clique em logar para fazer seu login.</p>

            <div class="input">
                <input type="text" id="input_login" placeholder="CPF" inputmode="numeric" name="login">
                <label for="input_login">CPF</label>
            </div>
            <div class="input">
                <input type="password" id="input_senha" placeholder="Senha" inputmode="numeric" name="senha">
                <label for="input_senha">Senha</label>
            </div>

            <button type="submit">LOGAR</button>

            <?php if (isset($loginError)): ?>
                <p class="error"><?php echo $loginError; ?></p>
            <?php endif; ?>

            <p class="cadastro-link">Ainda não possui uma conta? <a href="novo_usuario.php">Cadastre-se</a></p>
        </form>
    </div>
</body>

</html>
