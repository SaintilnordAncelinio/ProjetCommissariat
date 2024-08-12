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

// Gestion de la suppression
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['code'])) {
    $autorisationController->supprimerAutorisation($_GET['code']);
    $_SESSION['message'] = "Autorisation supprimée avec succès!";
    header('Location: list_autorisation.php');
    exit();
}

// Gestion de la recherche
$searchTerm = '';
$autorisationList = $autorisationController->listerAutorisation();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchTerm = trim($_POST['search']);
    if ($searchTerm !== '') {
        $autorisationList = array_filter($autorisationList, function($autorisation) use ($searchTerm) {
            return stripos($autorisation['code'], $searchTerm) !== false || 
                   stripos($autorisation['marque'], $searchTerm) !== false ||
                   stripos($autorisation['modele'], $searchTerm) !== false;
        });
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Autorisations</title>
    <link rel="stylesheet" href="../css/styleListAutorisation.css">
</head>
<body>
    <div id="message" class="message">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <div class="titre">
    <h4>Liste des Autorisations</h4>
    <hr>
    </div>
    
    <!-- Formulaire de recherche -->
    <div class="recherche">
        <form id="search-form" action="list_autorisation.php" method="post">
            <input type="text" id="search" name="search" placeholder="Rechercher..." value="<?php echo htmlspecialchars($searchTerm); ?>" autocomplete="off">
            <button type="submit">Rechercher</button>
        </form>
    </div>
    
    <!-- Conteneur du tableau -->
    <div class="box">
        <table id="autorisation-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Série</th>
                    <th>No. de Moteur</th>
                    <th>Couleur</th>
                    <th>Type</th>
                    <th>Nombre de Cylindres</th>
                    <th>Année</th>
                    <th>Puissance</th>
                    <th>No. de Plaque</th>
                    <th>Nom du Propriétaire</th>
                    <th>NIF/CIN</th>
                    <th>Adresse</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($autorisationList)): ?>
                    <?php foreach ($autorisationList as $autorisation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($autorisation['code']); ?></td>
                            <td><?php echo htmlspecialchars($autorisation['marque']); ?></td>
                            <td><?php echo htmlspecialchars($autorisation['modele']); ?></td>
                            <td><?php echo htmlspecialchars($autorisation['serie']); ?></td>
                            <td><?php echo htmlspecialchars($autorisation['no_moteur']); ?></td>
                            <td><?php echo htmlspecialchars($autorisation['couleur']); ?></td>
                            <td><?php echo htmlspecialchars($autorisation['type']); ?></td>
                            <td><?php echo htmlspecialchars($autorisation['nombre_de_cylindre']); ?></td>
                            <td><?php echo htmlspecialchars($autorisation['annee']); ?></td>
                            <td><?php echo htmlspecialchars($autorisation['puissance']); ?></td>
                            <td><?php echo htmlspecialchars($autorisation['no_plaque']); ?></td>
                            <td><?php echo htmlspecialchars($autorisation['nom_proprietaire']); ?></td>
                            <td><?php echo htmlspecialchars($autorisation['nif_cin']); ?></td>
                            <td><?php echo htmlspecialchars($autorisation['adresse']); ?></td>
                            <td class="action-buttons">
                                <div class="edit-button">
                                <a href="modifier_autorisation.php?code=<?php echo urlencode($autorisation['code']); ?>">Modifier</a>
                                </div>
                                <div class="delete-button">
                                <a href="list_autorisation.php?action=delete&code=<?php echo urlencode($autorisation['code']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette autorisation?');">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="15">Aucune autorisation trouvée.</td>
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
                }, 5000); 
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
