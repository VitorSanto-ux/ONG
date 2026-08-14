<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
</head>

<body>

    <form method="post">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br>

        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" required><br>

        <label for="tipo">Tipo:</label>
        <input type="text" name="tipo" required><br>

        <input type="submit" value="Cadastrar">

    </form>

</body>

</html>

<?php

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/UsuarioController.php";

$usuarioController = new UsuarioController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $tipo = $_POST['tipo'];

    $usuarioController->cadastrar(
        $nome,
        $email,
        $senha,
        $telefone,
        $tipo
    );

    header('Location: ../../../index.php');
    exit;
}

?>