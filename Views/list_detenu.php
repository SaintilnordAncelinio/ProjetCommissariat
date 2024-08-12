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
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}


if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['code'])) {
    $detenuController->supprimerDetenu($_GET['code']);
    $_SESSION['message'] = "Déténu supprimé avec succès!";
    header('Location: list_detenu.php');
    exit();
}


$searchTerm = '';
$detenus = $detenuController->listerDetenus();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchTerm = trim($_POST['search']);
    if ($searchTerm !== '') {
        $detenus = array_filter($detenus, function($detenu) use ($searchTerm) {
            return stripos($detenu['nom'], $searchTerm) !== false || 
                   stripos($detenu['prenom'], $searchTerm) !== false ||
                   stripos($detenu['cin_ou_nif'], $searchTerm) !== false ||
                   stripos($detenu['adresse'], $searchTerm) !== false ||
                   stripos($detenu['code'], $searchTerm) !== false;
        });
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Détenus</title>
    <link rel="stylesheet" href="../css/styleListPrison.css">
</head>
<body>
    <div id="message" class="message">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <div class="titre">
        <h4>Liste des Détenus</h4>
        <hr>
    </div>
    
 
    <div class="recherche">
        <form id="search-form" action="list_detenu.php" method="post">
            <input type="text" id="search" name="search" placeholder="Rechercher..." value="<?php echo htmlspecialchars($searchTerm); ?>" autocomplete="off">
            <button type="submit">Rechercher</button>
        </form>
    </div>
    
 
    <div class="box">
        <table id="detenu-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>CIN</th>
                    <th>Sexe</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Infraction</th>
                    <th>Statut</th>
                    <th>Prison</th>
                    <th>Date d'Enregistrement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($detenus)): ?>
                    <?php foreach ($detenus as $detenu): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($detenu['code']); ?></td>
                            <td><?php echo htmlspecialchars($detenu['nom']); ?></td>
                            <td><?php echo htmlspecialchars($detenu['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($detenu['cin_ou_nif']); ?></td>
                            <td><?php echo htmlspecialchars($detenu['sexe']); ?></td>
                            <td><?php echo htmlspecialchars($detenu['adresse']); ?></td>
                            <td><?php echo htmlspecialchars($detenu['telephone']); ?></td>
                            <td><?php echo htmlspecialchars($detenu['infraction']); ?></td>
                            <td><?php echo htmlspecialchars($detenu['statut']); ?></td>
                            <td><?php echo htmlspecialchars($detenu['prison_nom']); ?></td>
                            <td><?php echo htmlspecialchars($detenu['date_enregistrement']); ?></td>
                            <td class="action-buttons">
                                <div class="edit-button">
                                    <a href="modifier_detenu.php?code=<?php echo urlencode($detenu['code']); ?>">Modifier</a>
                                </div>
                                <div class="delete-button">
                                    <a href="transferer_detenu.php?code=<?php echo urlencode($detenu['code']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir transférer ce détenu?');">Transférer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12">Aucun détenu trouvé.</td>
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
