<?php

require_once("../../includes/session.php");
require_once(__DIR__ . "/commande_traitement.php");
requireAdmin();
$c = new \Commande();
$commandes = $c->listCommandes();
?>

<style>
/* tu peux réutiliser ton CSS produit */
.product-section {
    width: 82%;
    margin-left:40px;
    background: #fff;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.05);
}

.table-custom {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 15px;
}

.table-custom tbody tr {
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    transition: 0.3s;
}

.table-custom tbody tr:hover {
    transform: scale(1.01);
}

.table-custom td {
    padding: 20px;
}

.status {
    padding: 5px 10px;
    border-radius: 10px;
    font-size: 12px;
}

.pending { background: orange; color: white; }
.validated { background: green; color: white; }
.cancelled { background: red; color: white; }
</style>

<?php include("../../includes/header.php"); ?>

<div class="d-flex align-items-start">
<?php include("../sidebar.php"); ?>

<div class="product-section">

    <h2>Gestion des Commandes</h2>

    <table class="table-custom">

        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Date</th>
                <th>Status</th>
                <th>Détails</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach($commandes as $cmd): ?>

        <tr>
            <td>#<?= $cmd['id'] ?></td>

            <td>
                <?= $cmd['nom'] ?> <?= $cmd['prenom'] ?>
            </td>

            <td>
                <?= $cmd['date_commande'] ?>
            </td>

            <td>
                <span class="status <?= $cmd['status'] ?>">
                    <?= $cmd['status'] ?>
                </span>
            </td>

            <td>
                <!-- bouton voir détails -->
                <button class="btn btn-dark btn-sm" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#d<?= $cmd['id'] ?>">
                    Voir
                </button>
            </td>
        </tr>

        <!-- DETAILS -->
        <tr class="collapse" id="d<?= $cmd['id'] ?>">
            <td colspan="5">

                <table class="table table-bordered">

                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix</th>
                    </tr>

                    <?php
                    $details = $c->getDetails($cmd['id']);
                    foreach($details as $d):
                    ?>

                    <tr>
                        <td><?= $d['nom'] ?></td>
                        <td><?= $d['quantite'] ?></td>
                        <td><?= $d['prix'] ?> TND</td>
                    </tr>

                    <?php endforeach; ?>

                </table>

            </td>
        </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

</div>
</div>

<?php include("../../includes/footer.php"); ?>