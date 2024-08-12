<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
require '../config/Database.php';
require '../model/Prison.php';
require '../controllers/PrisonController.php';
include '../includes/header.php';

$pdo = Database::getConnect();
$prisonController = new PrisonController($pdo);

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Gestion de la suppression
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['code'])) {
    $prisonController->supprimerPrison($_GET['code']);
    $_SESSION['message'] = "Prison supprimée avec succès!";
    header('Location: list_prison.php');
    exit();
}

// Gestion de la recherche
$searchTerm = '';
$prisons = $prisonController->listerPrisons();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchTerm = trim($_POST['search']);
    if ($searchTerm !== '') {
        $prisons = array_filter($prisons, function($prison) use ($searchTerm) {
            return stripos($prison['nom'], $searchTerm) !== false || 
                   stripos($prison['adresse'], $searchTerm) !== false ||
                   stripos($prison['code'],$searchTerm) !==false;
        });
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Prisons</title>
    <link rel="stylesheet" href="../css/styleListPrison.css">
</head>
<body>
    <div id="message" class="message">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <div class="titre">
    <h4>Liste des Prisons</h4>
    <hr>
    </div>
    
    <!-- Formulaire de recherche -->
    <div class="recherche">
        <form id="search-form" action="list_prison.php" method="post">
            <input type="text" id="search" name="search" placeholder="Rechercher..." value="<?php echo htmlspecialchars($searchTerm); ?>" autocomplete="off">
            <button type="submit">Rechercher</button>
        </form>
    </div>
    
    <!-- Conteneur du tableau -->
    <div class="box">
        <table id="prison-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Adresse</th>
                    <th>Nombre de Cellules</th>
                    <th>Nombre de Places par Cellule</th>
                    <th>Date d'Enregistrement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($prisons)): ?>
                    <?php foreach ($prisons as $prison): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($prison['code']); ?></td>
                            <td><?php echo htmlspecialchars($prison['nom']); ?></td>
                            <td><?php echo htmlspecialchars($prison['adresse']); ?></td>
                            <td><?php echo htmlspecialchars($prison['nombre_de_cellule']); ?></td>
                            <td><?php echo htmlspecialchars($prison['nombre_de_place_par_cellule']); ?></td>
                            <td><?php echo htmlspecialchars($prison['date_enregistrement']); ?></td>
                            <td class="action-buttons">
                                <div class="edit-button">
                                <a href="modifier_prison.php?code=<?php echo urlencode($prison['code']); ?>">Modifier</a>
                                </div>
                                <div class="delete-button">
                                <a href="list_prison.php?action=delete&code=<?php echo urlencode($prison['code']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette prison?');">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Aucune prison trouvée.</td>
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
