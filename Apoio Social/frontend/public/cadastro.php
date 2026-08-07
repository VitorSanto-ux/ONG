<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_SESSION['cadastro'] = [
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'telefone' => $_POST['telefone'],
        'senha' => $_POST['senha'],
    ];

    header('Location: escolher-tipo.php');

    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>

<body class="auth-page">

    <main class="auth-shell">
        <section class="auth-panel">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>
                <div class="logo-text">
                    <span class="logo-name">Apoio Social</span>
                </div>
            </div>
                <p class="muted">
                    Cadastre-se para fazer parte da nossa comunidade e contribuir para a transformação de vidas através da solidariedade. Ao se cadastrar, você terá acesso a oportunidades de voluntariado, campanhas de arrecadação e poderá acompanhar de perto o impacto positivo que estamos gerando na sociedade.
                </p>

                <form method="POST">
                    <label for="nome">Nome: </label>
                    <input type='text' id='nome' name='nome' placeholder='Digite seu nome' required>

                    <label for='email'>E-mail: </label>
                    <input type='email' id='email' name='email' placeholder='Digite seu e-mail' required>

                    <label for='telefone'>Telefone: </label>
                    <input type='tel' id='telefone' name='telefone' placeholder='(00) 00000-0000' required>

                    <label for='senha'>Senha: </label>
                    <input type='password' id='senha' name='senha' placeholder='Digite sua senha' required>

                    <button type='submit'>Continuar</button>
                </form>

                <p class="auth-footer">
                    Já possui uma conta? <a href='login.php'>Entrar</a>
                </p>
        </section>
    </main>
</body>

</html>