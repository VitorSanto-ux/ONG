<?php

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";

$doacaoController = new DoacaoController($pdo);

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $doacaoController->deletar($id);
    header('Location: ../../index.php');
} else {
    header('Location: ../../../index.php');
}
?>