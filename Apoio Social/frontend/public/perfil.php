<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/UsuarioController.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/services/PerfilService.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/Controller.php";


$participacaoController = new ParticipacaoController($pdo);

if( !isset($_SESSION['usuario']) ){

header("Location: login.php");
exit;
}

$usuarioId = $_SESSION['usuario']['id'];

$usuarioController = new UsuarioController($pdo);
$doacaoController = new DoacaoController($pdo);
$perfilService = new PerfilService($usuarioController);

$usuario = $usuarioController->buscarUsuario($usuarioId);

$doacao = $usuarioController->listarDoacaoDoPerfil(
    $usuarioId,
    $usuario['tipo'],
    $doacaoController,
    $participacaoController
);

$mensagem = "";

if ($usuario['tipo'] === 'administrador') {

    $doacoes = $doacaoController->listarPorAdministrador($usuarioId);
}

if (isset($_POST['alterar_senha'])) {

    $mensagem = $perfilService->alterarSenha(

        $usuarioId,

        trim($_POST['email']),

        trim($_POST['nova_senha']),

        trim($_POST['confirmar_senha'])
    );
}

if (isset($_POST['alterar_foto'])) {

    $mensagem = $perfilService->alterarFoto(

        $usuarioId,

        $_FILES['foto']
    );

    $usuario = $usuarioController->buscarUsuario($usuarioId);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <a href="home.php" class="btn-back">

        <svg
            class="icon-back"
            viewBox="0 0 24 24"
            fill="none">

            <path
                d="M15 18l-6-6 6-6"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round" />

        </svg>

    </a>

    <div class="container">
        
        <div class="banner"></div>

        <div class="profile-bar">
            <div class="profile-left">
                <div class="avatar-wrap">
                    <img 
                        class="avatar"
                        src="<?= !empty($usuario['foto']) ? $usuario['foto'] : '' ?>"
                        alt="Foto de perfil">

                    <form
                        method="POST"
                        enctype="multipart/form-data"
                        class="foto-form">

                        <label
                            for="foto"
                            class="camera-btn">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="none"
                                viewBox="0 0 24 24">

                                <path
                                    d="M4 7h3l2-2h6l2 2h3v11H4V7z"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" />

                                <circle
                                    cx="12"
                                    cy="13"
                                    r="3"
                                    stroke="currentColor"
                                    stroke-width="2" />

                            </svg>

                        </label>

                        <input
                            type="file"
                            name="foto"
                            id="foto"
                            accept="image/*"
                            onchange="this.form.submit()"
                            hidden>

                        <input
                            type="hidden"
                            name="alterar_foto"
                            value="1">

                    </form>
                </div>

                <div class="profile-info">

                    <div class="name">

                        <?= htmlspecialchars($usuario['nome']) ?>


                    </div>

                    <div class="email">

                        <?= htmlspecialchars($usuario['email']) ?>

                    </div>

                    <div class="tags">

                        <span class="badge badge-tipo">

                            <?= htmlspecialchars($usuario['tipo']) ?>

                        </span>

                    </div>
                </div>
            </div>

            <div class="profile-actions">

                <?php if ($usuario['tipo'] === 'administrador'): ?>

                    <a
                        href="Administrador/doacoes/minhas-campanhas.php"
                        class="btn-doacoes">

                        Gerenciar Campanhas

                    </a>

                    <?php else: ?>

                    <a
                        href="../public/Voluntário/participar-doacao.php"
                        class="btn-doacoes">

                        Minhas Doações
                    </a>

                <?php endif; ?>

                <a href="logout.php" class="btn-logout">
                <1 class="fa-solid fa-right-from-bracket"></i>
                    Sair    
                </div>
            </div>

            <div class="grid">

                <div class="card card-perfil">

                    <div class="card-esquerdo">
                        <div class="card-title">
                            <h2>Informação da Conta</h2>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>

                            <div class="info-label">
                                Email
                            </div>

                             <div class="info-val">
                                <?= htmlspecialchars($usuario['email']) ?>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>

                            <div>
                                <div class="info-label">
                                    Telefone
                                </div>

                                <div class="info-val">
                                    <?= htmlspecialchars($usuario['telefone']) ?>
                                </div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fa-solid fa-user-tag"></i>
                            </div>

                            <div>
                                <div class="info-label">
                                    Tipo de conta
                                </div>

                                <div class="info-val">
                                    <?= htmlspecialchars($usuario['tipo']) ?>
                                </div>
                            </div>
                        </div>
                
                    </div>

                    <div class="card-direito">

                        <div class="card-titlr">
                            <h2>Alterar Senha</h2>
                        </div>

                        <?php if (!empty($mensagem)): ?>
                            <div class="msg-alert">
                                <?= $mensagem ?>
                            </div>
                        <?php endif; ?>

                        <form
                            method="POST"
                            class="form-senha">

                            <div class="input-group">
                                <label>Email</label>

                                <input
                                    type="email"
                                    name="email"
                                    placeholder="Digite seu email"
                                    required>
                            </div>

                            <div class="input-group">
                                <label>Nova Senha</label>

                                <input
                                    type="password"
                                    name="nova_senha"
                                    placeholder="Digite a nova senha"
                                    required>
                            </div>

                            <div class="input-group">
                                <label>Confirmar Senha</label>

                                <input
                                    type="password"
                                    name="confirmar_senha"
                                    placeholder="Confirme sua nova senha"
                                    required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>