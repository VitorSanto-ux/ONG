<?php

session_start();

$UsuarioController = new UsuarioController($pdo);

$erro = '';

$email = '';

if(isset($_SESSION['usuario'])) {

    header("Location: home.php");

    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $email = trim($_POST['email']);

    $senha = trim($_POST['senha']);

    $usuario = $UsuarioController->Login(
        $email,
        $senha
    );

    if($usuario) {

        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email'],
            'tipo' => $usuario['tipo']
        ];

        header("Location: home.php");

        exit;
    }else {

        $erro = "email ou senha invalidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    
    <main>
        <section>
            <span>Apoio Social</span>

            <p>
                Acesse sua conta para contribuir com a nossa missão de transformar vidas através da solidariedade. Ao fazer login, você terá acesso a oportunidades de voluntariado, campanhas de arrecadação e poderá acompanhar de perto o impacto positivo que estamos gerando na sociedade.
            </p>

            <?php if($erro): ?>
                <?= $erro ?>
            <?php endif; ?>

            <form method="POST">
                <label for="email">E-mail </label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Digite seu e-mail" required>

                <label for="senha">Senha </label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>

                <button type="submit">Entrar</button>
            </form>

            <p>
                Não possui uma conta? <a href="cadastrar.php">Cadastrar</a>
            </p>
        </section>
    </main>
</body>
</html>