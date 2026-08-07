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
                <?php foreach ($doacoes as $doacao): ?>
                    <div class="card-doacao">
                        <h3>
                            <?= $doacao['nome_doacao'] ?>
                        </h3>

                        <P class="descricao">
                            <?= $doacao['descricao'] ?>
                        </P>

                        <div class="info">
                            <span>
                                <i class="fa-regular fa-clock"></i>
                                <?= $doacao['prazo'] ?> dia(s)
                            </span>
                        </div>

                        <div class="preco">
                            R$ <?= number_format($doacao['preco_aarrecadar'], 2, ',', '.') ?>
                        </div>
                    </div>

                    <div class="acoes">
                        <button
                            class="btn-editar"
                            onclick="abrirModal(
                                '<?= $doacao['id'] ?>',
                                '<?= $doacao['nome_doacao'] ?>',
                                '<?= $doacao['descricao'] ?>',
                                '<?= $doacao['preco_aarrecadar'] ?>',
                                '<?= $doacao['prazo'] ?>',
                                '<?= $doacao['localizacao'] ?>',
                                '<?= $doacao['campanha_id'] ?>',
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
                        id="edit_id"
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
                        id="edit-preco_aarrecadar"
                        required>
                </div>

                <div class="form-group">
                    <Label>
                        Prazo (dias)
                    </Label>

                    <input
                        type="number"
                        name="prazo"
                        id="edit-prazo"
                        required>
                </div>

                <div class="form-group">
                    <label>
                        Campanhas
                    </label>

                    <select
                        name="campanha_id"
                        id="edit-campanha"
                        required>
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
</body>

</html>
<script src="../../js/minhas-doacoes.js"></script>