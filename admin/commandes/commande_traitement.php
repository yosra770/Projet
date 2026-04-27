<?php
require_once("../../config/db.php");

class Commande {

    function listCommandes() {
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "
        SELECT c.*, u.nom, u.prenom
        FROM commandes c
        JOIN utilisateur u ON c.user_id = u.id
        ORDER BY c.date_commande DESC
        ";

        return $pdo->query($req);
    }

    function getDetails($commande_id) {
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "
        SELECT d.*, p.nom, p.prix
        FROM commande_details d
        JOIN produits p ON d.produit_id = p.id
        WHERE d.commande_id = $commande_id
        ";

        return $pdo->query($req);
    }
}
?>