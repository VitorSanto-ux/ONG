<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/CampanhaController.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/ParticipacaoController.php";


$campanhaController = new CampanhaController($pdo);
$campanhas = $campanhaController->listar();
// var_dump($campanhas);
// die();


$doacaoController = new DoacaoController($pdo);

$q = $_GET['q'] ?? '';
$campanhaId = $_GET['campanha_id'] ?? null;

$doacoes = $doacaoController->buscarFiltrados($q, $campanhaId);

$notificacoes = 0;

if (!empty($_SESSION['usuario'])) {

    $participacaoController = new ParticipacaoController($pdo);

    if ($_SESSION['usuario']['tipo'] == 'administrador') {
        $notificacoes = $participacaoController->contarPendentesAdministrador($_SESSION['usuario']['id']);
    } else {
        $notificacoes = $participacaoController->contarPendentesDoador($_SESSION['usuario']['id']);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Campanhas</title>
</head>

<body>
    <header>
        <div class="logo">
            <div class="logo-icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
            </div>
            <div class="logo-text">
                <span class="logo-name">Apoio Social</span>
            </div>
        </div>

        <nav>
            <?php

            $linkNotificacoes = "#";

            if (!empty($_SESSION['usuario'])) {

                if ($_SESSION['usuario']['tipo'] === 'administrador') {
                    $linkNotificacoes = "Administrador/notificacoes.php";
                } else {
                    $linkNotificacoes = "Voluntario/notificacoes.php";
                }
            }
            ?>

            <form class="search-box" method="GET" action="home.php">
                <input type="text" id="searchInput" name="q" placeholder="Pesquisar campanhas" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">

                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass" style="color: #111827;"></i>
                </button>

                <?php if (!empty($_SESSION['usuario'])): ?>


                    <a href="<?= $linkNotificacao ?>" class="icon-user notificacao-icon">
                        <i class="fa-solid fa-bell"></i>

                        <?php if ($notificacoes > 0): ?>

                            <span class="badge-notificacao">
                                <?= $notificacoes ?>
                            </span>
                        <?php endif; ?>

                    </a>
                <?php endif; ?>
            </form>

            <?php if (!empty($_SESSION['usuario'])): ?>
                <a href="perfil.php" class="icon-user">
                    <i class="fa-solid fa-user"></i>
                </a>

            <?php else: ?>
                <a href="login.php">Entrar</a>
                <a href="cadastrar.php">Cadastrar</a>
            <?php endif; ?>
        </nav>
    </header>

    <section class="welcome-section">

        <div class="welcome-text">

            <h1>
                Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']['tipo'] ?? 'Visitante') ?>
            </h1>

            <p>
                <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['tipo'] === 'administrador'): ?>
                    Gerencie campanhas, voluntários e doações para transformar vidas através da solidariedade.
                <?php else: ?>
                    Explore campanhas, faça doações e participe de ações voluntárias para contribuir com a nossa missão de transformar vidas através da solidariedade.
                <?php endif; ?>
            </p>
        </div>

        <div class="recommendation-card">
            <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['tipo'] === 'administrador'): ?>
                <h3>
                    Você é um administrador.
                </h3>

                <p>
                    Publique campanhas, gerencie doações e voluntários, e acompanhe o impacto positivo que estamos gerando na sociedade.
                </p>

                <a href="administrador/doacoes/minhas-campanhas.php" class="btn-recomendacao">Gerenciar Campanhas</a>
            <?php else: ?>
                <h3>
                    <i class="fa-solid fa-briefcase"></i>
                    Você é um voluntário.
                </h3>

                <p>
                    Participe de ações voluntárias, faça doações e ajude a construir um mundo mais justo e solidário.
                </p>

                <a href="#doacoes" class="btn-recomendacao">
                    Explorar Campanhas
                </a>
            <?php endif; ?>
        </div>
    </section>

    <section class="cmpanhas-menu">
        <div class="campanhas-topo">
            <button class="btn-campanhas" onclick="toggleCampanhas()">
                Explorar Campanhas
                <i class="fa-solid fa-chevron-down" id="icon-main"></i>
            </button>
        </div>

        <div class="campanhas-dropdown" id="campanhasDropdown">

            <a href="home.php" class="campanha-item">
                todas as campanhas
            </a>

            <?php foreach ($campanhas as $cam): ?>

                <a href="home.php?campanha=<?= $cam['id_campanha'] ?>"
                    class="categoria-item">
                    <br>
                    <?= htmlspecialchars($cam['nome']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="doacoes campanhas-menu" id="doacoes">

        <div class="doacoes-grid">
            <?php foreach ($doacoes as $doacao): ?>

                <div class="card-doacao" data-nome="<?= strtolower($doacao['nome_doacao']) ?>" data-administrador="<?= strtolower($doacao['administrador']) ?>" data-descricao="<?= strtolower($doacao['descricao']) ?>">

                    <div class="top-card">

                        <div class="perfil-area">

                            <img src="<?= !empty($doacao['foto']) ? $doacao['foto'] : '' ?>"
                                alt="Administrador"
                                class="foto-administrador">

                            <div class="perfil-info">

                                <span class="nome-administrador">
                                    <?= $doacao['administrador'] ?>
                                </span>

                                <h3>
                                    <?= $doacao['nome_doacao'] ?>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-content">

                        <p class="descricao">
                            <?= mb_strimwidth($doacao['descricao'], 0, 120, '...') ?>
                        </p>

                        <p class="localizacao">
                            <i class="fa-solid fa-location-dot"></i>
                            <?= $doacao['localizacao'] ?>
                        </p>

                        <div class="info-doacao">

                            <div class="info-box">

                                <span class="label">
                                    Prazo
                                </span>

                                <strong>
                                    <?= $doacao['prazo'] ?> dias
                                </strong>

                            </div>

                            <div class="info-box">
                                <span class="label">
                                    Preço à arrecadar
                                </span>

                                <strong>
                                    R$ <?= number_format($doacao['preco_aarrecadar'], 2, ',', '.') ?>
                                </strong>
                            </div>
                        </div>

                        <?php if (
                            isset($_SESSION['usuario']) &&
                            $_SESSION['usuario']['tipo'] === 'administrador'
                        ) : ?>

                            <button
                                class="btn-ver-doacao"
                                onclick="abrirModalDoacao(
                                        '<?= $doacao['nome_doacao'] ?>',
                                        '<?= $doacao['administrador'] ?>'
                                        '<?= $doacao['descricao'] ?>',
                                        '<?= $doacao['prazo'] ?>',
                                        '<?= $doacao['preco_aarrecadar'] ?>',
                                        '<?= $doacao['localizacao'] ?>',
                                        '<?= !empty($doacao['foto']) ? $doacao['foto'] : '' ?>'
                                        )">
                                Ver doação
                            </button>

                        <?php else: ?>

                            <div class="botoes">
                                <button
                                    class="btn-ver-doacao"
                                    onclick="abrirModalDoacao(
                                        '<?= $doacao['nome_doacao'] ?>',
                                        '<?= $doacao['administrador'] ?>'
                                        '<?= $doacao['descricao'] ?>',
                                        '<?= $doacao['prazo'] ?>',
                                        '<?= $doacao['preco_aarrecadar'] ?>',
                                        '<?= $doacao['localizacao'] ?>',
                                        '<?= !empty($doacao['foto']) ? $doacao['foto'] : '' ?>'
                                        )">
                                    Ver doação
                                </button>

                                <a href="doacao.php?id=<?= $doacao['id'] ?>"
                                    class="btn-participar">
                                    Doar
                                </a>
                            </div>

                            <div class="modal-localizacao" id="modal-localizacao">

                                <p class="localizacao">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <?= $doacao['localizacao'] ?>
                                </p>
                            </div>

                        <?php endif; ?>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </section>

    <footer>
        <p>
            2024 © ONG Apoio Social. Todos os direitos reservados.
        </p>
    </footer>

    <div class="modal-doacao" id="modalDoacao">

        <div class="modal-box">

            <span
                class="fechar-modal"
                onclick="fecharModalDoacao()">
                &times;
            </span>

            <div class="modal-topo">


                <img
                    scr=""
                    id="modalFotoDoacao"
                    class="modal-foto">

                <div>
                    <span class="modal-administrador" id="modal-administrador"></span>

                    <h2 id="modal-titulo"></h2>
                </div>
            </div>

            <div class="modal-info">

                <p id="modal-descricao"></p>

                <div class="modal-detalhes">

                    <div class="detalhe-box">

                        <span>
                            Prazo
                        </span>

                        <strong id="modal-prazo"></strong>

                    </div>

                    <div class="detalhe-box">

                        <span>
                            Preço à arrecadar
                        </span>

                        <strong id="modal-preco_aarrecadar"></strong>

                    </div>

                </div>

            </div>

        </div>

    </div>



</body>

</html>
<script src="js/home.js"></script>