<?php
class produit
{
    // 🔹 Attributs
    public $nom;
    public $prix;
    public $description;
    public $image;

    // 🔹 Ajouter produit
    function insertProduit()
    {
        require_once('../../config/db.php');
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "INSERT INTO produits (nom, description, prix, image) 
                VALUES ('$this->nom', '$this->description', '$this->prix', '$this->image')";

        $pdo->exec($req) or print_r($pdo->errorInfo());
    }

    // 🔹 Lister produits
    function listProduits()
    {
        require_once('../../config/db.php');
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "SELECT * FROM produits";
        $res = $pdo->query($req) or print_r($pdo->errorInfo());

        return $res;
    }

    // 🔹 Récupérer un produit
    function getProduit($id)
    {
        require_once('../../config/db.php');
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "SELECT * FROM produits WHERE id='$id'";
        $res = $pdo->query($req) or print_r($pdo->errorInfo());

        return $res;
    }

    // 🔹 Modifier produit
    function modifierProduit($id)
    {
        require_once('../../config/db.php');
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "UPDATE produits 
                SET nom='$this->nom', description='$this->description', prix='$this->prix' 
                WHERE id='$id'";

        $pdo->exec($req) or print_r($pdo->errorInfo());
    }

    // 🔹 Supprimer produit
    function supprimerProduit($id)
    {
        require_once('../../config/db.php');
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "DELETE FROM produits WHERE id='$id'";
        $pdo->exec($req);
    }
}
?>