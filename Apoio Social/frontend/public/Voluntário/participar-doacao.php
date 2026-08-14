<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/UsuarioController.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/ParticipacaoController.php";


if (!isset($_SESSION['usuario'])) {

    header("Location: login.php");
    exit;
}


$doacaoController = new DoacaoController($pdo);
$usuarioController = new UsuarioController($pdo);
$participacaoController = new ParticipacaoController($pdo);


$usuario = $usuarioController->buscarUsuario(
    $_SESSION['usuario']['id']
);


$id = $_GET['id'] ?? null;


$doacao = $doacaoController->buscarPorId($id);


if (!$doacao) {

    echo "Doação não encontrada.";
    exit;
}


if ($doacao['id_doador'] == $_SESSION['usuario']['id']) {

    echo "Você não pode participar da própria doação.";
    exit;
}


if (isset($_POST['participar'])) {

    $doadorId = $_SESSION['usuario']['id'];

    $texto = trim($_POST['mensagem']);


    $participacaoController->participar(

        $doadorId,
        $id,
        $texto

    );


    header("Location: doacoes-participadas.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <link rel="stylesheet" href="../../css/participar-doacao.css">
    <title>Participar de Doação</title>

</head>

<body>


    <a
        href="../home.php"
        class="btn-back"
    >

        <svg
            class="icon-back"
            viewBox="0 0 24 24"
            fill="none"
        >

            <path
                d="M15 18l-6-6 6-6"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            />

        </svg>

    </a>


    <div class="container">

        <div class="card-doacao">


            <div class="topo-doacao">

                <img
                    src="<?= !empty($doacao['foto']) 
                        ? '../' . $doacao['foto'] 
                        : '../img/user.jpg' ?>"
                    class="foto-administrador"
                >


                <div>

                    <span class="administrador">

                        <?= htmlspecialchars(
                            $doacao['administrador']
                        ) ?>

                    </span>


                    <h1>

                        <?= htmlspecialchars(
                            $doacao['descricao']
                        ) ?>

                    </h1>

                </div>

            </div>


            <div class="descricao-box">

                <h3>
                    Sobre a doação
                </h3>

                <p>

                    <?= htmlspecialchars(
                        $doacao['descricao']
                    ) ?>

                </p>

            </div>


            <div class="infos">


                <div class="info-card">

                    <span>
                        Preço
                    </span>

                    <strong>

                        R$
                        <?= number_format(
                            $doacao['preco'],
                            2,
                            ',',
                            '.'
                        ) ?>

                    </strong>

                </div>


                <div class="info-card">

                    <span>
                        Prazo à arrecadar
                    </span>

                    <strong>

                        <?= htmlspecialchars(
                            $doacao['prazo_aarrecadar']
                        ) ?>

                        dias

                    </strong>

                </div>


                <div class="info-card">

                    <span>
                        Localização
                    </span>

                    <strong>

                        <?= htmlspecialchars(
                            $doacao['localizacao']
                        ) ?>

                    </strong>

                </div>

            </div>


            <form
                method="POST"
                class="form-participar"
            >


                <label>

                    Descreva o que você vai doar e para qual campanha

                </label>


                <textarea
                    name="mensagem"
                    placeholder="Explique detalhes da doação..."
                    required
                ></textarea>



                <div class="input-group">

                    <label>
                        Método de pagamento
                    </label>


                    <select
                        name="pagamento"
                        id="pagamento"
                        onchange="toggleCartao()"
                        required
                    >

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
                    id="cartaoFields"
                    style="display: none;"
                >

                    <div class="input-group">

                        <label>
                            Número do cartão
                        </label>


                        <input
                            type="text"
                            name="numero_cartao"
                            placeholder="0000 0000 0000 0000"
                        >

                    </div>



                    <div class="row-cartao">


                        <div class="input-group">

                            <label>
                                Validade
                            </label>


                            <input
                                type="text"
                                name="validade_cartao"
                                placeholder="MM/AA"
                            >

                        </div>



                        <div class="input-group">

                            <label>
                                CVV
                            </label>


                            <input
                                type="text"
                                name="cvv_cartao"
                                placeholder="123"
                            >

                        </div>

                    </div>

                </div>



                <div
                    class="pix-box"
                    id="pixBox"
                    style="display: none;"
                >

                    <h3>
                        Pagamento via PIX
                    </h3>


                    <p>

                        Utilize a chave PIX abaixo para realizar o pagamento:

                    </p>


                    <div class="pix-chave">

                        <?= htmlspecialchars(
                            $doacao['email']
                        ) ?>

                    </div>


                    <p class="pix-info">

                        Após o pagamento, clique em Participar Doação.

                    </p>

                </div>



                <button
                    type="submit"
                    name="participar"
                >

                    Participar Doação

                </button>

            </form>

        </div>

    </div>


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

</body>

</html>