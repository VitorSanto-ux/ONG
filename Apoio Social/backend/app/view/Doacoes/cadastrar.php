<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Doações</title>
</head>

<body>
    <form method="post">
        <label for="nome_doacao">Nome da Doação: </label>
        <input type="text" name="nome_doacao" required><br>

        <label for="descricao">Descrição da Doação: </label>
        <input type="text" name="descricao" required><br>

        <label for="preco_aarrecadar_id">Preço da Doação: </label>
        <input type="number" name="preco_aarrecadar" step="0.01" required><br>

        <label for="campanhas_id">Campanhas da Doação: </label>
        <select name="campanhas_id" required>
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

        <label for="prazo">Prazo da Doação: </label>
        <input type="number" name="prazo" required><br>

        <label for="localização">Localização da Doação: </label>
        <input type="text" name="localizacao" required><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>

</html>

<?php  

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";

$DoacaoController = new DoacaoController($pdo);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome_doacao = $_POST['nome_doacao'];
    $descricao = $_POST['descricao'];
    $preco_aarrecadar = $_POST['preco_aarrecadar'];
    $campanha_id = $_POST['campanha_id'];
    $prazo = $_POST['prazo'];
    $localizacao = $_POST['localizacao'];

    $DoacaoController->cadastrar($nome_doacao, $descricao, $preco_aarrecadar, $campanha_id, $prazo, $localizacao);
    header('Location: ../../../index.php');
}
?>