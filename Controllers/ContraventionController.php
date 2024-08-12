<?php
class ContraventionController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function ajouterContravention($code, $nomChauffeur, $numeroPermis, $numeroPlaque, $lieuContravention, $numeroViolation, $article, $dateHeure, $numeroAgent, $numeroMatricule) {
        $contravention = new Contravention($this->pdo, $code, $nomChauffeur, $numeroPermis, $numeroPlaque, $lieuContravention, $numeroViolation, $article, $dateHeure, $numeroAgent, $numeroMatricule);
        $contravention->enregistrer();
    }

    public function listerContraventions() {
        return Contravention::afficherListe($this->pdo);
    }

    public function supprimerContravention($code) {
        $contravention = new Contravention($this->pdo, $code, '', '', '', '', '', '', '', '', '');
        $contravention->supprimer();
    }
}
?>
