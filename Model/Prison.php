<?php
class Prison {
    private $id_prison;
    private $code;
    private $nom;
    private $adresse;
    private $nombreCellule;
    private $nombrePlaceParCellule;
    private $pdo;

   
    public function __construct($code, $nom, $adresse, $nombreCellule, $nombrePlaceParCellule, $pdo) {
        $this->code = $code;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->nombreCellule = $nombreCellule;
        $this->nombrePlaceParCellule = $nombrePlaceParCellule;
        $this->pdo = $pdo;
    }

    public function enregistrer() {
        $dateEnregistrement = date('Y-m-d H:i:s');

   
        $stmt = $this->pdo->prepare("INSERT INTO prisons (nom, adresse, nombre_de_cellule, nombre_de_place_par_cellule, date_enregistrement) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$this->nom, $this->adresse, $this->nombreCellule, $this->nombrePlaceParCellule, $dateEnregistrement]);

       
        $this->id_prison = $this->pdo->lastInsertId();

   
        $anneeEnregistrement = date('Y');
        $this->code = "PR-{$this->id_prison}{$anneeEnregistrement}";

      
        $stmt = $this->pdo->prepare("UPDATE prisons SET code = ? WHERE id_prison = ?");
        $stmt->execute([$this->code, $this->id_prison]);
    }

    public static function afficherListe($pdo) {
        $stmt = $pdo->query("SELECT * FROM prisons");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifier() {
        $stmt = $this->pdo->prepare("UPDATE prisons SET nom = ?, adresse = ?, nombre_de_cellule = ?, nombre_de_place_par_cellule = ? WHERE code = ?");
        $stmt->execute([$this->nom, $this->adresse, $this->nombreCellule, $this->nombrePlaceParCellule, $this->code]);
    }

    public function supprimer() {
        $stmt = $this->pdo->prepare("DELETE FROM prisons WHERE code = ?");
        $stmt->execute([$this->code]);
    }
}
?>