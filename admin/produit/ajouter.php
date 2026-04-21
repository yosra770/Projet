<?php require_once("../../includes/session.php"); requireAdmin(); ?>

<h2>Ajouter Produit</h2>

<form method="POST" action="../../Produits/traitement.php" enctype="multipart/form-data">

    Nom: <input type="text" name="nom"><br>
    Prix: <input type="text" name="prix"><br>

    Description:
    <textarea name="description"></textarea><br>

    Image: <input type="file" name="image"><br>

    <button type="submit" name="action" value="ajouter">Ajouter</button>
</form>