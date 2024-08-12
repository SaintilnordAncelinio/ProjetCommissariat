<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Supposons que vous stockez le nom d'utilisateur dans la session lors de la connexion
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Nom d\'utilisateur'; // Valeur par défaut si non connecté

// Récupérer le nom de la page actuelle
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet Commissariat</title>
    <link rel="stylesheet" href="../css/styleHeader.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="../images/logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>"><a href="../Views/dashboard.php">Accueil</a></li>
                <li class="dropdown <?php echo in_array($current_page, ['enregistrer_prison.php', 'list_prison.php']) ? 'active' : ''; ?>">
                    <a href="#">Prison &#9660</a>
                    <ul class="dropdown-content">
                        <li><a href="../Views/enregistrer_prison.php">Enregistrer</a></li>
                        <li><a href="../Views/list_prison.php">Afficher</a></li>
                    </ul>
                </li>
                <li class="dropdown <?php echo in_array($current_page, ['enregistrer_detenu.php', 'list_detenu.php']) ? 'active' : ''; ?>">
                    <a href="#">Détenu &#9660</a>
                    <ul class="dropdown-content">
                        <li><a href="../Views/enregistrer_detenu.php">Enregistrer</a></li>
                        <li><a href="../Views/list_detenu.php">Afficher</a></li>
                    </ul>
                </li>
                <li class="dropdown <?php echo in_array($current_page, ['enregistrer_contravention.php', 'list_contravention.php']) ? 'active' : ''; ?>">
                    <a href="#">Contravention &#9660</a>
                    <ul class="dropdown-content">
                        <li><a href="../Views/enregistrer_contravention.php">Enregistrer</a></li>
                        <li><a href="../Views/list_contravention.php">Afficher</a></li>
                    </ul>
                </li>
                <li class="dropdown <?php echo in_array($current_page, ['enregistrer_autorisation.php', 'list_autorisation.php']) ? 'active' : ''; ?>">
                    <a href="#">Autorisation &#9660</a>
                    <ul class="dropdown-content">
                        <li><a href="../Views/enregistrer_autorisation.php">Enregistrer</a></li>
                        <li><a href="../Views/list_autorisation.php">Afficher</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div class="profile">
            <img src="../images/profil.png" alt="Profile">
            <span class="username"><?php echo htmlspecialchars($username); ?></span>
            <ul class="dropdown-content profile-menu">
                <li class="<?php echo $current_page == 'profil.php' ? 'active' : ''; ?>"><a href="../Views/profil.php"><i class="fas fa-user"></i> Profil</a></li>
                <li class="<?php echo $current_page == 'equipe.php' ? 'active' : ''; ?>"><a href="../Views/equipe.php"><i class="fas fa-users"></i> Équipe</a></li>
                <li><a href="../config/logout.php"><i class="fas fa-sign-out-alt"></i> Déconnecter</a></li>
            </ul>
        </div>
    </header>
</body>
</html>
