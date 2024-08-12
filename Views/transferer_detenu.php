<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
require '../config/Database.php';
require '../model/Detenu.php';
require '../controllers/DetenuController.php';
include '../includes/header.php';

$pdo = Database::getConnect();
$detenuController = new DetenuController($pdo);


if (!isset($_GET['code'])) {
    $_SESSION['message'] = "Code de détenu manquant!";
    header('Location: list_detenu.php');
    exit();
}

$codeDetenu = $_GET['code'];
$detenu = $detenuController->getDetenuByCode($codeDetenu);

if (!$detenu) {
    $_SESSION['message'] = "Déténu introuvable!";
    header('Location: list_detenu.php');
    exit();
}


$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nouvellePrison = $_POST['nouvelle_prison'];
    $detenuController->transfererDetenu($codeDetenu, $nouvellePrison);
    $_SESSION['message'] = "Déténu transféré avec succès!";
    header('Location: list_detenu.php');
    exit();
}


$prisons = $detenuController->getListePrisons();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transférer Détenu</title>
    <link rel="stylesheet" href="../css/styleEnregistrerPrison.css">
</head>
<body>
    <div id="message" class="message">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <div class="container">
        <form action="transferer_detenu.php?code=<?php echo urlencode($codeDetenu); ?>" method="post">
        <h4>Transférer Détenu</h4>
        <hr>
                <label>Nom :</label>
                <input type="text" value="<?php echo htmlspecialchars($detenu['nom']); ?>" disabled>
           
            
                <label>Prénom :</label>
                <input type="text" value="<?php echo htmlspecialchars($detenu['prenom']); ?>" disabled>
            
            
                <label>Ancienne Prison :</label>
                <input type="text" value="<?php echo htmlspecialchars($detenu['prison_nom']); ?>" disabled>
          
            
                <label>Nouvelle Prison :</label>
                <select name="nouvelle_prison" required>
                    <?php foreach ($prisons as $prison): ?>
                        <option value="<?php echo htmlspecialchars($prison['id_prison']); ?>">
                            <?php echo htmlspecialchars($prison['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
        
            <button type="submit">Transférer</button>
        </form>
    </div>
</body>
</html>
