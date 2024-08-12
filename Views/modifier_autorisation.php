<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
require '../config/Database.php';
require '../model/Autorisation.php';
require '../controllers/AutorisationController.php';
include '../includes/header.php';

$pdo = Database::getConnect();
$autorisationController = new AutorisationController($pdo);

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

$autorisation = null;
if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $autorisation = Autorisation::rechercher($pdo, $code);
    if (!$autorisation) {
        $_SESSION['message'] = 'Autorisation non trouvée.';
        header('Location: list_autorisation.php');
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $serie = $_POST['serie'];
    $numeroMoteur = $_POST['numero_moteur'];
    $couleur = $_POST['couleur'];
    $type = $_POST['type'];
    $nombreCylindres = $_POST['nombre_cylindres'];
    $annee = $_POST['annee'];
    $puissance = $_POST['puissance'];
    $numeroPlaque = $_POST['numero_plaque'];
    $nomProprietaire = $_POST['nom_proprietaire'];
    $nifCin = $_POST['nif_cin'];
    $adresse = $_POST['adresse'];

    $autorisationController->modifierAutorisation($code, $marque, $modele, $serie, $numeroMoteur, $couleur, $type, $nombreCylindres, $annee, $puissance, $numeroPlaque, $nomProprietaire, $nifCin, $adresse);

    $_SESSION['message'] = 'Autorisation mise à jour avec succès!';
    header('Location: list_autorisation.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Autorisation</title>
    <link rel="stylesheet" href="../css/styleEnregistrerPrison.css">
</head>
<body>
    <div id="message" class="message">
        <?php echo htmlspecialchars($message); ?>
    </div>
 

        <div class="container">
    <form action="modifier_autorisation.php" method="post">
    <h4>Modifier Autorisation</h4>
    <hr>
        <input type="hidden" name="code" value="<?php echo htmlspecialchars($autorisation['code']); ?>">

        <label for="marque">Marque:</label>
        <input type="text" id="marque" name="marque" value="<?php echo htmlspecialchars($autorisation['marque']); ?>" required>

        <label for="modele">Modèle:</label>
        <input type="text" id="modele" name="modele" value="<?php echo htmlspecialchars($autorisation['modele']); ?>" required>

        <label for="serie">Série:</label>
        <input type="text" id="serie" name="serie" value="<?php echo htmlspecialchars($autorisation['serie']); ?>" required>

        <label for="numero_moteur">Numéro du Moteur:</label>
        <input type="text" id="numero_moteur" name="numero_moteur" value="<?php echo htmlspecialchars($autorisation['no_moteur']); ?>" required>

        <label for="couleur">Couleur:</label>
        <input type="text" id="couleur" name="couleur" value="<?php echo htmlspecialchars($autorisation['couleur']); ?>" required>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($autorisation['type']); ?>" required>

        <label for="nombre_cylindres">Nombre de Cylindres:</label>
        <input type="text" id="nombre_cylindres" name="nombre_cylindres" value="<?php echo htmlspecialchars($autorisation['nombre_de_cylindre']); ?>" required>

        <label for="annee">Année:</label>
        <input type="text" id="annee" name="annee" value="<?php echo htmlspecialchars($autorisation['annee']); ?>" required>

        <label for="puissance">Puissance:</label>
        <input type="text" id="puissance" name="puissance" value="<?php echo htmlspecialchars($autorisation['puissance']); ?>" required>

        <label for="numero_plaque">Numéro de Plaque:</label>
        <input type="text" id="numero_plaque" name="numero_plaque" value="<?php echo htmlspecialchars($autorisation['no_plaque']); ?>" required>

        <label for="nom_proprietaire">Nom du Propriétaire:</label>
        <input type="text" id="nom_proprietaire" name="nom_proprietaire" value="<?php echo htmlspecialchars($autorisation['nom_proprietaire']); ?>" required>

        <label for="nif_cin">NIF/CIN:</label>
        <input type="text" id="nif_cin" name="nif_cin" value="<?php echo htmlspecialchars($autorisation['nif_cin']); ?>" required>

        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($autorisation['adresse']); ?>" required>

        <button type="submit">Modifier</button>
    </form>
    </div>
</body>
</html>

