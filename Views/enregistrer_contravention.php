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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = ''; 
    $nomChauffeur = $_POST['nom_chauffeur'];
    $numeroPermis = $_POST['numero_permis'];
    $numeroPlaque = $_POST['numero_plaque'];
    $lieuContravention = $_POST['lieu_contravention'];
    $numeroViolation = $_POST['numero_violation'];
    $article = $_POST['article'];
    $dateHeure = $_POST['date_heure'];
    $numeroAgent = $_POST['numero_agent'];
    $numeroMatricule = $_POST['numero_matricule'];

    $contraventionController->ajouterContravention($code, $nomChauffeur, $numeroPermis, $numeroPlaque, $lieuContravention, $numeroViolation, $article, $dateHeure, $numeroAgent, $numeroMatricule);
    $message = "Contravention enregistrée avec succès!";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer Contravention</title>
    <link rel="stylesheet" href="../css/styleEnregistrerPrison.css">
</head>
<body>
<?php if ($message): ?>
            <div id="message" class="message">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
    
    <div class="container">
        <form action="enregistrer_contravention.php" method="post">
        <h4>Enregistrer une nouvelle contravention</h4>
        <hr>
            
                <label for="nom_chauffeur">Nom du Chauffeur :</label>
                <input type="text" name="nom_chauffeur" required>
           
            
                <label for="numero_permis">Numéro de Permis :</label>
                <input type="text" name="numero_permis" required>
           
            
                <label for="numero_plaque">Numéro de Plaque :</label>
                <input type="text" name="numero_plaque" required>
            
            
                <label for="lieu_contravention">Lieu de la Contravention :</label>
                <input type="text" name="lieu_contravention" required>
           
            
                <label for="numero_violation">Numéro de Violation :</label>
                <input type="text" name="numero_violation" required>
          
            
                <label for="article">Article :</label>
                <input type="text" name="article" required>
           
            
                <label for="date_heure">Date et Heure :</label>
                <input type="datetime-local" name="date_heure" required>
           
            
                <label for="numero_agent">Numéro de l'Agent :</label>
                <input type="text" name="numero_agent" required>
            
                <label for="numero_matricule">Numéro de Matricule :</label>
                <input type="text" name="numero_matricule" required>
           
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
