<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}


require '../config/Database.php';
require '../Controllers/UtilisateurController.php';
include '../includes/header.php';

$pdo = Database::getConnect();
$userController = new UtilisateurController($pdo);


$username = $_SESSION['username'];
$user = $userController->getUserByUsername($username);


if (!$user) {
    echo "Utilisateur non trouvé!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de l'utilisateur</title>
    <link rel="stylesheet" href="../css/styleProfil.css">
</head>
<body>
   <div class="container">
       <h4>Profil de l'utilisateur</h4>
       <hr>
       
       <label for="username">Nom d'utilisateur:</label>
       <p id="username"><?php echo htmlspecialchars($user['username']); ?></p>

       <label for="nom">Nom:</label>
       <p id="nom"><?php echo htmlspecialchars($user['nom']); ?></p>

       <label for="prenom">Prénom:</label>
       <p id="prenom"><?php echo htmlspecialchars($user['prenom']); ?></p>

       <label for="email">Email:</label>
       <p id="email"><?php echo htmlspecialchars($user['email']); ?></p>

       <label for="telephone">Téléphone:</label>
       <p id="telephone"><?php echo htmlspecialchars($user['telephone']); ?></p>
       
    
   </div>
</body>
</html>
