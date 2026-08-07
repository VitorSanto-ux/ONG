<?php

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";

$doacaoController = new DoacaoController($pdo);

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomeDoacao = $_POST['nome_doacao'];
    $descricao = $_POST['descricao'];
    $precoaarrecadar = $_POST['preco_aarrecadar'];
    $prazo = $_POST['prazo'];
    $campanhaId = $_POST['campanha_id'];
    $localizacao = $_POST['localizacao'];

    $usuarioId = $_SESSION['usuario']['id'];

    $criou = $doacaoController->criar(
        $usuarioId,
        $campanhaId,
        $nomeDoacao,
        $descricao,
        $precoaarrecadar,
        $prazo,
        $localizacao
    );

    if ($criou) {

        $mensagem = "Doação criada com sucesso!";

        header("Location: minhas-doacoes.php");
        exit;
    }else {

        $mensagem = "Erro ao criar doação.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Doação</title>
</head>
<body>
    <div class=page>
        <div class="form-box">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>
                <div class="logo-text">
                    <span class="logo-name">Apoio Social</span>
                </div>
            </div>
            <br>

            <?php if($mensagem): ?>
                <div class="mensagem">
                    <?= $mensagem ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>
                        Nome da Doação:
                    </label>

                    <input
                        type="text"
                        name="nome_doacao"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>
                        Descrição:
                    </label>

                    <textarea
                        name="descricao"
                        maxlength="3000"
                        placeholder="Descreva a doação..."
                        required
                    ></textarea>
                </div>

                <div class="form-group">
                    <label>
                        Preço à arrecadar:
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="preco_aarrecadar"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>
                        Prazo (dias):
                    </label>

                    <input
                        type="number"
                        name="prazo"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>
                        Campanhas
                    </label>

                    <select name="campanha_id" required>
                        <option value="">
                            Selecione
                        </option>

                        <option value="1">
                            Campanha do Agasalho
                        </option>

                        <option value="2">
                            Natal Solidário
                        </option>

                        <option value="3">
                            Mochila do Futuro
                        </option>

                        <option value="4">
                            Prato Cheio
                        </option>

                        <option value="5">
                            Doe um Sorriso
                        </option>

                        <option value="6">
                            Mãos que Ajudam
                        </option>

                        <option value="7">
                            Esperança Verde
                        </option>

                        <option value="8">
                            Saúde para Todos
                        </option>

                        <option value="9">
                            Conectando Vidas
                        </option>

                        <option value="10">
                            Emprego e Dignidade
                        </option>

                        <option value="11">
                            Doe Sangue, Salve Vidas
                        </option>

                        <option value="12">
                            Cesta do Bem
                        </option>

                        <option value="13">
                            Amigo Idoso
                        </option>

                        <option value="14">
                            Volta às Aulas Solidária
                        </option>

                        <option value="15">
                            Páscoa Solidária
                        </option>

                        <option value="16">
                            Inverno Sem Frio
                        </option>

                        <option value="17">
                            Outubro Rosa e Novembro Azul
                        </option>

                        <option value="18">
                            Doe Tempo
                        </option>

                        <option value="19">
                            Dia das Crianças Feliz
                        </option>

                        <option value="20">
                            Juntos Contra a Fome
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>
                        Localização:
                    </label>

                    <input
                        type="text"
                        name="localizacao"
                    >
                </div>


                <button>
                    type="submit"
                    class="btn-submit"
                >
                    Publicar doação
                </button>
            </form>
        </div>
    </div>
</body>
</html>