<?php

session_start();

$campanhaController = new CampanhaController($pdo);
$campanhas = $campanhaController->listar();

$doacaoController = new DoacaoController($pdo);

$q = $_GET['q'] ?? '';
$campanhaId = $_GET['campaha_id'] ?? null;

$doacoes = $doacaoController->buscarFiltrados($q, $campanhaId);

$notificacoes = 0;

if(!empty($_SESSION['usuario'])) {
    $doadorController = new DoadorController($pdo);

    if($_SESSION['usuario']['tipo'] == 'administrador') {
        $notificacoes = $doadorController->contarPendentesAdministrador($_SESSION['usuario']['id']);
    }else {
        $notificacoes = $doadorController->contarPendentesVoluntario($_SESSION['usuario']['id']);
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
        <span>Apoio Social</span>

        <nav>
            <?php

            $linkNotificacoes = "#";

            if(!empty($_SESSION['usuario'])) {

                    if($_SESSION['usuario']['tipo'] === 'administrador') {
                        $linkNotificacoes = "Administrador/notificacoes.php";
                    }else {
                        $linkNotificacoes = "Voluntario/notificacoes.php";
                    }
            }
            ?>

            <form method="GET" action="home.php">
                <input type="text" id="searchInput" name="q" placeholder="Pesquisar campanhas" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">

                <button type="submit">
                </button>

                <a href="<?= $linkNotificacao ?>">
                    <?php if ($notificacoes > 0): ?>

                        <span>
                            <?= $notificacoes ?>
                        </span>
                    <?php endif; ?>

                </a>
            </form>

            <?php if(!empty($_SESSION['usuario'])): ?>
                <a href="perfil.php"></a>

            <?php else: ?>
                <a href="login.php">Entrar</a>
                <a href="cadastrar.php">Cadastrar</a>
            <?php endif; ?>
        </nav>
    </header>

   <section>
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
    
    <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['tipo'] === 'administrador'): ?>
        <h3>
            Você é um administrador.
        </h3>

        <p>
            Publique campanhas, gerencie doações e voluntários, e acompanhe o impacto positivo que estamos gerando na sociedade.
        </p>

        <a href="administrador/campanhas/minhas-campanhas.php">Gerenciar Campanhas</a>
    <?php else: ?>
        <h3>
            Você é um voluntário.
        </h3>

        <p>
            Participe de ações voluntárias, faça doações e ajude a construir um mundo mais justo e solidário.
        </p>

        <a href="#campanhas">
            Explorar Campanhas
        </a>
    <?php endif; ?>
</section>

<section id="campanhasDropdown">
    <button onclick="toggleCampanhas()">
        Explorar Campanhas
    </button>

    <a href="home.php">
        todas as campanhas
    </a>

    <?php foreach ($campanhas as $cat): ?>

        <a href="home.php?campaha=<?= $cat['id'] ?>">
            <?= htmlspecialchars($cat['nome']) ?>
        </a>
    <?php endforeach; ?>
</section>

<section id="campanhas">
    <?php foreach ($doacoes as $doacao): ?>
        
</section>