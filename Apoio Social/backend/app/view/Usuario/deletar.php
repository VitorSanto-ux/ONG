<?php

require_once "C:/Turma2/xampp/htdocs/catalogo-servicos/backend/app/database/database.php";
require_once "C:/Turma2/xampp/htdocs/catalogo-servicos/backend/app/controllers/UsuarioController.php";

$UsuarioController = new UsuarioController($pdo);

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $usuario = $UsuarioController->deletar($id);

    header('Location: ../../index.php');
    exit;

} else {

    header('Location: ../../../index.php');
    exit;
}

?>