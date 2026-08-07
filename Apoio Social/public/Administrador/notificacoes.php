<?php

session_start();

$doadorController = new DoadorController($pdo);

$administradorId = $_SESSION['usuario']['id'];

if(isset($_GET['acao'], $_GET['id'])){

    $id = $_GET['id'];

    if($_GET['acao'] === 'aceitar'){

        $doadorController->atualizarStatus(
            $id,
            'aceito'
        );
    }elseif($_GET['acao'] === 'recusar'){

        $doadorController->deletar($id);
    }elseif($_GET['acao'] === 'concluir'){

        $doadorController->atualizarStatus(
            $id,
            'concluido'
        );
    }

    header("Location: notificacoes.php");
    exit;
}

$doacoes = $doadorController->listarParaAdministrador($administradorId);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações</title>
</head>
<body>
    <div class="topo">
        <a href="../home.php" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <h1>
            <i class="fa-solid fa-bell"></i>
            Notificações
        </h1>
    </div>


    <?php if (count($doacoes) > 0) : ?>

    <div class="notificacoes-grid">

        <?php foreach ($doacoes as $doacao) : ?>
            <div class="card-notificacao">
                <div class="card-topo">
                    <div class="voluntario">
                        <div class="icon-voluntario">
                            <img
                                src="<?= !empty($voluntario['foto']) ? '../../uploads/' . $voluntario['foto'] : '' ?>"
                                alt="Voluntario"
                                class="foto-voluntario">
                        </div>

                        <div class="info- voluntario">
                            <h3>
                                <?= $doacao['voluntario'] ?>
                            </h3>

                            <span>
                                Quer ajudar com a doação de
                            </span>:
                                <?= $doacao['nome_doacao'] ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="status <?= $doacao['status'] ?>">
                    <?= $doacao['status'] ?>
                </div>
            </div>

            <p class="mensagem">
                <?= $doacao['mensagem'] ?>
            </p>

            <?php if (strtolower(trim($doacao['status'])) === 'pendente') : ?>
                <div class="acoes">
                    <a 
                        href="?acao=aceitar&id=<?= $doacao['id'] ?>"
                        class="btn-acao btn-aceitar">

                        <i class="fa-solid fa-check"></i>
                        Aceitar
                    </a>

                    <a 
                        href="?acao=recusar&id=<?= $doacao['id'] ?>"
                        class="btn-acao btn-recusar">
                        onclick="return confirmarRecusa()">
        

                        <i class="fa-solid fa-xmark"></i>
                        Recusar
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($doacao['status'] === 'aceito') : ?>
                <div class="acoes">
                    <a 
                        href="?acao=concluir&id=<?= $doacao['id'] ?>"
                        class="btn-acao btn-concluir">

                        <i class="fa-solid fa-circle-check"></i>
                        Concluir doação
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
          
    </div>

    <?php else: ?>

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

</body>
</html>
<script src="../js/notificacoes-prestador.js"></script>