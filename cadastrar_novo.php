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
        header("Location: login.php");
        exit;
    } else {
        echo "Erro ao cadastrar o usuário: " . $conn->error;
    }

    $conn->close();
}
?>
