<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";

$doacaoController = new DoacaoController($pdo);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id = $_POST['id'];

    $nome_doacao = $_POST['nome_doacao'];

    $descricao = $_POST['descricao'];

    $precoaarrecadar = $_POST['preco_aarrecadar'];

    $prazo = $_POST['prazo'];

    $campanha_id = $_POST['campanha_id'];

    $doacaoController->editar(
        $id,
        $nome_doacao,
        $descricao,
        $precoaarrecadar,
        $prazo,
        $campanha_id
    );

    header("Location: minhas-campanhas.php");
    exit;
}
?>