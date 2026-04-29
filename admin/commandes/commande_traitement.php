<?php
require_once("../../config/db.php");

class Commande {

    // 🔹 Lister toutes les commandes
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

    // 🔹 Détails d'une commande
    function getDetails($commande_id) {
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "
        SELECT d.*, p.nom
        FROM commande_details d
        JOIN produits p ON d.produit_id = p.id
        WHERE d.commande_id = ?
        ";

        $stmt = $pdo->prepare($req);
        $stmt->execute([$commande_id]);

        return $stmt->fetchAll();
    }

    // 🔹 Récupérer une commande (infos complètes)
    function getCommande($id) {
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "SELECT * FROM commandes WHERE id = ?";
        $stmt = $pdo->prepare($req);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    // 🔹 Modifier status
    function updateStatus($id, $status) {
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "UPDATE commandes SET status=? WHERE id=?";
        $stmt = $pdo->prepare($req);
        $stmt->execute([$status, $id]);
    }

    // 🔹 Ajouter une commande
    function insertCommande($data) {
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "INSERT INTO commandes 
        (user_id, total, adresse, ville, region, tel, email, shipping_method, payment_method)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($req);
        $stmt->execute([
            $data['user_id'],
            $data['total'],
            $data['adresse'],
            $data['ville'],
            $data['region'],
            $data['tel'],
            $data['email'],
            $data['shipping_method'],
            $data['payment_method']
        ]);

        return $pdo->lastInsertId();
    }

    // 🔹 Ajouter détails commande
    function insertDetail($data) {
        $cnx = new \Connexion();
        $pdo = $cnx->CNXbase();

        $req = "INSERT INTO commande_details 
        (commande_id, produit_id, quantite, prix, subtotal, taille, couleur)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($req);
        $stmt->execute([
            $data['commande_id'],
            $data['produit_id'],
            $data['quantite'],
            $data['prix'],
            $data['subtotal'],
            $data['taille'],
            $data['couleur']
        ]);
    }
}
?>