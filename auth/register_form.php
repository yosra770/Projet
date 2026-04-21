<?php include("../includes/header.php"); ?>

<div class="container d-flex justify-content-center mt-5">
    <div class="card p-4 shadow" style="width:400px;">

        <h3 class="text-center mb-3">Inscription</h3>

        <form action="register_traitement.php" method="POST" enctype="multipart/form-data">

            <input type="text" name="nom" class="form-control mb-2" placeholder="Nom" required>

            <input type="text" name="prenom" class="form-control mb-2" placeholder="Prénom" required>

            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

            <input type="password" name="password" class="form-control mb-2" placeholder="Mot de passe" required>

            <input type="date" name="date_naissance" class="form-control mb-2">

            <select name="sexe" class="form-control mb-2">
                <option>Homme</option>
                <option>Femme</option>
            </select>

            <input type="file" name="photo" class="form-control mb-3">

            <button class="btn btn-warning w-100">S'inscrire</button>

        </form>
    </div>
</div>

<?php include("../includes/footer.php"); ?>