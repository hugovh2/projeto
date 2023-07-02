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

// Verifica se foi fornecido um ID válido na URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta os dados do usuário pelo ID
    $sql = "SELECT * FROM usuario WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Exibe o formulário de edição com os dados do usuário
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar Usuário</title>

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="css/form.css">
        </head>

        <body>
            <div id="site">
                <header>
                    <a class="voltar" href="index.php"><img src="images/voltar.svg"></a>
                    <h1 class="total">Editar usuário</h1>
                    <figure></figure>
                    <a class="sair" href="login.php">sair</a>
                </header>
                <form action="atualizar.php" class="cadastro" method="POST">
                    <div class="input">
                        <label for="input_nome">Nome:</label>
                        <input type="text" id="input_nome" name="nome" placeholder="Digite um nome" value="<?php echo $row['nome']; ?>">
                    </div>
                    <div class="input">
                        <label for="input_cpf">CPF:</label>
                        <input type="text" id="input_cpf" name="cpf" placeholder="Digite um CPF" value="<?php echo $row['cpf']; ?>">
                    </div>
                    <div class="input">
                        <label for="input_email">E-mail:</label>
                        <input type="text" id="input_email" name="email" placeholder="Digite um e-mail" value="<?php echo $row['email']; ?>">
                    </div>
                    <div class="input">
                        <label for="input_senha">Senha:</label>
                        <input type="password" id="input_senha" name="senha" placeholder="Digite uma senha" value="<?php echo $row['senha']; ?>">
                    </div>

                    <div class="select">
                        <label for="input_status">Status</label>
                        <select name="status" id="input_status">
                            <option value="">Escolha uma opção</option>
                            <option value="1" <?php echo ($row['status'] == 1) ? 'selected' : ''; ?>>Ativo</option>
                            <option value="0" <?php echo ($row['status'] == 0) ? 'selected' : ''; ?>>Inativo</option>
                        </select>
                        <div class="seta"><img src="images/seta.svg" alt=""></div>
                    </div>


                    <h2>Permissão</h2>
                    <div class="permissao">
                        <div class="checkbox">
                            <input type="checkbox" id="input_permissao_login" name="permissao[]" value="login" <?php echo (in_array('login', explode(',', $row['permissao']))) ? 'checked' : ''; ?>>
                            <div class="check"><img src="images/check.svg"></div>
                            <label for="input_permissao_login">Login</label>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" id="input_permissao_usuario_add" name="permissao[]" value="usuario_add" <?php echo (in_array('usuario_add', explode(',', $row['permissao']))) ? 'checked' : ''; ?>>
                            <div class="check"><img src="images/check.svg"></div>
                            <label for="input_permissao_usuario_add">Add usuário</label>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" id="input_permissao_usuario_editar" name="permissao[]" value="usuario_editar" <?php echo (in_array('usuario_editar', explode(',', $row['permissao']))) ? 'checked' : ''; ?>>
                            <div class="check"><img src="images/check.svg"></div>
                            <label for="input_permissao_usuario_editar">Editar usuário</label>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" id="input_permissao_usuario_deletar" name="permissao[]" value="usuario_deletar" <?php echo (in_array('usuario_deletar', explode(',', $row['permissao']))) ? 'checked' : ''; ?>>
                            <div class="check"><img src="images/check.svg"></div>
                            <label for="input_permissao_usuario_deletar">Deletar usuário</label>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button>SALVAR</button>
                </form>
            </div>
        </body>

        </html>
        <?php
    } else {
        echo "Usuário não encontrado.";
    }
} else {
    echo "ID de usuário inválido.";
}

$conn->close();
?>
