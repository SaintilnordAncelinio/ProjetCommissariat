<?php
session_start();

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

include 'config/Database.php';
include 'controllers/UtilisateurController.php';

$pdo = Database::getConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        
        $username = $_POST['username'];
        $motDePasse = $_POST['motDePasse'];

        $utilisateurController = new UtilisateurController($pdo);
        $utilisateur = $utilisateurController->authentifierUtilisateur($username, $motDePasse);

        if ($utilisateur) {
           
            $_SESSION['username'] = $username;
            header('Location: Views/dashboard.php'); 
            exit();
        } else {
            $_SESSION['message'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
            header('Location: index.php');
            exit();
        }
    } elseif (isset($_POST['register'])) {
       
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $motDePasse = $_POST['motDePasse'];

        $utilisateurController = new UtilisateurController($pdo);
        $utilisateurController->ajouterUtilisateur($nom, $prenom, $username, $email, $telephone, $motDePasse);

        $_SESSION['message'] = 'Inscription réussie. Vous pouvez maintenant vous connecter.';
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion / Inscription</title>
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/styleLogin.css">
</head>
<body>
    <div class="container">

       
        <form class="form-container active" method="POST" id="loginForm">
            <div class="bwat1">
            <h2>Connexion</h2>
            </div>
            <div class="kont">
            <div class="form-group">
                <i class="fa fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required>
            </div>
            <div class="form-group">
                <i class="fa fa-lock"></i>
                <input type="password" id="motDePasse" name="motDePasse" placeholder="Mot de passe" required>
            </div>
            <button type="submit" name="login" class="btn">Se connecter</button>
            <?php if (!empty($message)) : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
            <div class="toggle">
                <p>Vous n'avez pas de compte?</p>
                <p><a href="#" onclick="toggleForms()">S'inscrire</a></p>
                </div>
            </div>
        </form>

        <form class="form-container" method="POST" id="registerForm">
            <div class="bwat1">
            <h2>Inscription</h2>
            </div>
            <div class="kont">
            <div class="form-group">
                <i class="fa fa-user"></i>
                <input type="text" id="nom" name="nom" placeholder="Nom" required>
            </div>
            <div class="form-group">
                <i class="fa fa-user"></i>
                <input type="text" id="prenom" name="prenom" placeholder="Prénom" required>
            </div>
            <div class="form-group">
                <i class="fa fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required>
            </div>
            <div class="form-group">
                <i class="fa fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <i class="fa fa-phone"></i>
                <input type="tel" id="telephone" name="telephone" placeholder="Téléphone" required>
            </div>
            <div class="form-group">
                <i class="fa fa-lock"></i>
                <input type="password" id="motDePasse" name="motDePasse" placeholder="Mot de passe" required>
            </div>
            <button type="submit" name="register" class="btn">S'inscrire</button>
            <div class="toggle">
                <p>Déjà inscrit? </p>
                    <p><a href="#" onclick="toggleForms()">Se connecter</a></p>
                
            </div>
            </div>
        </form>
    </div>

    <script>
        function toggleForms() {
            var loginForm = document.getElementById('loginForm');
            var registerForm = document.getElementById('registerForm');
            if (loginForm.classList.contains('active')) {
                loginForm.classList.remove('active');
                registerForm.classList.add('active');
            } else {
                loginForm.classList.add('active');
                registerForm.classList.remove('active');
            }
        }
    </script>
</body>
</html>
