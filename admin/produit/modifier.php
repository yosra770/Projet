<?php
require_once("../../includes/session.php");
require_once(__DIR__ . "/traitement.php");

$p = new produit();
$prod = $p->getProduit($_GET['id']);

if(isset($_POST['update'])) {
    $p->nom = $_POST['nom'];
    $p->prix = $_POST['prix'];
    $p->description = $_POST['description'];
    $p->categorie = $_POST['categorie'];
    $p->style = $_POST['style'];
    $p->stock = $_POST['stock'];
    $p->modifierProduit($_GET['id']);
    
    header("Location: liste.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Produit</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding-top: 70px;
        }

        .main-wrapper {
            display: flex;
            min-height: calc(100vh - 70px);
        }

        /* Sidebar */
        aside, .sidebar {
            z-index: 10;
            min-width: 250px;
            background: #fff;
            border-right: 1px solid #ddd;
        }

        .content-area {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        /* Formulaire Noir */
        form {
            background: #121212;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 480px;
            color: white;
        }

        h2 { 
            text-align: center; 
            color: #ffffff; 
            margin-top: 0;
            margin-bottom: 30px;
            font-weight: 600;
        }

        /* Champs de saisie harmonisés */
        input[type="text"], 
        input[type="number"], 
        select, 
        textarea { 
            width: 100%; 
            padding: 14px 18px; 
            margin-bottom: 15px; 
            background: #1e1e1e; 
            border: 1px solid #333; 
            border-radius: 12px; 
            color: #fff;
            font-family: inherit;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #f39c12;
            background: #252525;
        }

        /* Labels stylisés */
        .field-label {
            display: block;
            color: #888;
            font-size: 12px;
            margin-bottom: 5px;
            margin-left: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Groupes de champs */
        .input-group {
            display: flex;
            gap: 15px;
        }
        .input-group div { flex: 1; }

        /* Bouton Update */
        button { 
            width: 100%; 
            padding: 16px; 
            background: #f39c12; 
            color: white; 
            border: none; 
            border-radius: 12px; 
            font-weight: 700; 
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            text-transform: uppercase;
        }

        button:hover { 
            background: #e67e22; 
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(243, 156, 18, 0.4);
        }

        .btn-annuler {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .btn-annuler:hover {
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-wrapper { flex-direction: column; }
            .sidebar { width: 100%; min-width: unset; }
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

            <span class="field-label">Nom du produit</span>
            <input type="text" name="nom" value="<?= htmlspecialchars($prod['nom']) ?>" required>

            <div class="input-group">
                <div>
                    <span class="field-label">Prix (€)</span>
                    <input type="text" name="prix" value="<?= htmlspecialchars($prod['prix']) ?>" required>
                </div>
                <div>
                    <span class="field-label">Stock</span>
                    <input type="number" name="stock" value="<?= htmlspecialchars($prod['stock']) ?>" required>
                </div>
            </div>

            <span class="field-label">Description</span>
            <textarea name="description" rows="3"><?= htmlspecialchars($prod['description']) ?></textarea>

            <div class="input-group">
                <div>
                    <span class="field-label">Catégorie</span>
                    <select name="categorie" required>
                        <option value="men" <?= $prod['categorie']=='men'?'selected':'' ?>>Homme</option>
                        <option value="women" <?= $prod['categorie']=='women'?'selected':'' ?>>Femme</option>
                        <option value="kids" <?= $prod['categorie']=='kids'?'selected':'' ?>>Enfant</option>
                    </select>
                </div>
                <div>
                    <span class="field-label">Style</span>
                    <input type="text" name="style" value="<?= htmlspecialchars($prod['style']) ?>" required>
                </div>
            </div>

            <button name="update" type="submit">Enregistrer les modifications</button>
            
            <a href="liste.php" class="btn-annuler">← Retour à la liste</a>
        </form>
    </div>
</div>

<?php include("../../includes/footer.php"); ?>

</body>
</html>