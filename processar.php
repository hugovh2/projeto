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
            <a class="voltar" href="index.php"><img src="images/voltar.svg"></a>
            <h1 class="total">Salvar novo usuário</h1>
            <figure></figure>
            <a class="sair" href="login.php">sair</a>
        </header>
        <form action="processar.php" method="POST" class="cadastro">
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
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
                <div class="seta"><img src="images/seta.svg" alt=""></div>
            </div>

            <h2>Permissão</h2>
            <div class="permissao">
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_login" name="permissao[]" value="login">
                    <div class="check"><img src="images/check.svg"></div>
                    <label for="input_permissao_login">Login</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_usuario_add" name="permissao[]" value="usuario_add">
                    <div class="check"><img src="images/check.svg"></div>
                    <label for="input_permissao_usuario_add">Add usuário</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_usuario_editar" name="permissao[]" value="usuario_editar">
                    <div class="check"><img src="images/check.svg"></div>
                    <label for="input_permissao_usuario_editar">Editar usuário</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_usuario_deletar" name="permissao[]" value="usuario_deletar">
                    <div class="check"><img src="images/check.svg"></div>
                    <label for="input_permissao_usuario_deletar">Deletar usuário</label>
                </div>
            </div>

            <button type="submit">SALVAR</button>
        </form>
    </div>
</body>

</html>
