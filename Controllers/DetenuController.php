<?php
class DetenuController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function ajouterDetenu($nom, $prenom, $cin, $sexe, $adresse, $telephone, $infraction, $statut, $idPrison) {
        $detenu = new Detenu($this->pdo, $nom, $prenom, $cin, $sexe, $adresse, $telephone, $infraction, $statut, $idPrison);
        $detenu->enregistrer();
    }

    public function listerDetenus() {
        $stmt = $this->pdo->query("
            SELECT d.*, p.nom AS prison_nom 
            FROM detenus d
            LEFT JOIN prisons p ON d.id_prison = p.id_prison
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifierStatut($code, $nouveauStatut) {
        $detenu = new Detenu($this->pdo, '', '', '', '', '', '', '', '', $code);
        return $detenu->modifierStatut($nouveauStatut);
    }
    
    
    
    
    
    public function transfererDetenu($code, $nouvellePrison) {
        $detenu = $this->getDetenuByCode($code);
        if ($detenu) {
            $detenuObj = new Detenu(
                $this->pdo, 
                $detenu['nom'], 
                $detenu['prenom'], 
                $detenu['cin_ou_nif'], 
                $detenu['sexe'], 
                $detenu['adresse'], 
                $detenu['telephone'], 
                $detenu['infraction'], 
                $detenu['statut'], 
                $nouvellePrison, 
                $detenu['code'], 
                $detenu['id_detenu']
            );
            $detenuObj->transferer($nouvellePrison);
        }
    }
    
 
    public function getDetenuByCode($code) {
        try {
            $sql = "SELECT d.*, p.nom AS prison_nom 
                    FROM detenus d 
                    JOIN prisons p ON d.id_prison = p.id_prison 
                    WHERE d.code = :code";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':code', $code, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    

    public function getListePrisons() {
        $stmt = $this->pdo->query("SELECT id_prison, nom FROM prisons");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
