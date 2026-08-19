<!-- <?php -->

session_start();

require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/db/database.php";
require_once "C:/Turma2/xampp/htdocs/ONG/Apoio Social/backend/app/controllers/DoacaoController.php";


// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {

    header("Location: ../../login.php");

    exit;
}


// Apenas administrador pode excluir doações
if ($_SESSION['usuario']['tipo'] !== 'administrador') {

    header("Location: ../../home.php");

    exit;
}


// Pega o ID da doação
$id = $_GET['id'] ?? null;


// Se não tiver ID, volta para minhas campanhas
if (!$id) {

    header("Location: minhas-campanhas.php");

    exit;
}


// Controller
$doacaoController = new DoacaoController($pdo);


// Exclui a doação
$doacaoController->deletar($id);


// Volta para minhas campanhas
header("Location: minhas-campanhas.php");

exit;