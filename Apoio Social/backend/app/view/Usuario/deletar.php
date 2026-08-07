<?php

require_once "C:/Turma2/xampp/htdocs/ONG/backend/app/database/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/backend/app/controllers/UsuarioController.php";

$UsuarioController = new UsuarioController($pdo);

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $usuario = $UsuarioController->deletar($id);
    header('Location: ../../index.php');
} else {
    header('Location: ../../../index.php');
}
?>