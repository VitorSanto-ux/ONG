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
/*
|--------------------------------------------------------------------------
| SUA CONEXÃO E CONTROLLERS JÁ EXISTENTES
|--------------------------------------------------------------------------
| Mantenha aqui os requires que você já possui.
*/


// ==========================================================
// RF04 - DASHBOARD
// ==========================================================

// Aqui você vai receber os valores vindos do banco.
// Exemplo:
// $totalUsuarios = ...;
// $totalDoacoes = ...;
// $totalCampanhas = ...;
// $totalParticipacoes = ...;


// ==========================================================
// RF05 - PESQUISA
// ==========================================================

// A pesquisa será feita pelo campo abaixo.
// O JavaScript irá procurar por:
// - Nome da campanha
// - Administrador
// - Descrição

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Apoio Social</title>

    <style>

        /* ==================================================
           DASHBOARD - RF04
        ================================================== */

        .dashboard {
            width: 90%;
            margin: 30px auto;
        }

        .dashboard h2 {
            margin-bottom: 20px;
        }

        .tabela-dashboard {
            width: 100%;
            border-collapse: collapse;
        }

        .tabela-dashboard th,
        .tabela-dashboard td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .tabela-dashboard th {
            font-weight: bold;
        }

        .tabela-dashboard td:last-child {
            text-align: center;
            font-weight: bold;
        }


        /* ==================================================
           PESQUISA - RF05
        ================================================== */

        .area-pesquisa {
            width: 90%;
            margin: 30px auto;
        }

        #pesquisa {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }


        /* ==================================================
           CARDS
        ================================================== */

        .doacoes-grid {
            width: 90%;
            margin: auto;

            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(250px, 1fr));

            gap: 20px;
        }

        .card-doacao {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

    </style>

</head>


<body>


    <!-- ==================================================
         RF04 - DASHBOARD
    ================================================== -->

    <section class="dashboard">

        <h2>Dashboard</h2>

        <table class="tabela-dashboard">

            <thead>

                <tr>
                    <th>Indicador</th>
                    <th>Total</th>
                </tr>

            </thead>

            <tbody>

                <tr>
                    <td>Total de Usuários</td>

                    <td>
                        <?= $totalUsuarios ?? 0 ?>
                    </td>
                </tr>


                <tr>
                    <td>Total de Doações</td>

                    <td>
                        <?= count($doacoes) ?? 0 ?>
                    </td>
                </tr>


                <tr>
                    <td>Total de Campanhas</td>

                    <td>
                        <?= count($campanhas) ?? 0 ?>
                    </td>
                </tr>


                <tr>
                    <td>Total de Participações</td>

                    <td>
                        <?= $totalParticipacoes ?? 0 ?>
                    </td>
                </tr>

            </tbody>

        </table>

    </section>



    <!-- ==================================================
         RF05 - PESQUISA POR PALAVRA-CHAVE
    ================================================== -->

    <section class="area-pesquisa">

        <h2>Pesquisar</h2>

        <input
            type="text"
            id="pesquisa"
            placeholder="Digite uma palavra-chave..."
        >

    </section>



    <!-- ==================================================
         LISTAGEM DAS DOAÇÕES
    ================================================== -->

    <section class="doacoes campanhas-menu">

        <div class="doacoes-grid">


            <?php foreach ($doacoes as $doacao): ?>

                <div
                    class="card-doacao"

                    data-nome="<?= strtolower(
                        $doacao['campanha'] ?? ''
                    ) ?>"

                    data-administrador="<?= strtolower(
                        $doacao['administrador'] ?? ''
                    ) ?>"

                    data-descricao="<?= strtolower(
                        $doacao['descricao'] ?? ''
                    ) ?>"
                >

                    <h3>
                        <?= htmlspecialchars(
                            $doacao['campanha'] ?? ''
                        ) ?>
                    </h3>


                    <p>
                        <strong>Administrador:</strong>

                        <?= htmlspecialchars(
                            $doacao['administrador'] ?? ''
                        ) ?>
                    </p>


                    <p>
                        <?= htmlspecialchars(
                            $doacao['descricao'] ?? ''
                        ) ?>
                    </p>

                </div>

            <?php endforeach; ?>


        </div>

    </section>



    <!-- ==================================================
         JAVASCRIPT - RF05
    ================================================== -->

    <script>

        const pesquisa =
            document.getElementById("pesquisa");

        const cards =
            document.querySelectorAll(".card-doacao");


        pesquisa.addEventListener("input", function () {

            const palavra =
                this.value.toLowerCase().trim();


            cards.forEach(function (card) {

                const nome =
                    card.dataset.nome || "";

                const administrador =
                    card.dataset.administrador || "";

                const descricao =
                    card.dataset.descricao || "";


                const encontrou =
                    nome.includes(palavra) ||
                    administrador.includes(palavra) ||
                    descricao.includes(palavra);


                if (encontrou) {

                    card.style.display = "";

                } else {

                    card.style.display = "none";

                }

            });

        });

    </script>


</body>

</html>