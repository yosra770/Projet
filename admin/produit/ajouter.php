<?php 
require_once("../../includes/session.php"); 
require_once(__DIR__ . "/traitement.php");

// Logique de traitement
if (isset($_POST['ajouter'])) {

    $p = new produit();

    $p->nom = $_POST['nom'];
    $p->prix = $_POST['prix'];
    $p->description = $_POST['description'];
    $p->categorie = $_POST['categorie'];
    $p->style = $_POST['style'];
    $p->stock = 0;

    // IMAGE
    $image = "";

    if (!empty($_FILES['image']['name'])) {

        $image = time() . "_" . $_FILES['image']['name'];

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            __DIR__ . "/../../uploads/" . $image
        );
    }

    $p->image = $image;

    // INSERT PRODUIT
    $produit_id = $p->insertProduit();

    // INSERT VARIANTES
    if(isset($_POST['taille'])) {

        foreach($_POST['taille'] as $index => $taille) {

            $couleur = $_POST['couleur'][$index];
            $stock = $_POST['stock_variante'][$index];

            if(
                !empty($taille)
                &&
                !empty($couleur)
            ) {

                $p->insertVariante(
                    $produit_id,
                    $taille,
                    $couleur,
                    $stock
                );
            }
        }
    }

    header("Location: liste.php");
    exit();

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Produit</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding-top: 70px; /* Espace pour le header fixe */
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

        /* Zone de contenu principale */
        .content-area {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        /* Carte du Formulaire */
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

        /* Style des champs de saisie */
        input[type="text"], 
        input[type="number"], 
        input[type="file"],
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

        /* Petit label au-dessus des champs */
        .field-label {
            display: block;
            color: #888;
            font-size: 12px;
            margin-bottom: 5px;
            margin-left: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Groupe de champs (Prix & Stock) */
        .input-group {
            display: flex;
            gap: 15px;
        }
        .input-group div { flex: 1; }

        /* Bouton */
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
        }

        button:hover { 
            background: #e67e22; 
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(243, 156, 18, 0.4);
        }

        footer {
            width: 100%;
            background: #fff;
            padding: 20px 0;
            text-align: center;
            border-top: 1px solid #ddd;
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
        <form method="POST" enctype="multipart/form-data">
            <h2>Nouveau Produit</h2>

            <span class="field-label">Nom du produit</span>
            <input type="text" name="nom" placeholder="Ex: Air Max 90" required>

            <div class="input-group">
                <div>
                    <span class="field-label">Prix (€)</span>
                    <input type="text" name="prix" placeholder="0.00" required>
                </div>
                
            </div>

            <span class="field-label">Description</span>
            <textarea name="description" placeholder="Détails du produit..." rows="3"></textarea>

            <div class="input-group">
                <div>
                    <span class="field-label">Catégorie</span>
                    <select name="categorie" required>
                        <option value="" disabled selected>Choisir</option>
                        <option value="men">Homme</option>
                        <option value="women">Femme</option>
                        <option value="kids">Enfant</option>
                    </select>
                </div>
                <div>
                    <span class="field-label">Style</span>
                    <input type="text" name="style" placeholder="Ex: Sport" required>
                </div>
            </div>
            <h3 style="margin-top:25px;">Variantes</h3>

<div id="variantes">

    <div class="input-group variante">

        <!-- POINTURE -->
        <div>

            <span class="field-label">
                Pointure
            </span>

            <select name="taille[]">

                <option value="">
                    Choisir
                </option>

                <option value="36">36</option>
                <option value="37">37</option>
                <option value="38">38</option>
                <option value="39">39</option>
                <option value="40">40</option>
                <option value="41">41</option>
                <option value="42">42</option>
                <option value="43">43</option>
                <option value="44">44</option>
                <option value="45">45</option>

            </select>

        </div>

        <!-- COULEUR -->
        <div>

            <span class="field-label">
                Couleur
            </span>

            <select name="couleur[]">

                <option value="">
                    Choisir
                </option>

                <option value="Noir">Noir</option>
                <option value="Blanc">Blanc</option>
                <option value="Rouge">Rouge</option>
                <option value="Bleu">Bleu</option>
                <option value="Vert">Vert</option>
                <option value="Gris">Gris</option>
                <option value="Rose">Rose</option>
                <option value="Beige">Beige</option>
                <option value="Marron">Marron</option>
                <option value="Jaune">Jaune</option>

            </select>

        </div>

        <!-- STOCK -->
        <div>

            <span class="field-label">
                Stock
            </span>

            <input type="number"
                   name="stock_variante[]"
                   placeholder="Qté">

        </div>

    </div>

</div>

<button type="button" id="addVariant">
    + Ajouter Taille / Couleur
</button>

            <span class="field-label">Image du produit</span>
            <input type="file" name="image" required>

            <button name="ajouter" type="submit">Ajouter au Catalogue</button>
        </form>
    </div>
</div>

<?php include("../../includes/footer.php"); ?>
<script>

document
.getElementById("addVariant")
.onclick = function() {

    let html = `

    <div class="input-group variante">

        <div>

            <select name="taille[]">

                <option value="">Pointure</option>

                <option value="36">36</option>
                <option value="37">37</option>
                <option value="38">38</option>
                <option value="39">39</option>
                <option value="40">40</option>
                <option value="41">41</option>
                <option value="42">42</option>
                <option value="43">43</option>
                <option value="44">44</option>
                <option value="45">45</option>

            </select>

        </div>

        <div>

            <select name="couleur[]">

                <option value="">Couleur</option>

                <option value="Noir">Noir</option>
                <option value="Blanc">Blanc</option>
                <option value="Rouge">Rouge</option>
                <option value="Bleu">Bleu</option>
                <option value="Vert">Vert</option>
                <option value="Gris">Gris</option>
                <option value="Rose">Rose</option>
                <option value="Beige">Beige</option>
                <option value="Marron">Marron</option>
                <option value="Jaune">Jaune</option>

            </select>

        </div>

        <div>

            <input type="number"
                   name="stock_variante[]"
                   placeholder="Stock">

        </div>

    </div>

    `;

    document
    .getElementById("variantes")
    .insertAdjacentHTML("beforeend", html);
};

</script>
</body>
</html>