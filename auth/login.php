<?php include("../includes/header.php"); ?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['error'])) {
    echo "<div class='container mt-3'>
            <div class='alert alert-danger text-center'>
                ".$_SESSION['error']."
            </div>
          </div>";
    unset($_SESSION['error']);
}
?>

<div class="container d-flex justify-content-center align-items-center" style="height:85vh;">

    <div class="card shadow-lg border-0 p-4" style="width: 380px; border-radius: 18px;">

        <div class="text-center mb-4">
            <h3 class="fw-bold">Welcome Back 👟</h3>
            <p class="text-muted">Login to continue</p>
        </div>

        <form method="POST" action="login_traitement.php">

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter password" required>
            </div>

            <button type="submit" class="btn btn-dark w-100 btn-lg rounded-3">
                Login
            </button>

            <div class="text-center mt-3">
                <small class="text-muted">
                    Don’t have an account?
                    <a href="register_form.php" class="text-decoration-none">Sign up</a>
                </small>
            </div>

        </form>

    </div>

</div>

<?php include("../includes/footer.php"); ?>