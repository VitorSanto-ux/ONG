<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Locatio: login.php");
    exit;
}

$doacaoController = new DoacaoController($pdo);
$usuarioController = new UsuarioController($pdo);
$participarController = new ParticiparController($pdo);

$usuario = $usuarioController->buscarUsuario($_SESSION['usuario']['id']);

$id = $_GET['id'] ?? null;

$doacao = $doacaoController->buscarPorId($id);

if (!$doacao) {
    echo "Doação não encontrada.";
    exit;
}

if ($doacao['usuario_id'] == $_SESSION['usuario']['id']) {
    echo "Você não pode participar da própria doação.";
    exit;
}

if (isset($_POST['participar'])) {
    $doadorId = $_SESSION['usuario']['id'];
    $texto = trim($_POST['mensagem']);

    $participarController->participar(
        $doadorId,
        $id,
        $texto
    );
    header("Location: doacao-participados.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participar de Doação</title>
</head>

<body>
    <a href="../home.php" class="btn-back">
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
        <div class="card-doacao">
            <div class="topo-doacao">
                <img src="<?= !empty($doacao['foto']) ? '../' . $doacao['foto'] : '' ?>"
                    class="foto-administrador">

                <div>

                    <span class="administrador">

                        <?= htmlspecialchars($doacao['administrador']) ?>

                    </span>

                    <h1>

                        <?= htmlspecialchars($doacao['nome_doacao']) ?>

                    </h1>

                </div>
            </div>

            <div class="descricao-box">

                <h3>
                    Sobre a doação
                </h3>

                <p>

                    <?= htmlspecialchars($doacao['descricao']) ?>

                </p>

            </div>

            <div class="infos">

                <div class="info-card">

                    <span>Preço</span>

                    <strong>

                        R$ <?= number_format(
                                $doacao['preco'],
                                2,
                                ',',
                                '.'
                            ) ?>

                    </strong>

                </div>


                <div class="info-card">

                    <span>Prazo à arrecadar</span>

                    <strong>

                        <?= $doacao['prazo_aarrecadar'] ?> dias

                    </strong>

                </div>


                <div class="info-card">

                    <span>Localização</span>

                    <strong>

                        <?= htmlspecialchars($doacao['localizacao']) ?>

                    </strong>

                </div>

            </div>

            <form
                method="POST"
                class="form-participar">

                <label>

                    Descreva o que você vai doar e para qual campanha

                </label>

                <textarea
                    name="mensagem"
                    placeholder="Explique detalhes da doação..."
                    required></textarea>


                <div class="input-group">

                    <label>
                        Método de pagamento
                    </label>

                    <select
                        name="pagamento"
                        id="pagamento"
                        onchange="toggleCartao()"
                        required>

                        <option value="">
                            Selecione
                        </option>

                        <option value="pix">
                            PIX
                        </option>

                        <option value="cartao">
                            Cartão
                        </option>

                    </select>

                </div>

                <div
                    class="cartao-fields"
                    id="cartaoFields">

                    <div class="input-group">

                        <label>
                            Número do cartão
                        </label>

                        <input
                            type="text"
                            name="numero_cartao"
                            placeholder="0000 0000 0000 0000">

                    </div>


                    <div class="row-cartao">

                        <div class="input-group">

                            <label>
                                Validade
                            </label>

                            <input
                                type="text"
                                name="validade_cartao"
                                placeholder="MM/AA">

                        </div>


                        <div class="input-group">

                            <label>
                                CVV
                            </label>

                            <input
                                type="text"
                                name="cvv_cartao"
                                placeholder="123">

                        </div>

                    </div>
                </div>

                <div
                    class="pix-box"
                    id="pixBox">

                    <h3>
                        Pagamento via PIX
                    </h3>

                    <p>

                        Utilize a chave PIX abaixo para realizar o pagamento:

                    </p>

                    <div class="pix-chave">

                        <?= htmlspecialchars($doacao['email']) ?>

                    </div>

                    <p class="pix-info">

                        Após o pagamento, clique em Confirmar Doação.

                    </p>

                </div>


                <button
                    type="submit"
                    name="contratar">

                    Participar Doação

                </button>

            </form>
        </div>
    </div>
</body>

</html>

<script>

function toggleCartao() {

    const pagamento =
        document.getElementById('pagamento').value;

    const camposCartao =
        document.getElementById('cartaoFields');

    const pixBox =
        document.getElementById('pixBox');

    if (pagamento === 'cartao') {

        camposCartao.style.display = 'block';
        pixBox.style.display = 'none';

    }

    else if (pagamento === 'pix') {

        camposCartao.style.display = 'none';
        pixBox.style.display = 'block';

    }

    else {

        camposCartao.style.display = 'none';
        pixBox.style.display = 'none';
    }
}

</script>