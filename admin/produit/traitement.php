<?php
class produit
{
    // 🔹 Attributs
    public $nom;
    public $prix;
    public $description;
    public $image;
    public $categorie;
    public $style;
    public $stock;

    // 🔹 Ajouter produit
    function insertProduit()
    {
        require_once('../../config/db.php');
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "INSERT INTO produits 
        (nom, description, prix, image, categorie, style, stock) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($req);
        $stmt->execute([
            $this->nom,
            $this->description,
            $this->prix,
            $this->image,
            $this->categorie,
            $this->style,
            $this->stock
        ]);
    }

    // 🔹 Lister produits
    function listProduits()
    {
        require_once('../../config/db.php');
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        return $pdo->query("SELECT * FROM produits");
    }

    // 🔹 Récupérer un produit
    function getProduit($id)
    {
        require_once('../../config/db.php');
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "SELECT * FROM produits WHERE id = ?";
        $stmt = $pdo->prepare($req);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    // 🔹 Modifier produit
    function modifierProduit($id)
    {
        require_once('../../config/db.php');
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "UPDATE produits 
        SET nom=?, description=?, prix=?, image=?, categorie=?, style=?, stock=? 
        WHERE id=?";

        $stmt = $pdo->prepare($req);
        $stmt->execute([
            $this->nom,
            $this->description,
            $this->prix,
            $this->image,
            $this->categorie,
            $this->style,
            $this->stock,
            $id
        ]);
    }

    // 🔹 Supprimer produit
    function supprimerProduit($id)
    {
        require_once('../../config/db.php');
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "DELETE FROM produits WHERE id=?";
        $stmt = $pdo->prepare($req);
        $stmt->execute([$id]);
    }
}
?>