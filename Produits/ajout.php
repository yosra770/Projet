<?php include("../includes/header.php"); ?>

<div class="container mt-5">
<h2>Ajouter produit</h2>

<form action="traitement_ajout.php" method="POST" enctype="multipart/form-data">

<input type="text" name="nom" placeholder="Nom" class="form-control mb-2">

<textarea name="description" class="form-control mb-2"></textarea>

<input type="number" name="prix" placeholder="Prix" class="form-control mb-2">

<input type="file" name="image" class="form-control mb-2">

<button class="btn btn-success">Ajouter</button>

</form>
</div>

<?php include("../includes/footer.php"); ?>