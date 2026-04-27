<?php include("../includes/header.php"); ?>

<div class="container mt-5 mb-5">
    <h2 class="text-center">✨ Ajouter un nouveau produit</h2>

    <form action="traitement_ajout.php" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        
        <div class="mb-3">
            <label class="form-label fw-bold">Nom du produit</label>
            <input type="text" name="nom" class="form-control" placeholder="Ex: Air Jordan 1 Retro" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Description</label>
            <textarea name="description" class="form-control" placeholder="Décrivez les caractéristiques du produit..." required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Prix (DT)</label>
            <input type="number" name="prix" class="form-control" placeholder="0.00" step="0.01" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Image du produit</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-success w-100">🚀 Publier le produit</button>

    </form>
</div>

<?php include("../includes/footer.php"); ?>