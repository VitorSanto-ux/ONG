<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";


// ========================================
// VERIFICA SE O USUÁRIO ESTÁ LOGADO
// ========================================

if (!isset($_SESSION['usuario'])) {

    header("Location: ../login.php");

    exit;
}


// ========================================
// VERIFICA SE É ADMINISTRADOR
// ========================================

if ($_SESSION['usuario']['tipo'] !== 'administrador') {

    header("Location: ../home.php");

    exit;
}


// ========================================
// CONTROLLER
// ========================================

$doacaoController = new DoacaoController($pdo);

$mensagem = '';


// ========================================
// CADASTRO
// ========================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $nomeDoacao = trim($_POST['nome_doacao'] ?? '');

    $descricao = trim($_POST['descricao'] ?? '');

    $precoArrecadar = $_POST['preco_aarrecadar'] ?? '';

    $prazo = $_POST['prazo'] ?? '';

    $campanhaId = $_POST['campanha_id'] ?? '';

    $localizacao = trim($_POST['localizacao'] ?? '');


    $usuarioId = $_SESSION['usuario']['id'];


    // ====================================
    // CRIA A DOAÇÃO
    // ====================================

    $criou = $doacaoController->criar(

        $usuarioId,

        $nomeDoacao,

        $descricao,

        $precoArrecadar,

        $prazo,

        $localizacao

    );


    if ($criou) {

        $mensagem = "Doação criada com sucesso!";


        header("Location: minhas-campanhas.php");

        exit;


    } else {

        $mensagem = "Erro ao criar doação.";

    }

}

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="../../../css/criar-doacao.css">
    <title>

        Criar Doação - Apoio Social

    </title>


    <!-- FONT AWESOME -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >
</head>


<body>


<div class="page">


    <div class="form-box">


        <!-- ========================================
             LOGO
        ======================================== -->

        <div class="logo">


            <div class="logo-icon">

                <i class="fa-solid fa-hand-holding-heart"></i>

            </div>


            <div class="logo-text">

                <span class="logo-name">

                    Apoio Social

                </span>

            </div>


        </div>


        <br>


        <!-- ========================================
             MENSAGEM
        ======================================== -->

        <?php if ($mensagem): ?>


            <div class="mensagem">

                <?= htmlspecialchars($mensagem) ?>

            </div>


        <?php endif; ?>



        <!-- ========================================
             FORMULÁRIO
        ======================================== -->

        <form method="POST">


            <!-- NOME -->

            <div class="form-group">


                <label>

                    Nome da doação

                </label>


                <input
                    type="text"
                    name="nome_doacao"
                    placeholder="Digite o nome da doação"
                    required
                >


            </div>



            <!-- DESCRIÇÃO -->

            <div class="form-group">


                <label>

                    Descrição

                </label>


                <textarea
                    name="descricao"
                    maxlength="3000"
                    placeholder="Descreva detalhadamente a doação..."
                    required
                ></textarea>


            </div>



            <!-- PREÇO -->

            <div class="form-group">


                <label>

                    Valor a arrecadar

                </label>


                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="preco_aarrecadar"
                    placeholder="0,00"
                    required
                >


            </div>



            <!-- PRAZO -->

            <div class="form-group">


                <label>

                    Prazo para arrecadação (dias)

                </label>


                <input
                    type="number"
                    min="1"
                    name="prazo"
                    placeholder="Ex: 30"
                    required
                >


            </div>



            <!-- CAMPANHA -->

            <div class="form-group">


                <label>

                    Campanha

                </label>


                <select
                    name="campanha_id"
                    required
                >


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


            </div>



            <!-- LOCALIZAÇÃO -->

            <div class="form-group">


                <label>

                    Localização

                </label>


                <input
                    type="text"
                    name="localizacao"
                    placeholder="Informe a localização"
                >


            </div>



            <!-- BOTÃO -->

            <button
                type="submit"
                class="btn-submit"
            >

                <i class="fa-solid fa-plus"></i>

                Publicar doação

            </button>


        </form>


    </div>


</div>


</body>

</html>