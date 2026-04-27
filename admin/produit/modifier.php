<?php
require_once(__DIR__ . "/traitement.php");

$p = new produit();
$res = $p->getProduit($_GET['id']);
$prod = $res->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Produit</title>
    <style>
        /* Configuration de base */
        body {
            background-color: #f4f7f6;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding-top: 80px; /* Espace pour le header */
        }

        /* Conteneur pour aligner avec la sidebar */
        .main-wrapper {
            display: flex;
            min-height: calc(100vh - 80px);
        }

        .content-area {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Formulaire Noir */
        form {
            background: #121212;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
            color: white;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
        }

        /* Champs de texte */
        input[type="text"], 
        textarea {
            width: 100%;
            padding: 14px 18px;
            margin-bottom: 20px;
            background: #1e1e1e;
            border: 1px solid #333;
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #bb86fc; /* Accent violet */
            background: #252525;
        }

        textarea {
            height: 120px;
            resize: none;
        }

        /* Bouton Modifier (Orange/Jaune pour différencier de l'ajout) */
        button {
            width: 100%;
            padding: 16px;
            background: #f39c12; 
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        button:hover {
            background: #e67e22;
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
        }

        .btn-annuler {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #888;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>

<?php include("../../includes/header.php"); ?>

<div class="main-wrapper">
    <?php include("../sidebar.php"); ?>

    <div class="content-area">
        <form method="POST">
            <h2>Modifier le Produit</h2>

            <label style="color: #888; font-size: 12px; margin-left: 5px;">Nom du produit</label>
            <input type="text" name="nom" value="<?= $prod['nom'] ?>" required>

            <label style="color: #888; font-size: 12px; margin-left: 5px;">Prix (€)</label>
            <input type="text" name="prix" value="<?= $prod['prix'] ?>" required>

            <label style="color: #888; font-size: 12px; margin-left: 5px;">Description</label>
            <textarea name="description"><?= $prod['description'] ?></textarea>

            <button name="update">Mettre à jour</button>
            <a href="liste.php" class="btn-annuler">Annuler les modifications</a>
        </form>
    </div>
</div>

<?php include("../../includes/footer.php"); ?>

</body>
</html>

<?php
if(isset($_POST['update'])) {
    $p->nom = $_POST['nom'];
    $p->prix = $_POST['prix'];
    $p->description = $_POST['description'];
    $p->modifierProduit($_GET['id']);
    header("Location: liste.php");
}
?>