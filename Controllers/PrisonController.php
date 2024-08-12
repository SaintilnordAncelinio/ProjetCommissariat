<?php
class PrisonController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function ajouterPrison($nom, $adresse, $nombreCellule, $nombrePlaceParCellule) {
    
        $prison = new Prison(null, $nom, $adresse, $nombreCellule, $nombrePlaceParCellule, $this->pdo);
        $prison->enregistrer();
    }

    public function listerPrisons() {
        return Prison::afficherListe($this->pdo);
    }

    public function modifierPrison($code, $nom, $adresse, $nombreCellule, $nombrePlaceParCellule) {
        $prison = new Prison($code, $nom, $adresse, $nombreCellule, $nombrePlaceParCellule, $this->pdo);
        $prison->modifier();
    }

    public function supprimerPrison($code) {
        $prison = new Prison($code, '', '', 0, 0, $this->pdo);
        $prison->supprimer();
    }
}
?>
