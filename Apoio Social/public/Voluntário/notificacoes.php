<?php

session_start();

if (!isset($_SESSION['usuario'])) {

    header("Location: ../login.php");
    exit;
}

$doadorId = $_SESSION['usuario']['id'];

$sql = "SELECT
            c.*,
            s.nome_doacao,
            u.nome AS administrador
        FROM participacoes c
        INNER JOIN doacoes s
            ON s.id = c.doacao_id
        INNER JOIN usuarios u
            ON u.id = s.usuario_id
        WHERE c.doador_id = ?
        AND c.status != 'pendente'
        ORDER BY c.id DESC";
$stmt = $pdo->prepare($sql);

$stmt->execute([$doadorId]);

$doacoesConfirmadas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Participações</title>
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

    <?php if (count($doacoesConfirmadas) > 0): ?>

        <div class="notificacoes-grid">

            <?php foreach ($doacoesConfirmadas as $doacaoConfirmada): ?>

                <div class="card">

                    <a
                        href="deletar-notificacao.php?id=<?= $doacaoConfirmada['id'] ?>"
                        class="btn-fechar">
                        <i class="fa-solid fa-xmark"></i>
                    </a>

                    <h3>
                        <?= htmlspecialchars($doacaoConfirmada['nome_doacao']) ?>
                    </h3>

                    <p>
                        Administrador:
                        <strong>
                            <?= htmlspecialchars($doacaoConfirmada['administrador']) ?>
                        </strong>
                    </p>

                    <p>
                        <?= htmlspecialchars($doacaoConfirmada['mensagem']) ?>
                    </p>

                    <?php if ($doacaoConfirmada['status'] === 'recusado'): ?>

                        <div class="alerta-recusa">

                            <i class="fa-solid fa-triangle-exclamation"></i>

                            <div>

                                <strong style="color: red;">
                                    Doação recusada
                                </strong>

                                <p>
                                    O valor doado foi devolvido para sua conta.
                                </p>

                            </div>

                        </div>

                    <?php endif; ?>

                    <span class="status <?= $doacaoConfirmada['status'] ?>">
                        <?= $doacaoConfirmada['status'] ?>
                    </span>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="vazio">

            <i class="fa-solid fa-bell-slash"></i>

            <h2>
                Nenhuma notificação
            </h2>

            <p>
                Você ainda não realizou nenhuma doação.
            </p>

        </div>

    <?php endif; ?>

</body>

</html>