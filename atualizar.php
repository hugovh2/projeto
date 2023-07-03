<?php
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

// Verifica se os dados do formulário foram enviados via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $status = $_POST['status'];
    $permissao = implode(',', $_POST['permissao']);

    // Remove os caracteres não numéricos do CPF
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Atualiza os dados do usuário no banco de dados
    $sql = "UPDATE usuario SET nome = '$nome', cpf = '$cpf', email = '$email', senha = '$senha', status = '$status', permissao = '$permissao' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Dados atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar os dados: " . $conn->error;
    }
}

$conn->close();
?>
