<?php

require_once "C:/Turma2/xampp/htdocs/ONG/backend/app/controllers/DoacaoController.php";
require_once "C:/Turma2/xampp/htdocs/ONG/backend/app/database/database.php";

$DoacaoController = new DoacaoController($pdo);

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $DoacaoController->deletar($id);
    header('Location: ../../index.php');
} else {
    header('Location: ../../../index.php');
}
?>