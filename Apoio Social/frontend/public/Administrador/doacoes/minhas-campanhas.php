<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";


// ========================================
// VERIFICA LOGIN
// ========================================

if (!isset($_SESSION['usuario'])) {

    header("Location: ../login.php");

    exit;
}


// ========================================
// SOMENTE ADMINISTRADOR
// ========================================

if ($_SESSION['usuario']['tipo'] !== 'administrador') {

    header("Location: ../home.php");

    exit;
}


// ========================================
// CONTROLLER
// ========================================

$doacaoController = new DoacaoController($pdo);

$administradorId = $_SESSION['usuario']['id'];


// ========================================
// LISTA AS DOAÇÕES
// ========================================

$doacoes = $doacaoController->listarPorAdministrador($administradorId);
// var_dump($doacoes);
// die();

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="../../../css/minhas-campanhas.css">
    <title>
        Minhas Doações
    </title>


    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>


<body>

    <div class="auth">
            <a href="/frontend/public/index.php">Início</a>
        </div>


    <!-- ========================================
     TOPO
======================================== -->

    <div class="topo">


        <a
            href="../../perfil.php"
            class="btn-back">

            <i class="fa-solid fa-arrow-left"></i>

        </a>


        <h1>

            Minhas Doações

        </h1>


        <a
            href="criar-doacao.php"
            class="btn-criar">

            <i class="fa-solid fa-plus"></i>

            Criar doação

        </a>


    </div>



    <!-- ========================================
     DOAÇÕES
======================================== -->

    <section class="doacoes">


        <?php if (empty($doacoes)): ?>


            <!-- ====================================
         NENHUMA DOAÇÃO
    ===================================== -->

            <div class="vazio">


                <i class="fa-solid fa-hand-holding-heart"></i>


                <h2>

                    Nenhuma doação criada

                </h2>


                <p>

                    Crie sua primeira doação para
                    começar a receber voluntários.

                </p>


            </div>


        <?php else: ?>


            <!-- ====================================
         GRID
    ===================================== -->

            <div class="doacoes-grid">


                <?php foreach ($doacoes as $doacao): ?>


                    <div class="card-doacao">


                        <!-- NOME -->

                        <h3>

                            <?= htmlspecialchars(
                                $doacao['nome_doacao']
                                    ?? $doacao['campanha']
                                    ?? 'Doação'
                            ) ?>

                        </h3>



                        <!-- DESCRIÇÃO -->

                        <p class="descricao">

                            <?= htmlspecialchars(
                                $doacao['descricao']
                            ) ?>

                        </p>



                        <!-- INFORMAÇÕES -->

                        <div class="info">


                            <span>

                                <i class="fa-regular fa-clock"></i>

                                <?= htmlspecialchars(
                                    $doacao['prazo_aarrecadar']
                                        ?? $doacao['prazo']
                                ) ?>

                                dia(s)

                            </span>


                        </div>



                        <!-- PREÇO -->

                        <div class="preco">

                            R$

                            <?= number_format(
                                $doacao['preco']
                                    ?? $doacao['preco']
                                    ?? 0,
                                2,
                                ',',
                                '.'
                            ) ?>

                        </div>



                        <!-- LOCALIZAÇÃO -->

                        <?php if (!empty($doacao['localizacao'])): ?>

                            <div class="localizacao">

                                <i class="fa-solid fa-location-dot"></i>

                                <?= htmlspecialchars(
                                    $doacao['localizacao']
                                ) ?>

                            </div>

                        <?php endif; ?>



                        <!-- =================================
                     AÇÕES
                ================================== -->

                        <div class="acoes">


                            <button
                                type="button"
                                class="btn-editar"
                                onclick='abrirModal(
                            <?= json_encode($doacao['id']) ?>,
                            <?= json_encode(
                                $doacao['campanha']
                            ) ?>,
                            <?= json_encode(
                                $doacao['descricao'] ?? ''
                            ) ?>,
                            <?= json_encode(
                                $doacao['preco']
                                    ?? $doacao['preco']
                                    ?? ''
                            ) ?>,
                            <?= json_encode(
                                $doacao['prazo_aarrecadar']
                                    ?? $doacao['prazo']
                                    ?? ''
                            ) ?>,
                            <?= json_encode(
                                $doacao['localizacao']
                                    ?? ''
                            ) ?>
                        )
                    >

                        <i class="fa-solid fa-pen"></i>

                        Editar

                    </button>



                    <a
                        href="deletar-doacao.php?id=<?= $doacao['id'] ?>"
                        class="btn-excluir"
                        onclick="return confirm(
                            ' Tem certeza que deseja excluir esta doação?'
                                )">

                                <i class="fa-solid fa-trash"></i>

                                Excluir

                                </a>


                        </div>


                    </div>


                <?php endforeach; ?>


            </div>


        <?php endif; ?>


    </section>



    <!-- ========================================
     MODAL EDITAR
======================================== -->

    <div
        class="modal"
        id="modalEditar">


        <div class="modal-content">


            <!-- CABEÇALHO -->

            <div class="modal-header">


                <h2>

                    Editar Doação

                </h2>


                <span
                    class="fechar"
                    onclick="fecharModal()">

                    &times;

                </span>


            </div>



            <!-- FORMULÁRIO -->

            <form
                method="POST"
                action="editar-doacao.php">


                <!-- ID -->

                <input
                    type="hidden"
                    name="id"
                    id="edit-id">



                <!-- NOME -->

                <div class="form-group">


                    <label for="edit-nome">

                        Nome da doação

                    </label>


                    <input
                        type="text"
                        name="nome_doacao"
                        id="edit-nome"
                        required>


                </div>



                <!-- DESCRIÇÃO -->

                <div class="form-group">


                    <label for="edit-descricao">

                        Descrição

                    </label>


                    <textarea
                        name="descricao"
                        id="edit-descricao"
                        maxlength="3000"
                        required></textarea>


                </div>



                <!-- PREÇO -->

                <div class="form-group">


                    <label for="edit-preco">

                        Valor a arrecadar

                    </label>


                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        name="preco_aarrecadar"
                        id="edit-preco"
                        required>


                </div>



                <!-- PRAZO -->

                <div class="form-group">


                    <label for="edit-prazo">

                        Prazo para arrecadação (dias)

                    </label>


                    <input
                        type="number"
                        min="1"
                        name="prazo"
                        id="edit-prazo"
                        required>


                </div>



                <!-- LOCALIZAÇÃO -->

                <div class="form-group">


                    <label for="edit-localizacao">

                        Localização

                    </label>


                    <input
                        type="text"
                        name="localizacao"
                        id="edit-localizacao">


                </div>



                <!-- BOTÃO -->

                <button
                    type="submit"
                    class="btn-salvar">

                    <i class="fa-solid fa-check"></i>

                    Salvar alterações

                </button>


            </form>


        </div>


    </div>



    <script src="../../js/minhas-doacoes.js"></script>


</body>

</html>