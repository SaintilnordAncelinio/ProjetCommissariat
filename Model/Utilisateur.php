<?php
class Utilisateur {
    private $nom;
    private $prenom;
    private $username;
    private $email;
    private $telephone;
    private $motDePasse;
    private $pdo;

    public function __construct($nom, $prenom, $username, $email, $telephone, $motDePasse, $pdo) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->username = $username;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->motDePasse =$motDePasse; /*password_hash($motDePasse, PASSWORD_BCRYPT);*/
        $this->pdo = $pdo;
    }

    public function enregistrer() {
        $stmt = $this->pdo->prepare("INSERT INTO utilisateurs (nom, prenom, username, email, telephone, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$this->nom, $this->prenom, $this->username, $this->email, $this->telephone, $this->motDePasse]);
    }

    public static function authentifier($username, $motDePasse, $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = ?");
        $stmt->execute([$username]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
            return $utilisateur;
        }
        return false;
    }
}
?>
