<?php
class Detenu {
    private $pdo;
    private $code;
    private $nom;
    private $prenom;
    private $cin;
    private $sexe;
    private $adresse;
    private $telephone;
    private $infraction;
    private $statut;
    private $id_prison;
    private $id_detenu;


    public function __construct($pdo, $nom, $prenom, $cin, $sexe, $adresse, $telephone, $infraction, $statut, $id_prison, $code = null, $id_detenu = null) {
        $this->pdo = $pdo;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->cin = $cin;
        $this->sexe = $sexe;
        $this->adresse = $adresse;
        $this->telephone = $telephone;
        $this->infraction = $infraction;
        $this->statut = $statut;
        $this->id_prison = $id_prison;
        $this->code = $code;
        $this->id_detenu = $id_detenu;
    }
    

   
    public function enregistrer() {
        $dateEnregistrement = date('Y-m-d');

        $stmt = $this->pdo->prepare("INSERT INTO detenus (nom, prenom, cin_ou_nif, sexe, adresse, telephone, infraction, statut, id_prison, date_enregistrement) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$this->nom, $this->prenom, $this->cin, $this->sexe, $this->adresse, $this->telephone, $this->infraction, $this->statut, $this->id_prison, $dateEnregistrement]);

        
        $this->id_detenu = $this->pdo->lastInsertId();

        $anneeEnregistrement = date('Y');
        $this->code = "DT-{$this->id_detenu}{$anneeEnregistrement}";

       
        $stmt = $this->pdo->prepare("UPDATE detenus SET code = ? WHERE id_detenu = ?");
        $stmt->execute([$this->code, $this->id_detenu]);
    }

    public static function afficherListe($pdo) {
        $stmt = $pdo->query("SELECT * FROM detenus");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifierStatut($nouveauStatut) {
        $stmt = $this->pdo->prepare("UPDATE detenus SET statut = ? WHERE code = ?");
        $stmt->execute([$nouveauStatut, $this->code]);
    }
    
    
    
    public function transferer($nouvellePrison) {

        $stmt = $this->pdo->prepare("UPDATE detenus SET id_prison = ? WHERE code = ?");
        $stmt->execute([$nouvellePrison, $this->code]);
    }
    
    
}
?>
