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

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $nombreCellule = $_POST['nombreCellule'];
    $nombrePlaceParCellule = $_POST['nombrePlaceParCellule'];

    $prisonController->ajouterPrison($nom, $adresse, $nombreCellule, $nombrePlaceParCellule);

    $message = 'La prison a été enregistrée avec succès!';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer une Prison</title>
    <link rel="stylesheet" href="../css/styleEnregistrerPrison.css">
</head>
<body>
<?php if ($message): ?>
            <div id="message" class="message">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
    <div class="container">
        <form action="enregistrer_prison.php" method="post">
            <h4>Enregistrement d'une Prison</h4>
            <hr>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>

            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" required>

            <label for="nombreCellule">Nombre de Cellules:</label>
            <input type="number" id="nombreCellule" name="nombreCellule" required>

            <label for="nombrePlaceParCellule">Nombre de Places par Cellule:</label>
            <input type="number" id="nombrePlaceParCellule" name="nombrePlaceParCellule" required>

            <button type="submit">Enregistrer</button>
        </form>

        
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var message = document.getElementById('message');
            if (message) {
                message.style.display = 'block';
                setTimeout(function() {
                    message.style.opacity = 0;
                    setTimeout(function() {
                        message.style.display = 'none';
                    }, 600); 
                }, 2000); 
            }
        });
    </script>
</body>
</html>
