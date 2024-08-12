<?php
class Autorisation {
    private $pdo;
    private $code;
    private $marque;
    private $modele;
    private $serie;
    private $numeroMoteur;
    private $couleur;
    private $type;
    private $nombreCylindres;
    private $annee;
    private $puissance;
    private $numeroPlaque;
    private $nomProprietaire;
    private $nifCin;
    private $adresse;
    private $id_autorisation;

    // Constructeur
    public function __construct($pdo, $marque, $modele, $serie, $numeroMoteur, $couleur, $type, $nombreCylindres, $annee, $puissance, $numeroPlaque, $nomProprietaire, $nifCin, $adresse, $code = null, $id_autorisation = null) {
        $this->pdo = $pdo;
        $this->code = $code;
        $this->marque = $marque;
        $this->modele = $modele;
        $this->serie = $serie;
        $this->numeroMoteur = $numeroMoteur;
        $this->couleur = $couleur;
        $this->type = $type;
        $this->nombreCylindres = $nombreCylindres;
        $this->annee = $annee;
        $this->puissance = $puissance;
        $this->numeroPlaque = $numeroPlaque;
        $this->nomProprietaire = $nomProprietaire;
        $this->nifCin = $nifCin;
        $this->adresse = $adresse;
        $this->id_autorisation = $id_autorisation;
    }

    // Méthodes pour chaque opération (CRUD)
    public function enregistrer() {
        $dateEnregistrement = date('Y-m-d');
        $stmt = $this->pdo->prepare("INSERT INTO autorisations (marque, modele, serie, no_moteur, couleur, type, nombre_de_cylindre, annee, puissance, no_plaque, nom_proprietaire, nif_cin, adresse, date_enregistrement) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$this->marque, $this->modele, $this->serie, $this->numeroMoteur, $this->couleur, $this->type, $this->nombreCylindres, $this->annee, $this->puissance, $this->numeroPlaque, $this->nomProprietaire, $this->nifCin, $this->adresse, $dateEnregistrement]);

        // Récupérer l'ID généré
        $this->id_autorisation = $this->pdo->lastInsertId();

        $anneeEnregistrement = date('Y');
        $this->code = "AUT-{$this->id_autorisation}{$anneeEnregistrement}";

        // Mettre à jour l'enregistrement avec le code
        $stmt = $this->pdo->prepare("UPDATE autorisations SET code = ? WHERE id_autorisation = ?");
        $stmt->execute([$this->code, $this->id_autorisation]);
    }

    public static function afficherListe($pdo) {
        $stmt = $pdo->query("SELECT * FROM autorisations");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function rechercher($pdo, $code) {
         $stmt = $pdo->prepare("SELECT * FROM autorisations WHERE code = ?");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function mettreAJour() {
        $stmt = $this->pdo->prepare("UPDATE autorisations SET marque = ?, modele = ?, serie = ?, no_moteur = ?, couleur = ?, type = ?, nombre_de_cylindre = ?, annee = ?, puissance = ?, no_plaque = ?, nom_proprietaire = ?, nif_cin = ?, adresse = ? WHERE code = ?");
        $stmt->execute([$this->marque, $this->modele, $this->serie, $this->numeroMoteur, $this->couleur, $this->type, $this->nombreCylindres, $this->annee, $this->puissance, $this->numeroPlaque, $this->nomProprietaire, $this->nifCin, $this->adresse, $this->code]);
    }

    public function supprimer() {
        $stmt = $this->pdo->prepare("DELETE FROM autorisations WHERE code = ?");
        $stmt->execute([$this->code]);
    }
}
?>
