<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";


// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {

    header("Location: ../login.php");

    exit;
}


// Verifica se é administrador
if ($_SESSION['usuario']['tipo'] !== 'administrador') {

    header("Location: ../home.php");

    exit;
}


$doacaoController = new DoacaoController($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $id = $_POST['id'] ?? '';

    $nomeDoacao = trim($_POST['nome_doacao'] ?? '');

    $descricao = trim($_POST['descricao'] ?? '');

    $precoArrecadar = $_POST['preco_aarrecadar'] ?? '';

    $prazo = $_POST['prazo'] ?? '';


    // Edita a doação

    $doacaoController->editar(

        $id,

        $nomeDoacao,

        $descricao,

        $precoArrecadar,

        $prazo

    );


    // Volta para minhas campanhas

    header("Location: minhas-campanhas.php");

    exit;
}

?>