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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $autorisationController->ajouterAutorisation($marque, $modele, $serie, $numeroMoteur, $couleur, $type, $nombreCylindres, $annee, $puissance, $numeroPlaque, $nomProprietaire, $nifCin, $adresse);

    $message = "Autorisation ajoutée avec succès.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer une Autorisation</title>
    <link rel="stylesheet" href="../css/styleEnregistrerPrison.css">
</head>
<body>
<?php if ($message): ?>
            <div id="message" class="message">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <div class="container">
   
    <form action="enregistrer_autorisation.php" method="POST">
    <h4>Enregistrer une Nouvelle Autorisation</h4>
    <hr>

        <label for="marque">Marque :</label>
        <input type="text" id="marque" name="marque" required>

        <label for="modele">Modèle :</label>
        <input type="text" id="modele" name="modele" required>

        <label for="serie">Série :</label>
        <input type="text" id="serie" name="serie" required>

        <label for="numero_moteur">Numéro de Moteur :</label>
        <input type="text" id="numero_moteur" name="numero_moteur" required>

        <label for="couleur">Couleur :</label>
        <input type="text" id="couleur" name="couleur" required>

        <label for="type">Type :</label>
        <input type="text" id="type" name="type" required>

        <label for="nombre_cylindres">Nombre de Cylindres :</label>
        <input type="number" id="nombre_cylindres" name="nombre_cylindres" required>

        <label for="annee">Année :</label>
        <input type="number" id="annee" name="annee" required>

        <label for="puissance">Puissance :</label>
        <input type="text" id="puissance" name="puissance" required>

        <label for="numero_plaque">Numéro de Plaque :</label>
        <input type="text" id="numero_plaque" name="numero_plaque" required>

        <label for="nom_proprietaire">Nom du Propriétaire :</label>
        <input type="text" id="nom_proprietaire" name="nom_proprietaire" required>

        <label for="nif_cin">NIF/CIN :</label>
        <input type="text" id="nif_cin" name="nif_cin" required>

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" required>

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
