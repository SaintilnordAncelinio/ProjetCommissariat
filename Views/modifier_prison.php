<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

require '../config/Database.php';
require '../model/Prison.php';
require '../controllers/PrisonController.php';
include '../includes/header.php';

$pdo = Database::getConnect();
$prisonController = new PrisonController($pdo);

if (!isset($_GET['code'])) {
    echo "Code de prison non fourni!";
    exit;
}

$code = $_GET['code'];
$prison = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $nombreCellule = $_POST['nombreCellule'];
    $nombrePlaceParCellule = $_POST['nombrePlaceParCellule'];

    $prisonController->modifierPrison($code, $nom, $adresse, $nombreCellule, $nombrePlaceParCellule);

    $_SESSION['message'] = "La prison a été modifiée avec succès!";
    header("Location: list_prison.php");
    exit;
} else {
    $prisons = $prisonController->listerPrisons();
    foreach ($prisons as $p) {
        if ($p['code'] == $code) {
            $prison = $p;
            break;
        }
    }
}

if ($prison == null) {
    echo "Prison non trouvée!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Prison</title>
    <link rel="stylesheet" href="../css/styleEnregistrerPrison.css">
       
</head>
<body>
   <div class="container">
    <form action="modifier_prison.php?code=<?php echo urlencode($code); ?>" method="post">
        <h4>Modification prison</h4>
        <hr>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($prison['nom']); ?>" required>

        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($prison['adresse']); ?>" required>

        <label for="nombreCellule">Nombre de Cellules:</label>
        <input type="number" id="nombreCellule" name="nombreCellule" value="<?php echo htmlspecialchars($prison['nombre_de_cellule']); ?>" required>

        <label for="nombrePlaceParCellule">Nombre de Places par Cellule:</label>
        <input type="number" id="nombrePlaceParCellule" name="nombrePlaceParCellule" value="<?php echo htmlspecialchars($prison['nombre_de_place_par_cellule']); ?>" required>
        <button>Modifier</button>
    </form>
    </div>
</body>
</html>
