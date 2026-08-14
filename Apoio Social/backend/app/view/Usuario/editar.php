<?php

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/UsuarioController.php";

$UsuarioController = new UsuarioController($pdo);

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $usuario = $UsuarioController->buscarUsuario($id);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Usuário</title>

</head>

<body>

    <form method="post">

        <label for="nome">Nome:</label>
        <input
            type="text"
            name="nome"
            value="<?= $usuario['nome']; ?>"
            required
        ><br>

        <label for="email">Email:</label>
        <input
            type="email"
            name="email"
            value="<?= $usuario['email']; ?>"
            required
        ><br>

        <label for="senha">Senha:</label>
        <input
            type="password"
            name="senha"
            value="<?= $usuario['senha']; ?>"
            required
        ><br>

        <label for="telefone">Telefone:</label>
        <input
            type="text"
            name="telefone"
            value="<?= $usuario['telefone']; ?>"
            required
        ><br>

        <label for="tipo">Tipo:</label>
        <input
            type="text"
            name="tipo"
            value="<?= $usuario['tipo']; ?>"
            required
        ><br>

        <input type="submit" value="Atualizar">

    </form>

</body>

</html>

<?php

} else {

    header('Location: listar.php');
    exit;

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $tipo = $_POST['tipo'];

    $UsuarioController->editar(
        $nome,
        $email,
        $senha,
        $telefone,
        $id
    );

    header('Location: ../../../index.php');
    exit;
}

?>