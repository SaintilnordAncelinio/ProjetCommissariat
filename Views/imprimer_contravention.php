<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
require '../config/Database.php';
require '../model/Contravention.php';

$pdo = Database::getConnect();


$contravention = null;
if (isset($_GET['code'])) {
    $contravention = Contravention::rechercher($pdo, $_GET['code']);
    if (!$contravention) {
        $_SESSION['message'] = "Contravention non trouvée.";
        header('Location: list_contravention.php');
        exit();
    }
} else {
    $_SESSION['message'] = "Code de contravention non fourni.";
    header('Location: list_contravention.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimer Contravention</title>
    <link rel="stylesheet" href="../css/styleImprimer.css">
   
</head>
<body>
    <div class="contravention-details">
        <h2>Contravention</h2>
        <table>
            <tr>
                <th>Code</th>
                <td><?php echo htmlspecialchars($contravention['code']); ?></td>
            </tr>
            <tr>
                <th>Nom du Chauffeur</th>
                <td><?php echo htmlspecialchars($contravention['nom_chauffeur']); ?></td>
            </tr>
            <tr>
                <th>Numéro de Permis</th>
                <td><?php echo htmlspecialchars($contravention['no_permis']); ?></td>
            </tr>
            <tr>
                <th>Numéro de Plaque</th>
                <td><?php echo htmlspecialchars($contravention['no_plaque']); ?></td>
            </tr>
            <tr>
                <th>Lieu de la Contravention</th>
                <td><?php echo htmlspecialchars($contravention['lieu_contravention']); ?></td>
            </tr>
            <tr>
                <th>Numéro de Violation</th>
                <td><?php echo htmlspecialchars($contravention['no_violation']); ?></td>
            </tr>
            <tr>
                <th>Article</th>
                <td><?php echo htmlspecialchars($contravention['article']); ?></td>
            </tr>
            <tr>
                <th>Date et Heure</th>
                <td><?php echo htmlspecialchars($contravention['date_heure']); ?></td>
            </tr>
            <tr>
                <th>Numéro de l'Agent</th>
                <td><?php echo htmlspecialchars($contravention['no_agent']); ?></td>
            </tr>
            <tr>
                <th>Numéro de Matricule</th>
                <td><?php echo htmlspecialchars($contravention['no_matricule']); ?></td>
            </tr>
        </table>
        <a href="#" onclick="window.print();" class="print-button">Imprimer</a>
    </div>
</body>
</html>
