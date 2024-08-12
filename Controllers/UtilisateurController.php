<?php
include __DIR__ . '/../model/Utilisateur.php';


class UtilisateurController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function ajouterUtilisateur($nom, $prenom, $username, $email, $telephone, $motDePasse) {
        $utilisateur = new Utilisateur($nom, $prenom, $username, $email, $telephone, $motDePasse, $this->pdo);
        $utilisateur->enregistrer();
    }

    public function authentifierUtilisateur($username, $motDePasse) {
        return Utilisateur::authentifier($username, $motDePasse, $this->pdo);
    }
    public function getUserByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
