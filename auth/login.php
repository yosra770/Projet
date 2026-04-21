<?php include("../includes/header.php"); ?>

<div class="container d-flex justify-content-center align-items-center" style="height:80vh;">
    <div class="card p-4 shadow" style="width:350px;">

        <h3 class="text-center mb-3">Connexion</h3>

        <form method="POST" action="login_traitement.php">
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

            <input type="password" name="password" class="form-control mb-3" placeholder="Mot de passe" required>

            <button class="btn btn-dark w-100">Login</button>
        </form>

    </div>
</div>

<?php include("../includes/footer.php"); ?>