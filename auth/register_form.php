<?php
session_start();

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
$success = $_SESSION['success'] ?? null;

unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['success']);
?>

<?php include("../includes/header.php"); ?>

<div class="container d-flex justify-content-center mt-5">
<div class="card p-4 shadow" style="width:400px;">

<h3 class="text-center mb-3">Inscription</h3>

<?php if ($success): ?>
    <div class="alert alert-success text-center">
        <?= $success ?>
    </div>
<?php endif; ?>

<form action="register_traitement.php" method="POST">

    <input type="text" name="nom" class="form-control mb-1"
           placeholder="Nom"
           value="<?= $old['nom'] ?? '' ?>">
    <small class="text-danger"><?= $errors['nom'] ?? '' ?></small>

    <input type="text" name="prenom" class="form-control mb-1 mt-2"
           placeholder="Prénom"
           value="<?= $old['prenom'] ?? '' ?>">
    <small class="text-danger"><?= $errors['prenom'] ?? '' ?></small>

    <input type="email" name="email" class="form-control mb-1 mt-2"
           placeholder="Email"
           value="<?= $old['email'] ?? '' ?>">
    <small class="text-danger"><?= $errors['email'] ?? '' ?></small>

    <input type="password" name="password" class="form-control mb-1 mt-2"
           placeholder="Mot de passe">
    <small class="text-danger"><?= $errors['password'] ?? '' ?></small>

    <input type="date"
           name="date_naissance"
           class="form-control mb-2 mt-2"
           max="<?= date('Y-m-d', strtotime('-5 years')) ?>">

    <small class="text-danger"><?= $errors['date_naissance'] ?? '' ?></small>

    <select name="sexe" class="form-control mb-3">
        <option value="Homme">Homme</option>
        <option value="Femme">Femme</option>
    </select>

    <button class="btn btn-warning w-100">S'inscrire</button>

</form>

</div>
</div>

<?php include("../includes/footer.php"); ?>