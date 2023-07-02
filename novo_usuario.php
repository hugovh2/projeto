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
        $conn->close();
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao cadastrar o usuário: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <div id="site">
        <header>
            <h1 class="total">Cadastrar novo usuário</h1>
        </header>
        <form action="cadastrar.php" class="cadastro" method="POST">
            <div class="input">
                <label for="input_nome">Nome:</label>
                <input type="text" id="input_nome" name="nome" placeholder="Digite um nome">
            </div>
            <div class="input">
                <label for="input_cpf">CPF:</label>
                <input type="text" id="input_cpf" name="cpf" placeholder="Digite um CPF">
            </div>
            <div class="input">
                <label for="input_email">E-mail:</label>
                <input type="text" id="input_email" name="email" placeholder="Digite um e-mail">
            </div>
            <div class="input">
                <label for="input_senha">Senha:</label>
                <input type="password" id="input_senha" name="senha" placeholder="Digite uma senha">
            </div>

            <div class="select">
                <label for="input_status">Status</label>
                <select name="status" id="input_status">
                    <option value="">Escolha uma opção</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
                <div class="seta">
                    <img src="images/seta.svg" alt="">
                </div>
            </div>

            <h2>Permissão</h2>
            <div class="permissao">
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_login" name="permissao[]" value="login">
                    <div class="check">
                        <img src="images/check.svg">
                    </div>
                    <label for="input_permissao_login">Login</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_usuario_add" name="permissao[]" value="usuario_add">
                    <div class="check">
                        <img src="images/check.svg">
                    </div>
                    <label for="input_permissao_usuario_add">Add usuário</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_usuario_editar" name="permissao[]" value="usuario_editar">
                    <div class="check">
                        <img src="images/check.svg">
                    </div>
                    <label for="input_permissao_usuario_editar">Editar usuário</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_usuario_deletar" name="permissao[]" value="usuario_deletar">
                    <div class="check">
                        <img src="images/check.svg">
                    </div>
                    <label for="input_permissao_usuario_deletar">Deletar usuário</label>
                </div>
            </div>
            <button>SALVAR</button>
        </form>
    </div>
</body>

</html>
