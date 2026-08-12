<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";

if (!isset($_SESSION['usuario'])) {

    header("Location: ../login.php");
    exit;
}

if ($_SESSION['usuario']['tipo'] !== 'administrador') {

    header("Location: ../home.php");
    exit;
}

$doacaoController = new DoacaoController($pdo);

$administradorId = $_SESSION['usuario']['id'];

$doacoes = $doacaoController->listarPorAdministrador($administradorId);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Doações</title>

    <style>
        #modalEditar {
            display: none;
        }
    </style>
</head>

<body>
    <div class="topo">
        <a href="../../perfil.php" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <h1>
            Minhas Doações
        </h1>

        <a href="criar-doacao.php" class="btn-criar">
            + Criar doação
        </a>
    </div>

    <section class="doacoes">
        <?php if (empty($doacoes)): ?>
            <div class="vazio">
                <i class="fa-solid fa-briefcase"></i>

                <h2>
                    Nenhuma doação criada
                </h2>

                <P>
                    Crie sua primeira doação para começar a receber os seus voluntários
                </P>
            </div>
        <?php else: ?>
            <div class="doacoes-grid">
                <?php  foreach ($doacoes as $doacao): ?>
                    <div class="card-doacao">
                        <h3>
                            <?= $doacao['campanha'] ?>
                        </h3>

                        <P class="descricao">
                            <?= $doacao['descricao'] ?>
                        </P>

                        <div class="info">
                            <span>
                                <i class="fa-regular fa-clock"></i>
                                <?= $doacao['prazo_aarrecadar'] ?> dia(s)
                            </span>
                        </div>

                        <div class="preco">
                            R$ <?= number_format($doacao['preco'], 2, ',', '.') ?>
                        </div>
                    </div>

                    <div class="acoes">
                        <button
                            class="btn-editar"
                            onclick="abrirModal(
                                '<?= $doacao['id']; ?>',
                                '<?= $doacao['campanha']; ?>',
                                '<?= $doacao['descricao']; ?>',
                                '<?= $doacao['preco']; ?>',
                                '<?= $doacao['prazo_aarrecadar']; ?>',
                                '<?= $doacao['localizacao']; ?>',
                                '<?= $doacao['id_campanha']; ?>'
                            )">
                            Editar
                        </button>

                        <a href="deletar-doacao.php?id=<?= $doacao['id'] ?>">
                            Excluir
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <div class="modal" id="modalEditar">
        <div class="modal-content">
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

            <form
                method="POST"
                action="editar-doacao.php">

                <input
                    type="hidden"
                    name="id"
                    id="edit-id">

                <div class="form-group">
                    <label>
                        Nome da doação
                    </label>

                    <input
                        type="text"
                        name="nome_doacao"
                        id="edit-nome"
                        required>
                </div>

                <div class="form-group">

                    <label>
                        Descrição
                    </label>

                    <textarea
                        name="descricao"
                        id="edit-descricao"
                        required>
                        </textarea>

                </div>

                <div class="form-group">
                    <labe>
                        Preço à arrecadar
                    </labe>

                    <input
                        type="number"
                        step="0.01"
                        name="preco_aarrecadar"
                        id="edit-preco"
                        required>
                </div>

                <div class="form-group">
                    <Label>
                        Prazo (dias)
                    </Label>

                    <input
                        type="number"
                        name="prazo"
                        id="edit-prazo_arrecadar"
                        required>
                </div>


                <div class="form-group">
                    <label>
                        Localização
                    </label>

                    <input
                        type="text"
                        name="localizacao"
                        id="edit-localizacao">
                </div>

                <button
                    type="submit"
                    class="btn-salvar">

                    Salvar Alterações
                </button>
            </form>
        </div>
    </div>
    <script src="../../js/minhas-doacoes.js"></script>
</body>

</html>