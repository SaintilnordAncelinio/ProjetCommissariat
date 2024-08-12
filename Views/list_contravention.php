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


if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['code'])) {
    $contraventionController->supprimerContravention($_GET['code']);
    $_SESSION['message'] = "Contravention supprimée avec succès!";
    header('Location: list_contravention.php');
    exit();
}


$searchTerm = '';
$contraventions = $contraventionController->listerContraventions();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchTerm = trim($_POST['search']);
    if ($searchTerm !== '') {
        $contraventions = array_filter($contraventions, function($contravention) use ($searchTerm) {
            return stripos($contravention['nom_chauffeur'], $searchTerm) !== false || 
                   stripos($contravention['no_plaque'], $searchTerm) !== false ||
                   stripos($contravention['code'], $searchTerm) !== false;
        });
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Contraventions</title>
    <link rel="stylesheet" href="../css/styleListPrison.css">
</head>
<body>
    <div id="message" class="message">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <div class="titre">
        <h4>Liste des Contraventions</h4>
        <hr>
    </div>
    
   
    <div class="recherche">
        <form id="search-form" action="list_contravention.php" method="post">
            <input type="text" id="search" name="search" placeholder="Rechercher..." value="<?php echo htmlspecialchars($searchTerm); ?>" autocomplete="off">
            <button type="submit">Rechercher</button>
        </form>
    </div>
    
    
    <div class="box">
        <table id="contravention-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom du Chauffeur</th>
                    <th>No de Permis</th>
                    <th>Numéro de Plaque</th>
                    <th>Lieu de Contravention</th>
                    <th>No de Violation</th>
                    <th>Article</th>
                    <th>Date et Heure</th>
                    <th>No de l'Agent</th>
                    <th>Numéro de Matricule</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($contraventions)): ?>
                    <?php foreach ($contraventions as $contravention): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contravention['code']); ?></td>
                            <td><?php echo htmlspecialchars($contravention['nom_chauffeur']); ?></td>
                            <td><?php echo htmlspecialchars($contravention['no_permis']); ?></td>
                            <td><?php echo htmlspecialchars($contravention['no_plaque']); ?></td>
                            <td><?php echo htmlspecialchars($contravention['lieu_contravention']); ?></td>
                            <td><?php echo htmlspecialchars($contravention['no_violation']); ?></td>
                            <td><?php echo htmlspecialchars($contravention['article']); ?></td>
                            <td><?php echo htmlspecialchars($contravention['date_heure']); ?></td>
                            <td><?php echo htmlspecialchars($contravention['no_agent']); ?></td>
                            <td><?php echo htmlspecialchars($contravention['no_matricule']); ?></td>
                            <td class="action-buttons">
                                <div class="edit-button">
                                    <a href="modifier_contravention.php?code=<?php echo urlencode($contravention['code']); ?>">Modifier</a>
                                </div>
                                <div class="delete-button">
                                    <a href="list_contravention.php?action=delete&code=<?php echo urlencode($contravention['code']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette contravention?');">Supprimer</a>
                                </div>
                                <div class="print-button">
                                    <a href="imprimer_contravention.php?code=<?php echo urlencode($contravention['code']); ?>">Imprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11">Aucune contravention trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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

            var searchInput = document.getElementById('search');
            var searchForm = document.getElementById('search-form');

            searchInput.addEventListener('input', function() {
                if (searchInput.value.trim() === '') {
                    searchForm.submit();
                }
            });
        });
    </script>
</body>
</html>
