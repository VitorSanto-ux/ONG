<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";


if (!isset($_SESSION['usuario'])) {

    header("Location: ../login.php");
    exit;
}


$doadorId = $_SESSION['usuario']['id'];


$sql = "
    SELECT
        participacoes.*,
       doacao.descricao,
       doacao.preco,
       doacao.prazo_aarrecadar,
       doacao.localizacao,
        usuarios.nome AS administrador,
        usuarios.foto

    FROM participacoes

    INNER JOIN doacao
        ON participacoes.doacao_id = doacao.id

    INNER JOIN usuarios
        ON doacao.id_doador = usuarios.id

    WHERE participacoes.doador_id = ?

    ORDER BY participacoes.id DESC
";


$stmt = $pdo->prepare($sql);

$stmt->execute([$doadorId]);

$participacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <link rel="stylesheet" href="../../css/doacoes-participadas.css">

    <title>Doações Participadas</title>

</head>


<body>


    <a
        href="../home.php"
        class="btn-back"
    >

        <i class="fa-solid fa-arrow-left"></i>

    </a>


    <div class="container">


        <div class="top-page">

            <h1>
                Doações Participadas
            </h1>

            <p>
                Veja todas as doações que você realizou.
            </p>

        </div>



        <?php if (!empty($participacoes)): ?>


            <div class="grid">


                <?php foreach ($participacoes as $p): ?>


                    <div class="card">


                        <div class="top-card">


                            <img
                                src="<?= !empty($p['foto'])
                                    ? '../' . $p['foto']
                                    : '../img/user.jpg' ?>"
                                class="foto"
                            >


                            <div class="content-top">


                                <div class="header-doacao">


                                    <div>


                                        <span class="administrador">

                                            <?= htmlspecialchars(
                                                $p['administrador']
                                            ) ?>

                                        </span>


                                        <h2>

                                            <?= htmlspecialchars(
                                                $p['descricao']
                                            ) ?>

                                        </h2>


                                    </div>



                                    <a
                                        href="deletar-participacao.php?id=<?= $p['id'] ?>"
                                        class="btn-delete"
                                        onclick="return confirm('Deseja remover esta participação?')"
                                    >

                                        <i class="fa-solid fa-trash"></i>

                                    </a>


                                </div>



                                <div class="status <?= htmlspecialchars($p['status']) ?>">

                                    <?= htmlspecialchars(
                                        ucfirst($p['status'])
                                    ) ?>

                                </div>


                            </div>


                        </div>



                        <div class="info-area">


                            <div class="info-box">


                                <span>
                                    Preço
                                </span>


                                <strong>

                                    R$
                                    <?= number_format(
                                        $p['preco'],
                                        2,
                                        ',',
                                        '.'
                                    ) ?>

                                </strong>


                            </div>



                            <div class="info-box">


                                <span>
                                    Prazo à arrecadar
                                </span>


                                <strong>

                                    <?= htmlspecialchars(
                                        $p['prazo_aarrecadar']
                                    ) ?>

                                    dias

                                </strong>


                            </div>


                        </div>



                        <div class="mensagem">


                            <h3>
                                Sua solicitação
                            </h3>


                            <p>

                                <?= htmlspecialchars(
                                    $p['mensagem']
                                ) ?>

                            </p>


                        </div>



                        <div class="localizacao">


                            <i class="fa-solid fa-map-marker-alt"></i>


                            <?= htmlspecialchars(
                                $p['localizacao']
                            ) ?>


                        </div>


                    </div>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <div class="empty">


                <h2>

                    Você ainda não realizou nenhuma doação.

                </h2>


            </div>


        <?php endif; ?>


    </div>


</body>

</html>