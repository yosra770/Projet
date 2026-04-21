<?php
require_once("../../config/db.php");
require_once("../../includes/session.php");

requireAdmin();

$db = new \Connexion();
$conn = $db->CNXbase();

$commandes = $conn->query("SELECT * FROM commandes")->fetchAll();

foreach ($commandes as $c) {
    echo "Commande ID: " . $c['id'] . " | Status: " . $c['status'];
    echo " <a href='supprimer.php?id=".$c['id']."'>Supprimer</a><br>";
}
?>