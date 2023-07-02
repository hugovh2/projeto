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

// Função para deletar um usuário
function deletarUsuario($id) {
    global $conn;

    // Deleta o usuário do banco de dados
    $sql = "DELETE FROM usuario WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Usuário deletado com sucesso.";
    } else {
        echo "Erro ao deletar o usuário: " . $conn->error;
    }
}

// Verifica se o ID do usuário foi fornecido para deletar
if (isset($_GET['id'])) {
    $idDeletar = $_GET['id'];
    deletarUsuario($idDeletar);
}

$conn->close();
?>
