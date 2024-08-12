<?php
class Contravention {
    private $pdo;
    private $code;
    private $nomChauffeur;
    private $numeroPermis;
    private $numeroPlaque;
    private $lieuContravention;
    private $numeroViolation;
    private $article;
    private $dateHeure;
    private $numeroAgent;
    private $numeroMatricule;

  
    public function __construct($pdo, $code = null, $nomChauffeur = '', $numeroPermis = '', $numeroPlaque = '', $lieuContravention = '', $numeroViolation = '', $article = '', $dateHeure = '', $numeroAgent = '', $numeroMatricule = '') {
        $this->pdo = $pdo;
        $this->code = $code;
        $this->nomChauffeur = $nomChauffeur;
        $this->numeroPermis = $numeroPermis;
        $this->numeroPlaque = $numeroPlaque;
        $this->lieuContravention = $lieuContravention;
        $this->numeroViolation = $numeroViolation;
        $this->article = $article;
        $this->dateHeure = $dateHeure;
        $this->numeroAgent = $numeroAgent;
        $this->numeroMatricule = $numeroMatricule;
    }

   
    public function enregistrer() {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("INSERT INTO circulation (nom_chauffeur, no_permis, no_plaque, lieu_contravention, no_violation, article, date_heure, no_agent, no_matricule) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$this->nomChauffeur, $this->numeroPermis, $this->numeroPlaque, $this->lieuContravention, $this->numeroViolation, $this->article, $this->dateHeure, $this->numeroAgent, $this->numeroMatricule]);

          
            $idCirculation = $this->pdo->lastInsertId();

           
            $anneeEnregistrement = date('Y');
            $this->code = "CTN-{$idCirculation}{$anneeEnregistrement}";

           
            $stmt = $this->pdo->prepare("UPDATE circulation SET code = ? WHERE id_circulation = ?");
            $stmt->execute([$this->code, $idCirculation]);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    
    public static function afficherListe($pdo) {
        $stmt = $pdo->query("SELECT * FROM circulation");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public static function rechercher($pdo, $code) {
        $stmt = $pdo->prepare("SELECT * FROM circulation WHERE code = ?");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function supprimer() {
        $stmt = $this->pdo->prepare("DELETE FROM circulation WHERE code = ?");
        $stmt->execute([$this->code]);
    }

    
    public function imprimer() {
        
    }
    public function mettreAJour() {
        $stmt = $this->pdo->prepare("UPDATE circulation SET nom_chauffeur = ?, no_permis = ?, no_plaque = ?, lieu_contravention = ?, no_violation = ?, article = ?, date_heure = ?, no_agent = ?, no_matricule = ? WHERE code = ?");
        $stmt->execute([$this->nomChauffeur, $this->numeroPermis, $this->numeroPlaque, $this->lieuContravention, $this->numeroViolation, $this->article, $this->dateHeure, $this->numeroAgent, $this->numeroMatricule, $this->code]);
    }
}
?>
