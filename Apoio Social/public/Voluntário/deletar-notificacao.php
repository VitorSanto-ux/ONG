<?php

session_start();

if (!isset($_SESSION['usuario'])) {

    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "
        DELETE FROM participacoes
        WHERE id = ?
        AND doador_id = ?
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $id,
        $_SESSION['usuario']['id']
    ]);
}

header("Location: notificacoes.php");
exit;
?>