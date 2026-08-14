<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $tipo = $_POST['tipo'];

    $usuarioId = $_SESSION['usuario']['id'];

    $sql = "UPDATE usuarios SET tipo = ? WHERE id = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$tipo, $usuarioId]);


    $sqlUsuario = "SELECT * FROM usuarios WHERE id = ?";

    $stmtUsuario = $pdo->prepare($sqlUsuario);

    $stmtUsuario->execute([$usuarioId]);

    $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);


    $_SESSION['usuario'] = [
        'id' => $usuario['id'],
        'nome' => $usuario['nome'],
        'email' => $usuario['email']
    ];


    unset($_SESSION['usuario_temp']);

    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/escolher-tipo.css">
    <title>Escolher Tipo de Conta</title>
</head>
<body>
    <div class="content">

        <div class="titulo">
            <h1>
                Escolha seu tipo de conta
            </h1>

            <p>
                Defina como deseja usar a plataforma.
            </p>
        </div>

        <div class="container">
            <form
                method="POST"
                action="finalizar-cadastro.php"
            >
                <input
                    type="hidden"
                    name="tipo"
                    value="voluntario"
                >
                
                    <div
                        class="card"
                        onclick="this.closest('form').submit()"
                    >
                        <div class="icon">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>

                        <h2>
                            Voluntário
                        </h2>

                        <p>
                            Se você deseja ajudar pessoas e causas, escolha esta opção.
                        </p>
                    </div>
            </form>

            <form
                method="POST"
                action="finalizar-cadastro.php"
            >
                <input
                    type="hidden"
                    name="tipo"
                    value="administrador"
                >
                
                    <div
                        class="card"
                        onclick="this.closest('form').submit()"
                    >

                        <div class="icon">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>

                        <h2>
                            Administrador
                        </h2>

                        <p>
                            Se você deseja gerenciar a plataforma e seus usuários, escolha esta opção, ou até mesmo se você deseja apenas colocar as campahas de doação e gerenciar os voluntários, escolha esta opção.
                        </p>
                    </div>
            </form>
        </div>
    </div>
</body>
</html>