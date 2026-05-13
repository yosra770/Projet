<?php

require_once("../../includes/session.php");
require_once(__DIR__ . "/commande_traitement.php");
requireAdmin();

$c = new \Commande();

// ✅ 1. UPDATE D'ABORD
if(isset($_GET['id']) && isset($_GET['status'])) {

    $id = intval($_GET['id']);
    $status = $_GET['status'];

    $allowed = ['en attente', 'validée', 'annulée'];

    if(in_array($status, $allowed)) {

    if ($status === 'validée') {
        $c->validerEtDecrementStock($id);
    } else {
        $c->updateStatus($id, $status);
    }
}

    // ✅ 2. REDIRECTION (TRÈS IMPORTANT)
    header("Location: commande.php");
    exit();
}

// ✅ 3. ENSUITE ON CHARGE LES DONNÉES
$commandes = $c->listCommandes();

?>

<style>
.product-section {
    width: 82%;
    margin-left:40px;
    background: #fff;
    border-radius: 20px;
    padding: 30px;
}

.table-custom {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 15px;
}

.table-custom td {
    padding: 20px;
}

.status {
    padding: 5px 10px;
    border-radius: 10px;
    font-size: 12px;
}

.en-attente { background: orange; color: white; }
.validée { background: green; color: white; }
.annulée { background: red; color: white; }

.total {
    font-weight: bold;
}
</style>

<?php include("../../includes/header.php"); ?>

<div class="d-flex">
<?php include("../sidebar.php"); ?>

<div class="product-section">

<h2>Gestion des Commandes</h2>

<table class="table-custom">

<thead>
<tr>
    <th>ID</th>
    <th>Client</th>
    <th>Date</th>
    <th>Total</th>
    <th>Status</th>
    <th>Détails</th>
</tr>
</thead>

<tbody>

<?php foreach($commandes as $cmd): ?>

<tr>
    <td>#<?= $cmd['id'] ?></td>
    <td><?= $cmd['nom'] ?> <?= $cmd['prenom'] ?></td>
    <td><?= $cmd['date_commande'] ?></td>
    <td class="total"><?= $cmd['total'] ?> TND</td>

    <td>
        <span class="status <?= str_replace(' ', '-', $cmd['status']) ?>">
            <?= $cmd['status'] ?>
        </span>
    </td>

    <td>
        <button class="btn btn-dark btn-sm"
            data-bs-toggle="collapse"
            data-bs-target="#d<?= $cmd['id'] ?>">
            Voir
        </button>
    </td>
</tr>

<tr class="collapse" id="d<?= $cmd['id'] ?>">
<td colspan="6">

<table class="table table-bordered">
<tr>
    <th>Produit</th>
     <th>Taille</th>
    <th>Couleur</th>
    <th>Quantité</th>
    <th>Prix</th>
    <th>Subtotal</th>
</tr>

<?php
$details = $c->getDetails($cmd['id']);
foreach($details as $d):
?>

<tr>
    <td><?= $d['nom'] ?></td>

    <td>
        <?= !empty($d['taille']) ? $d['taille'] : '-' ?>
    </td>

    <td>
        <?= !empty($d['couleur']) ? $d['couleur'] : '-' ?>
    </td>

    <td><?= $d['quantite'] ?></td>

    <td><?= $d['prix'] ?> TND</td>

    <td><?= $d['subtotal'] ?> TND</td>
</tr>

<?php endforeach; ?>
</table>

<!-- ACTIONS -->
<div style="margin-top:10px;">

<a href="commande.php?id=<?= $cmd['id'] ?>&status=validée"
   class="btn btn-success btn-sm">
   Valider
</a>

<a href="commande.php?id=<?= $cmd['id'] ?>&status=annulée"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Annuler cette commande ?')">
   Annuler
</a>

</div>

</td>
</tr>

<?php endforeach; ?>

</tbody>
</table>

</div>
</div>

<?php include("../../includes/footer.php"); ?>