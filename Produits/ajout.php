<?php include("../includes/header.php"); ?>

<div class="container mt-5">
<h2 class="text-center">Ajouter Produit</h2>

<form action="traitement_ajout.php" method="POST" enctype="multipart/form-data" class="card p-4 shadow">

<input type="text" name="nom" class="form-control mb-2" placeholder="Nom">

<textarea name="description" class="form-control mb-2"></textarea>

<input type="number" name="prix" class="form-control mb-2" placeholder="Prix">

<input type="file" name="image" class="form-control mb-2">

<button class="btn btn-success">Ajouter</button>

</form>
</div>

<?php include("../includes/footer.php"); ?>