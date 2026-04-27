<?php
require_once(__DIR__ . "/traitement.php");

$p = new produit();
$produits = $p->listProduits();
?>

<style>
    /* Style spécifique à la table des produits */
    .product-section {
        width: 82%;
        margin-left:40px; /* Laisser de l'espace pour la sidebar */
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
    }

    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 15px; /* Espace entre les lignes */
    }

    .table-custom thead th {
        font-family: 'Playfair Display', serif;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 2px;
        color: #94a3b8;
        border: none;
        padding: 10px 20px;
    }

    .table-custom tbody tr {
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .table-custom tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .table-custom td {
        padding: 20px;
        vertical-align: middle;
        border: none;
    }

    /* Coins arrondis pour les lignes */
    .table-custom td:first-child { border-radius: 15px 0 0 15px; }
    .table-custom td:last-child { border-radius: 0 15px 15px 0; }

    /* Image du produit */
    .product-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 12px;
        background: #f8f9fa;
        border: 1px solid #eee;
    }

    /* Badges de prix */
    .price-badge {
        font-weight: 700;
        color: #1a1a1a;
        font-size: 1.1rem;
    }

    /* Boutons d'actions */
    .action-btn {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        text-decoration: none;
        margin-right: 5px;
        transition: 0.3s;
    }

    .btn-edit { background: #eff6ff; color: #3b82f6; }
    .btn-edit:hover { background: #3b82f6; color: #fff; }

    .btn-delete { background: #fef2f2; color: #ef4444; }
    .btn-delete:hover { background: #ef4444; color: #fff; }

    .btn-add-product {
        background: #1a1a1a;
        color: #fff;
        border-radius: 12px;
        padding: 12px 25px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        transition: 0.3s;
        font-size: 0.9rem;
    }

    .btn-add-product:hover {
        background: #d4af37;
        color: #fff;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
    }
</style>
<?php include("../../includes/header.php"); ?>
<?php
require_once("../../includes/session.php");
requireAdmin();
?>
 <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

 <link rel="stylesheet" href="/web2/projet/style.css">
<div class="d-flex align-items-start">
 <?php include("../sidebar.php"); ?>
<div class="product-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-family: 'Playfair Display', serif; font-weight: 700;">Gestion des Produits</h2>
        <a href="ajouter.php" class="btn-add-product">
            <i class="fas fa-plus me-2"></i> Ajouter une Sneaker
        </a>
    </div>

    <table class="table-custom">
        <thead>
            <tr>
                <th>ID</th>
                <th>Aperçu</th>
                <th>Nom du Modèle</th>
                <th>Prix</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>

<?php foreach ($produits as $prod): ?>

<tr>
    <td class="text-muted">#<?= $prod['id'] ?></td>

    <td>
        <img src="../../uploads/<?= !empty($prod['image']) ? $prod['image'] : 'default.png' ?>" class="product-img">
    </td>

    <td>
        <span class="fw-bold d-block"><?= $prod['nom'] ?></span>
        <small class="text-muted"><?= $prod['description'] ?></small>
    </td>

    <td>
        <span class="price-badge"><?= $prod['prix'] ?> TND</span>
    </td>

   <td class="text-end">

    <!-- MODIFIER -->
    <a href="modifier.php?id=<?= $prod['id'] ?>" 
       class="action-btn btn-edit"
       title="Modifier">
        <i class="fas fa-pen-nib"></i>
    </a>

    <!-- SUPPRIMER -->
    <a href="supprimer.php?id=<?= $prod['id'] ?>" 
       class="action-btn btn-delete"
       title="Supprimer"
       onclick="return confirm('Supprimer ce produit ?');">
        <i class="fas fa-trash-alt"></i>
    </a>

</td>
</tr>

<?php endforeach; ?>

</tbody>
    </table>
</div>
</div>
<?php include("../../includes/footer.php"); ?>