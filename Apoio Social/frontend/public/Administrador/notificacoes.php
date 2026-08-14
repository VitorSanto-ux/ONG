<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/ParticipacaoController.php";


// ========================================
// VERIFICA LOGIN
// ========================================

if (!isset($_SESSION['usuario'])) {

    header("Location: ../login.php");

    exit;
}


// ========================================
// CONTROLLER
// ========================================

$participacaoController = new ParticipacaoController($pdo);


// ========================================
// ID DO ADMINISTRADOR
// ========================================

$administradorId = $_SESSION['usuario']['id'];


// ========================================
// AÇÕES
// ========================================

if (isset($_GET['acao'], $_GET['id'])) {


    $id = (int) $_GET['id'];

    $acao = $_GET['acao'];


    // ====================================
    // ACEITAR
    // ====================================

    if ($acao === 'aceitar') {

        $participacaoController->atualizarStatus(
            $id,
            'aceito'
        );
    }


    // ====================================
    // RECUSAR
    // ====================================

    elseif ($acao === 'recusar') {

        $participacaoController->atualizarStatus(
            $id,
            'recusado'
        );
    }


    // ====================================
    // CONCLUIR
    // ====================================

    elseif ($acao === 'concluir') {

        $participacaoController->atualizarStatus(
            $id,
            'concluido'
        );
    }


    header("Location: notificacoes.php");

    exit;
}


// ========================================
// BUSCA PARTICIPAÇÕES
// ========================================

$participacoes =
    $participacaoController->listarParaAdministrador(
        $administradorId
    );

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <link rel="stylesheet" href="../../css/notificacoes.css">
    <title>

        Notificações

    </title>

    <!-- FONT AWESOME -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >

</head>


<body>


<!-- ========================================
     TOPO
======================================== -->

<div class="topo">


    <a
        href="../home.php"
        class="btn-back"
    >

        <i class="fa-solid fa-arrow-left"></i>

    </a>


    <h1>

        <i class="fa-solid fa-bell"></i>

        Notificações

    </h1>


</div>



<!-- ========================================
     NOTIFICAÇÕES
======================================== -->

<?php if (count($participacoes) > 0): ?>


    <div class="notificacoes-grid">


        <?php foreach ($participacoes as $participacao): ?>


            <div class="card-notificacao">


                <!-- ====================================
                     TOPO DO CARD
                ===================================== -->

                <div class="card-topo">


                    <div class="voluntario">


                        <div class="icon-voluntario">


                            <img
                                src="<?= !empty($participacao['foto'])
                                    ? '../../uploads/' . htmlspecialchars($participacao['foto'])
                                    : '../../img/user.jpg'
                                ?>"
                                alt="Voluntário"
                                class="foto-voluntario"
                            >


                        </div>


                        <div class="info-voluntario">


                            <h3>

                                <?= htmlspecialchars(
                                    $participacao['voluntario']
                                ) ?>

                            </h3>


                            <span>

                                Quer ajudar com a doação:

                            </span>


                            <strong>

                                <?= htmlspecialchars(
                                    $participacao['nome_doacao']
                                ) ?>

                            </strong>


                        </div>


                    </div>



                    <!-- STATUS -->

                    <div
                        class="status <?= htmlspecialchars(
                            strtolower($participacao['status'])
                        ) ?>"
                    >

                        <?= htmlspecialchars(
                            $participacao['status']
                        ) ?>

                    </div>


                </div>



                <!-- ====================================
                     MENSAGEM
                ===================================== -->

                <?php if (!empty($participacao['mensagem'])): ?>


                    <p class="mensagem">

                        <?= htmlspecialchars(
                            $participacao['mensagem']
                        ) ?>

                    </p>


                <?php endif; ?>



                <!-- ====================================
                     AÇÕES
                ===================================== -->

                <?php if (
                    strtolower(trim($participacao['status']))
                    === 'pendente'
                ): ?>


                    <div class="acoes">


                        <!-- ACEITAR -->

                        <a
                            href="?acao=aceitar&id=<?= (int)$participacao['id'] ?>"
                            class="btn-acao btn-aceitar"
                        >

                            <i class="fa-solid fa-check"></i>

                            Aceitar

                        </a>



                        <!-- RECUSAR -->

                        <a
                            href="?acao=recusar&id=<?= (int)$participacao['id'] ?>"
                            class="btn-acao btn-recusar"
                            onclick="return confirmarRecusa()"
                        >

                            <i class="fa-solid fa-xmark"></i>

                            Recusar

                        </a>


                    </div>


                <?php endif; ?>



                <!-- ====================================
                     CONCLUIR
                ===================================== -->

                <?php if (
                    strtolower(trim($participacao['status']))
                    === 'aceito'
                ): ?>


                    <div class="acoes">


                        <a
                            href="?acao=concluir&id=<?= (int)$participacao['id'] ?>"
                            class="btn-acao btn-concluir"
                        >

                            <i class="fa-solid fa-circle-check"></i>

                            Concluir doação

                        </a>


                    </div>


                <?php endif; ?>


            </div>


        <?php endforeach; ?>


    </div>


<?php else: ?>


    <!-- ========================================
         SEM NOTIFICAÇÕES
    ======================================== -->

    <div class="vazio">


        <i class="fa-regular fa-bell-slash"></i>


        <h2>

            Nenhuma notificação

        </h2>


        <p>

            Você ainda não recebeu solicitações de doação.

        </p>


    </div>


<?php endif; ?>



<!-- JAVASCRIPT -->

<script src="../js/notificacoes-voluntario.js"></script>


</body>

</html>