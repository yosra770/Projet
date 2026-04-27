<style>
    body {
        background-color: #f4f7f6;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding-top: 70px; /* IMPORTANT : Ajustez cette valeur selon la hauteur de votre Header */
    }

    .main-wrapper {
        display: flex;
        min-height: calc(100vh - 70px); /* Hauteur totale moins le header */
        align-items: stretch;
    }

    /* Ajustement Sidebar */
    aside, .sidebar {
        z-index: 10; /* Pour qu'elle reste sous le header mais au-dessus du fond */
        height: 100%;
    }

    .content-area {
        flex-grow: 1;
        display: flex;
        justify-content: center;
        align-items: center; /* Centre la carte verticalement dans l'espace restant */
        padding: 40px 20px;
        
    }

    form {
        background: #121212;
        padding: 40px;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 420px;
        color: white;
        position: relative; /* Sécurité pour le z-index */
    }

    /* On garde vos autres styles (h2, input, button, etc.) identiques */
    h2 { text-align: center; color: #ffffff; margin-bottom: 30px; }
    input[type="text"], textarea { 
        width: 100%; padding: 14px 18px; margin-bottom: 20px; 
        background: #1e1e1e; border: 1px solid #333; border-radius: 12px; color: #fff;
    }
    button { 
        width: 100%; padding: 16px; background: #f39c12; color: white; 
        border: none; border-radius: 12px; font-weight: 700; cursor: pointer;
    }
    button:hover { background: #bb86fc; color: white; }
    
    /* On s'assure que le footer prend toute la largeur en bas */
    footer {
        width: 100%;
        clear: both;
    }
</style>
<?php require_once("../../includes/session.php"); ?>
<?php
require_once(__DIR__ . "/traitement.php");

if (isset($_POST['ajouter'])) {

    $p = new produit();

    $p->nom = $_POST['nom'];
    $p->prix = $_POST['prix'];
    $p->description = $_POST['description'];

    // 🔥 GESTION IMAGE
    $image = "";

    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            __DIR__ . "/../../uploads/" . $image
        );
    }

    $p->image = $image;

    $p->insertProduit();

    // 🔁 REDIRECTION
    header("Location: liste.php");
    exit();
}
?>

<?php include("../../includes/header.php"); ?>
<?php require_once("../../includes/session.php"); ?>

<div class="main-wrapper">
    <?php include("../sidebar.php"); ?>

    <div class="content-area">
        <form method="POST" enctype="multipart/form-data">
            <h2>Nouveau Produit</h2>

            <input type="text" name="nom" placeholder="Nom du produit" required>
            <input type="text" name="prix" placeholder="Prix (€)" required>

            <textarea name="description" placeholder="Description détaillée..."></textarea>

            <label style="display: block; color: #888; font-size: 13px; margin-bottom: 8px;">Image du produit</label>
            <input type="file" name="image" required style="color: #b0b0b0;">

            <button name="ajouter">Ajouter au Catalogue</button>
        </form>
    </div>
</div>

<?php include("../../includes/footer.php"); ?>