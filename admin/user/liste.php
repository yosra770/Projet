<?php
require_once("../../includes/session.php");
requireAdmin();
require_once("../../config/db.php");

$cnx = new Connexion();
$pdo = $cnx->CNXbase();

$users = $pdo->query("SELECT * FROM utilisateur");
?>

<style>
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

.user-img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.badge-role {
    padding: 5px 10px;
    border-radius: 10px;
    font-size: 12px;
}

.admin { background: black; color: white; }
.user { background: gray; color: white; }

.active { background: green; color: white; }
.inactive { background: red; color: white; }

.action-btn {
    width: 35px;
    height: 35px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
}

.btn-delete { background: #fef2f2; color: red; }
</style>

<?php include("../../includes/header.php"); ?>

<div class="d-flex align-items-start">
<?php include("../sidebar.php"); ?>

<div class="product-section">

    <h2>Gestion des Utilisateurs</h2>

    <table class="table-custom">

        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Sexe</th>
                <th>Date Naissance</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach($users as $u): ?>

        <tr>
            <td>#<?= $u['id'] ?></td>

            <td>
                <img src="../../uploads/<?= !empty($u['photo']) ? $u['photo'] : 'default.png' ?>" class="user-img">
            </td>

            <td>
                <?= $u['nom'] ?> <?= $u['prenom'] ?>
            </td>

            <td><?= $u['email'] ?></td>

            <td><?= $u['sexe'] ?></td>

            <td><?= $u['date_naissance'] ?></td>

            <td>
                <span class="badge-role <?= $u['role'] ?>">
                    <?= $u['role'] ?>
                </span>
            </td>

            <td>
                <span class="badge-role <?= $u['status'] ? 'active' : 'inactive' ?>">
                    <?= $u['status'] ? 'Actif' : 'Bloqué' ?>
                </span>
            </td>

            <td>

    <!-- MODIFIER -->
    <a href="modifier.php?id=<?= $u['id'] ?>" 
       class="action-btn btn-edit"
       title="Modifier">
        <i class="fas fa-pen-nib"></i>
    </a>

    <!-- SUPPRIMER -->
    <a href="supprimer.php?id=<?= $u['id'] ?>" 
       class="action-btn btn-delete"
       onclick="return confirm('Supprimer cet utilisateur ?');">
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