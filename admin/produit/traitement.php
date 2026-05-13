<?php

class produit
{
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

        return $pdo->lastInsertId();
    }
    // 🔹 Modifier produit 
    function modifierProduit($id) 
    { require_once('../../config/db.php'); 
    $cnx = new \Connexion();
     $pdo = $cnx->CNXbase();
      $req = "UPDATE produits SET nom=?, description=?,
       prix=?, image=?, categorie=?, style=?, stock=? WHERE id=?"; 
      $stmt = $pdo->prepare($req); $stmt->execute([ $this->nom, $this->description, $this->prix, $this->image, $this->categorie, $this->style, $this->stock, $id ]); }

    // 🔹 Ajouter variante
    function insertVariante($produit_id, $taille, $couleur, $stock)
    {
        require_once('../../config/db.php');

        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "INSERT INTO produit_variantes
        (produit_id, taille, couleur, stock)
        VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($req);

        $stmt->execute([
            $produit_id,
            $taille,
            $couleur,
            $stock
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

    // 🔹 Récupérer produit
    function getProduit($id)
    {
        require_once('../../config/db.php');

        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "SELECT * FROM produits WHERE id=?";

        $stmt = $pdo->prepare($req);

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    // 🔹 Variantes produit
    function getVariantes($produit_id)
    {
        require_once('../../config/db.php');

        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "SELECT * FROM produit_variantes
                WHERE produit_id=?";

        $stmt = $pdo->prepare($req);

        $stmt->execute([$produit_id]);

        return $stmt->fetchAll();
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

    
    function supprimerVariantes($produit_id)
{
    require_once('../../config/db.php');

    $cnx = new \Connexion();
    $pdo = $cnx->CNXbase();

    $req = "DELETE FROM produit_variantes
            WHERE produit_id=?";

    $stmt = $pdo->prepare($req);

    $stmt->execute([$produit_id]);
}

}
?>