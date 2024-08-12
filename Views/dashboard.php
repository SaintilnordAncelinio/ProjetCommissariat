<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

include '../config/Database.php';
 include '../includes/header.php';
$pdo = Database::getConnect();

$queries = [
    'prisons' => 'SELECT COUNT(*) AS count FROM prisons',
    'detenus' => 'SELECT COUNT(*) AS count FROM detenus',
    'circulation' => 'SELECT COUNT(*) AS count FROM circulation',
    'autorisations' => 'SELECT COUNT(*) AS count FROM autorisations',
    /* 'utilisateurs' => 'SELECT COUNT(*) AS count FROM utilisateurs'  */
];
$counts = [];

foreach ($queries as $key => $query) {
    $stmt = $pdo->query($query);
    $counts[$key] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/styleDashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="menu">
            <a href="list_prison.php" class="menu-item">
                <i class="fas fa-building"></i>
                <span>Prisons Enregistrées </span>
                <span>Quantité : <?php echo $counts['prisons']; ?></span>
            </a>
            <a href="list_detenu.php" class="menu-item">
                <i class="fas fa-user-injured"></i>
                <span>Détenus Enregistrés </span>
                <span>Quantité : <?php echo $counts['detenus']; ?></span>
            </a>
            <a href="list_contravention.php" class="menu-item">
                <i class="fas fa-car"></i>
                <span>Contravention Enregistrées</span>
                <span>Quantité : <?php echo $counts['circulation']; ?></span>
            </a>
            <a href="list_autorisation.php" class="menu-item">
                <i class="fas fa-id-card"></i>
                <span>Autorisations Enregistrées</span>
                <span>Quantité  : <?php echo $counts['autorisations']; ?></span>
            </a>
        </div>

    </div>
</body>
</html>
