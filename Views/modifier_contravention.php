<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
require '../config/Database.php';
require '../model/Contravention.php';
require '../controllers/ContraventionController.php';
include '../includes/header.php';

$pdo = Database::getConnect();
$contraventionController = new ContraventionController($pdo);

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Récupérer les données de la contravention à modifier
$contravention = null;
if (isset($_GET['code'])) {
    $contravention = Contravention::rechercher($pdo, $_GET['code']);
    if (!$contravention) {
        $_SESSION['message'] = "Contravention non trouvée.";
        header('Location: list_contravention.php');
        exit();
    }
}

// Mise à jour de la contravention
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $nomChauffeur = $_POST['nom_chauffeur'];
    $numeroPermis = $_POST['no_permis'];
    $numeroPlaque = $_POST['no_plaque'];
    $lieuContravention = $_POST['lieu_contravention'];
    $numeroViolation = $_POST['no_violation'];
    $article = $_POST['article'];
    $dateHeure = $_POST['date_heure'];
    $numeroAgent = $_POST['no_agent'];
    $numeroMatricule = $_POST['no_matricule'];

    $contravention = new Contravention($pdo, $code, $nomChauffeur, $numeroPermis, $numeroPlaque, $lieuContravention, $numeroViolation, $article, $dateHeure, $numeroAgent, $numeroMatricule);
    $contravention->mettreAJour();
    
    $_SESSION['message'] = "Contravention mise à jour avec succès.";
    header('Location: list_contravention.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Contravention</title>
    <link rel="stylesheet" href="../css/styleEnregistrerPrison.css">
</head>
<body>
    <div id="message" class="message">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <div class="titre">
        
    </div>

    <div class="container">
        <form action="modifier_contravention.php?code=<?php echo htmlspecialchars($contravention['code']); ?>" method="post">
        <h4>Modifier Contravention</h4>
        <hr>
        <input type="hidden" name="code" value="<?php echo htmlspecialchars($contravention['code']); ?>">
            
            <label for="nom_chauffeur">Nom du Chauffeur</label>
            <input type="text" id="nom_chauffeur" name="nom_chauffeur" value="<?php echo htmlspecialchars($contravention['nom_chauffeur']); ?>" required>
            
            <label for="no_permis">Numéro de Permis</label>
            <input type="text" id="no_permis" name="no_permis" value="<?php echo htmlspecialchars($contravention['no_permis']); ?>" required>
            
            <label for="no_plaque">Numéro de Plaque</label>
            <input type="text" id="no_plaque" name="no_plaque" value="<?php echo htmlspecialchars($contravention['no_plaque']); ?>" required>
            
            <label for="lieu_contravention">Lieu de la Contravention</label>
            <input type="text" id="lieu_contravention" name="lieu_contravention" value="<?php echo htmlspecialchars($contravention['lieu_contravention']); ?>" required>
            
            <label for="no_violation">Numéro de Violation</label>
            <input type="text" id="no_violation" name="no_violation" value="<?php echo htmlspecialchars($contravention['no_violation']); ?>" required>
            
            <label for="article">Article</label>
            <input type="text" id="article" name="article" value="<?php echo htmlspecialchars($contravention['article']); ?>" required>
            
            <label for="date_heure">Date et Heure</label>
            <input type="datetime-local" id="date_heure" name="date_heure" value="<?php echo htmlspecialchars($contravention['date_heure']); ?>" required>
            
            <label for="no_agent">Numéro de l'Agent</label>
            <input type="text" id="no_agent" name="no_agent" value="<?php echo htmlspecialchars($contravention['no_agent']); ?>" required>
            
            <label for="no_matricule">Numéro de Matricule</label>
            <input type="text" id="no_matricule" name="no_matricule" value="<?php echo htmlspecialchars($contravention['no_matricule']); ?>" required>

            <button type="submit">Modifier</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var message = document.getElementById('message');
            if (message.textContent.trim() !== '') {
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
