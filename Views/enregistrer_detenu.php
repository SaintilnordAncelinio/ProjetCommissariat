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

$message = '';
$prisons = $detenuController->getListePrisons();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $cin = $_POST['cin'];
    $sexe = $_POST['sexe'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $infraction = $_POST['infraction'];
    $statut = $_POST['statut'];
    $idPrison = $_POST['id_prison'];

   
    if (empty($nom) || empty($prenom) || empty($cin) || empty($sexe) || empty($adresse) || empty($telephone) || empty($infraction) || empty($statut)) {
        $message = 'Tous les champs doivent être remplis.';
    } else {
        
        $detenuController->ajouterDetenu( $nom, $prenom, $cin, $sexe, $adresse, $telephone, $infraction, $statut,$idPrison);
        $message = 'Détenu enregistré avec succès!';
        
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer un Détenu</title>
    <link rel="stylesheet" href="../css/styleEnregistrerPrison.css">
</head>
<body>
    <?php if ($message): ?>
        <div id="message" class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <div class="container">
    <form action="enregistrer_detenu.php" method="post">
    <h4>Enregistrer un Détenu</h4>
    <hr>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="cin">CIN/NIF :</label>
        <input type="text" id="cin" name="cin" required>

        <label for="sexe">Sexe :</label>
        <select id="sexe" name="sexe" required>
        <option value="">Sélectionnez sexe</option>
            <option value="Masculin">Masculin</option>
            <option value="Féminin">Féminin</option>
        </select>

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" required>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" required>

        <label for="infraction">Infraction :</label>
        <select id="infraction" name="infraction" required>
        <option value="">Sélectionnez infraction</option>
            <option value="Vol">Vol</option>
            <option value="Assaut">Assaut</option>
            <option value="Homicide">Homicide</option>
            <option value="Fraude">Fraude</option>
            <option value="Délit sexuel">Délit sexuel</option>
            <option value="Drogues">Drogues</option>
            <option value="Infractions routières">Infractions routières</option>
            <option value="Terrorisme">Terrorisme</option>
            <option value="Autres">Autres</option>
        </select>

        <label for="statut">Statut :</label>
        <select id="statut" name="statut" required>
        <option value="">Sélectionnez Staut</option>
            <option value="En détention">En détention</option>
            <option value="Libéré conditionnellement">Libéré conditionnellement</option>
            <option value="Transféré">Transféré</option>
            <option value="Évadé">Évadé</option>
            <option value="Décédé">Décédé</option>
            <option value="En attente de jugement">En attente de jugement</option>
            <option value="Autres">Autres</option>
        </select>
        

        <label for="id_prison">Prison :</label>
        <select id="id_prison" name="id_prison" required>
            <option value="">Sélectionnez une prison</option>
            <?php foreach ($prisons as $prison): ?>
                <option value="<?php echo htmlspecialchars($prison['id_prison']); ?>">
                    <?php echo htmlspecialchars($prison['nom']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Enregistrer</button>
    </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var message = document.getElementById('message');
            if (message && message.textContent.trim() !== '') {
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
