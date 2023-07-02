<?php
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Validação dos campos de login e senha
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    if (empty($login) || empty($senha)) {
        echo "Por favor, preencha todos os campos.";
        exit;
    }

    // Consulta o usuário pelo CPF
    $cpf = mysqli_real_escape_string($conn, $login);
    $sql = "SELECT * FROM usuario WHERE cpf = '$cpf'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifica a senha
        if (password_verify($senha, $row['senha'])) {
            // Autenticação bem-sucedida, inicia a sessão
            $_SESSION['id'] = $row['id'];

            // Redireciona para a página inicial ou página de boas-vindas
            header("Location: index.php");
            exit;
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }

    $conn->close();
}
?>
