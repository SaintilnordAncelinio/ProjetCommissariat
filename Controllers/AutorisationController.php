<?php
class AutorisationController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function ajouterAutorisation($marque, $modele, $serie, $numeroMoteur, $couleur, $type, $nombreCylindres, $annee, $puissance, $numeroPlaque, $nomProprietaire, $nifCin, $adresse) {
        $autorisation = new Autorisation($this->pdo, $marque, $modele, $serie, $numeroMoteur, $couleur, $type, $nombreCylindres, $annee, $puissance, $numeroPlaque, $nomProprietaire, $nifCin, $adresse);
        $autorisation->enregistrer();
    }

    public function listerAutorisation() {
        return Autorisation::afficherListe($this->pdo);
    }

    public function supprimerAutorisation($code) {
        $autorisation = new Autorisation($this->pdo, '', '', '', '', '', '', 0, 0, '', '', '', '','', $code);
        $autorisation->supprimer();
    }
    
    

    public function modifierAutorisation($code, $marque, $modele, $serie, $numeroMoteur, $couleur, $type, $nombreCylindres, $annee, $puissance, $numeroPlaque, $nomProprietaire, $nifCin, $adresse) {
        $autorisation = new Autorisation($this->pdo, $marque, $modele, $serie, $numeroMoteur, $couleur, $type, $nombreCylindres, $annee, $puissance, $numeroPlaque, $nomProprietaire, $nifCin, $adresse, $code);
        $autorisation->mettreAJour();
    }
}
?>
