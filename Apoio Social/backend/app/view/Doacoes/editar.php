<?php

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";

$doacaoController = new DoacaoController($pdo);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $doacao = $doacaoController->buscarPorId($id);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Editar Doação</title>

</head>

<body>

    <form method="post">

        <label for="nome_doacao">
            Nome da Doação:
        </label>

        <input
            type="text"
            name="nome_doacao"
            value="<?= $doacao['nome_doacao'] ?>"
            required>

        <br>


        <label for="descricao">
            Descrição da Doação:
        </label>

        <textarea
            name="descricao"
            required><?= $doacao['descricao'] ?></textarea>

        <br>


        <label for="preco_aarrecadar">
            Preço à Arrecadar:
        </label>

        <input
            type="number"
            name="preco_aarrecadar"
            step="0.01"
            value="<?= $doacao['preco'] ?>"
            required>

        <br>


        <label for="prazo_aarrecadar">
            Prazo da Doação:
        </label>

        <input
            type="text"
            name="prazo_aarrecadar"
            value="<?= $doacao['prazo_aarrecadar'] ?>"
            required>

        <br>


        <label for="localizacao">
            Localização da Doação:
        </label>

        <input
            type="text"
            name="localizacao"
            value="<?= $doacao['localizacao'] ?>"
            required>

        <br>


        <input
            type="submit"
            value="Atualizar">

    </form>

</body>

</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome_doacao = $_POST['nome_doacao'];
    $descricao = $_POST['descricao'];
    $preco_aarrecadar = $_POST['preco_aarrecadar'];
    $prazo_aarrecadar = $_POST['prazo_aarrecadar'];

    $doacaoController->editar(
        $id,
        $nome_doacao,
        $descricao,
        $preco_aarrecadar,
        $prazo_aarrecadar
    );

    header('Location: ../../../index.php');
    exit;

} else {

    header('Location: Listar.php');
    exit;
}

?>