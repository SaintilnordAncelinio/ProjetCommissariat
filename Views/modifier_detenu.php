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


if (!isset($_GET['code'])) {
    echo "Code de détenu non spécifié.";
    exit();
}

$code = $_GET['code'];

$controller = new DetenuController($pdo);

$detenus = $controller->listerDetenus();
$detenu = array_filter($detenus, function($d) use ($code) {
    return $d['code'] == $code;
});

if (empty($detenu)) {
    echo "Détail du détenu non trouvé.";
    exit();
}

$detenu = array_shift($detenu); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nouveauStatut = $_POST['statut'];
    
    if (!empty($nouveauStatut)) {
        $detenuObj = new Detenu($pdo, $detenu['nom'], $detenu['prenom'], $detenu['cin_ou_nif'], $detenu['sexe'], $detenu['adresse'], $detenu['telephone'], $detenu['infraction'], $nouveauStatut, $detenu['id_prison'], $detenu['code'], $detenu['id_detenu']);
        $detenuObj->modifierStatut($nouveauStatut);
        $_SESSION['message'] = "Statut mis à jour avec succès.";
        header('Location: list_detenu.php');
        exit();
    } else {
        $message = "Veuillez sélectionner un statut.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Détention</title>
    <link rel="stylesheet" href="../css/styleEnregistrerPrison.css">
</head>
<body>
    <?php if (isset($message)): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <div class="container">
  
    <form method="POST" action="">
    <h4>Modifier le statut du détenu</h4>
    <hr>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" value="<?php echo htmlspecialchars($detenu['nom']); ?>" readonly>
        
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" value="<?php echo htmlspecialchars($detenu['prenom']); ?>" readonly>
        
        <label for="sexe">Sexe :</label>
        <input type="text" id="sexe" value="<?php echo htmlspecialchars($detenu['sexe']); ?>" readonly>
        
        <label for="prison_nom">Prison :</label>
        <input type="text" id="prison_nom" value="<?php echo htmlspecialchars($detenu['prison_nom']); ?>" readonly>
        
        <label for="statut">Statut :</label>
        <select id="statut" name="statut" required>
            <option value="">Sélectionnez Statut</option>
            <option value="En détention" <?php echo $detenu['statut'] === 'En détention' ? 'selected' : ''; ?>>En détention</option>
            <option value="Libéré conditionnellement" <?php echo $detenu['statut'] === 'Libéré conditionnellement' ? 'selected' : ''; ?>>Libéré conditionnellement</option>
            <option value="Transféré" <?php echo $detenu['statut'] === 'Transféré' ? 'selected' : ''; ?>>Transféré</option>
            <option value="Évadé" <?php echo $detenu['statut'] === 'Évadé' ? 'selected' : ''; ?>>Évadé</option>
            <option value="Décédé" <?php echo $detenu['statut'] === 'Décédé' ? 'selected' : ''; ?>>Décédé</option>
            <option value="En attente de jugement" <?php echo $detenu['statut'] === 'En attente de jugement' ? 'selected' : ''; ?>>En attente de jugement</option>
            <option value="Autres" <?php echo $detenu['statut'] === 'Autres' ? 'selected' : ''; ?>>Autres</option>
        </select>
        <button type="submit">Modifier le statut</button>
    </form>
    </div>
</body>
</html>
