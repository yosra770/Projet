<?php
require_once("../../includes/session.php");
requireAdmin();
require_once("traitement_user.php");

$userObj = new User();
$id = $_GET['id'];
$user = $userObj->getUser($id);

if(isset($_POST['update'])) {
    $userObj->updateUser($id, $_POST, $_FILES);
    header("Location: liste.php");
    exit();
}
?>

<?php include("../../includes/header.php"); ?>
  <link rel="stylesheet" href="/web2/projet/style.css">

<style>
    /* Structure Globale */
    body {
        background-color: #f4f7f6;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding-top: 70px; /* Espace pour le header fixed */
    }

    .main-wrapper {
        display: flex;
        min-height: calc(100vh - 70px);
    }

    .content-area {
        flex-grow: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }

    /* Carte du Formulaire Noir */
    form {
        background: #121212;
        padding: 40px;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 450px;
        color: white;
    }

    h2 {
        text-align: center;
        color: #333; /* Titre sombre sur fond clair */
        font-weight: 700;
        margin-bottom: 20px;
    }

    .profile-img-container {
        text-align: center;
        margin-bottom: 25px;
    }

    .profile-img-container img {
        border: 3px solid #bb86fc;
        padding: 5px;
        object-fit: cover;
    }

    /* Champs de saisie */
    input[type="text"], 
    input[type="email"],
    select {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 15px;
        background: #1e1e1e;
        border: 1px solid #333;
        border-radius: 10px;
        color: #fff;
        font-size: 14px;
        box-sizing: border-box;
        transition: 0.3s;
    }

    input:focus, select:focus {
        outline: none;
        border-color: #bb86fc;
        background: #252525;
    }

    label {
        display: block;
        font-size: 13px;
        color: #aaa;
        margin-bottom: 5px;
        margin-left: 2px;
    }

    /* Bouton Modifier */
    button[name="update"] {
        width: 100%;
        padding: 15px;
        background: #bb86fc; /* Violet néon */
        color: #121212;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: 0.3s;
        text-transform: uppercase;
        margin-top: 10px;
    }

    button[name="update"]:hover {
        background: #a370f7;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(187, 134, 252, 0.4);
    }

    input[type="file"] {
        color: #888;
        font-size: 12px;
        margin-bottom: 15px;
    }
</style>

<div class="main-wrapper">
    <?php include("../sidebar.php"); ?>

    <div class="content-area">
        <div>
            <h2>Modifier Utilisateur</h2>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="profile-img-container">
                    <img src="../../uploads/<?= !empty($user['photo']) ? $user['photo'] : 'default.png' ?>" 
                         width="100" height="100" style="border-radius:50%;">
                </div>

                <label>Nom</label>
                <input type="text" name="nom" value="<?= $user['nom'] ?>" placeholder="Nom">

                <label>Prénom</label>
                <input type="text" name="prenom" value="<?= $user['prenom'] ?>" placeholder="Prénom">

                <label>Email</label>
                <input type="email" name="email" value="<?= $user['email'] ?>" placeholder="Email">

                <label>Changer la photo</label>
                <input type="file" name="photo">

                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label>Rôle</label>
                        <select name="role">
                            <option value="user" <?= $user['role']=='user'?'selected':'' ?>>User</option>
                            <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label>Status</label>
                        <select name="status">
                            <option value="1" <?= $user['status']==1?'selected':'' ?>>Actif</option>
                            <option value="0" <?= $user['status']==0?'selected':'' ?>>Bloqué</option>
                        </select>
                    </div>
                </div>

                <button name="update">Enregistrer les modifications</button>
            </form>
        </div>
    </div>
</div>

<?php include("../../includes/footer.php"); ?>