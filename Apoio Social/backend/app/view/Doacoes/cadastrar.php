<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}

$DoacaoController = new DoacaoController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuarioId = $_SESSION['usuario']['id'];

    $nomeDoacao = trim($_POST['nome_doacao']);
    $descricao = trim($_POST['descricao']);
    $preco = $_POST['preco_aarrecadar'];
    $Idcampaha = $_POST['campanha_id'];
    $prazoArrecadar = $_POST['prazo_aarrecadar'];
    $localizacao = trim($_POST['localizacao']);

    $resultado = $DoacaoController->criar(
        $usuarioId,
        $Idcampaha,
        $nomeDoacao,
        $descricao,
        $preco,
        $prazoArrecadar,
        $localizacao
    );

    if ($resultado) {
        header("Location: ../../../index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Doação</title>

</head>

<body>

    <form method="POST">

        <label for="nome_doacao">
            Nome da Doação:
        </label>

        <input
            type="text"
            name="nome_doacao"
            id="nome_doacao"
            required>

        <br>


        <label for="descricao">
            Descrição da Doação:
        </label>

        <textarea
            name="descricao"
            id="descricao"
            required></textarea>

        <br>


        <label for="preco_aarrecadar">
            Preço da Doação:
        </label>

        <input
            type="number"
            name="preco_aarrecadar"
            id="preco_aarrecadar"
            step="0.01"
            min="0"
            required>

        <br>


        <label for="campanha_id">
            Campanha da Doação:
        </label>

        <select
            name="campanha_id"
            id="campanha_id"
            required>

            <option value="">
                Selecione uma campanha
            </option>

            <option value="1">
                Campanha do Agasalho
            </option>

            <option value="2">
                Natal Solidário
            </option>

            <option value="3">
                Mochila do Futuro
            </option>

            <option value="4">
                Prato Cheio
            </option>

            <option value="5">
                Doe um Sorriso
            </option>

            <option value="6">
                Mãos que Ajudam
            </option>

            <option value="7">
                Esperança Verde
            </option>

            <option value="8">
                Saúde para Todos
            </option>

            <option value="9">
                Conectando Vidas
            </option>

            <option value="10">
                Emprego e Dignidade
            </option>

            <option value="11">
                Doe Sangue, Salve Vidas
            </option>

            <option value="12">
                Cesta do Bem
            </option>

            <option value="13">
                Amigo Idoso
            </option>

            <option value="14">
                Volta às Aulas Solidária
            </option>

            <option value="15">
                Páscoa Solidária
            </option>

            <option value="16">
                Inverno Sem Frio
            </option>

            <option value="17">
                Outubro Rosa e Novembro Azul
            </option>

            <option value="18">
                Doe Tempo
            </option>

            <option value="19">
                Dia das Crianças Feliz
            </option>

            <option value="20">
                Juntos Contra a Fome
            </option>

        </select>

        <br>


        <label for="prazo_aarrecadar">
            Prazo da Doação:
        </label>

        <input
            type="number"
            name="prazo_aarrecadar"
            id="prazo_aarrecadar"
            min="1"
            required>

        <br>


        <label for="localizacao">
            Localização da Doação:
        </label>

        <input
            type="text"
            name="localizacao"
            id="localizacao"
            required>

        <br>


        <input
            type="submit"
            value="Cadastrar">

    </form>

</body>

</html>