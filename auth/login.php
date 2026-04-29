<?php
// Vérification de la session en haut du fichier
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php include("../includes/header.php"); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@300;400;600&display=swap');

    body { background-color: #F8F7F4; font-family: 'Inter', sans-serif; color: #1A1A1A; }

    .login-container { height: 80vh; display: flex; align-items: center; justify-content: center; }

    .auth-card { 
        background: #FFFFFF; 
        padding: 60px; 
        width: 100%; 
        max-width: 420px; 
        border: 1px solid #E5E0D8; 
    }

    h3 { font-family: 'Playfair Display', serif; font-size: 32px; margin-bottom: 10px; }
    .subtitle { color: #888; margin-bottom: 40px; font-size: 14px; }

    /* Inputs élégants */
    .field-wrapper { margin-bottom: 30px; position: relative; }
    .custom-input { 
        width: 100%; padding: 10px 0; border: none; border-bottom: 1px solid #E5E0D8; 
        background: transparent; font-size: 15px; transition: 0.3s;
    }
    .custom-input:focus { outline: none; border-bottom: 1px solid #1A1A1A; }
    .label-input { font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #aaa; margin-bottom: 5px; display: block; }

    /* Bouton */
    .btn-submit { 
        background: #1A1A1A; color: #fff; border: none; padding: 18px; width: 100%; 
        text-transform: uppercase; letter-spacing: 2px; font-weight: 600; cursor: pointer;
        transition: 0.3s;
    }
    .btn-submit:hover { background: #333; letter-spacing: 3px; }
</style>

<div class="container login-container">
    <div class="auth-card">
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" style="font-size: 12px; border: none; background: #fff1f1; color: #A00; text-align: center; margin-bottom: 30px;">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="text-center">
            <h3>Welcome</h3>
            <p class="subtitle">Log in to access your account</p>
        </div>

        <form method="POST" action="login_traitement.php">
            <div class="field-wrapper">
                <label class="label-input">E-mail</label>
                <input type="email" name="email" class="custom-input" placeholder="example@email.com" required>
            </div>

            <div class="field-wrapper">
                <label class="label-input">PASSWORD</label>
                <input type="password" name="password" class="custom-input" placeholder="Password" required>
            </div>

            <button type="submit" class="btn-submit">Login</button>

            <div class="text-center mt-4">
                <p style="font-size: 13px; color: #888;">
                    You don't have an account ? 
                    <a href="register_form.php" style="color: #1A1A1A; text-decoration: underline;">Sign up</a>
                </p>
            </div>
        </form>
    </div>
</div>

<?php include("../includes/footer.php"); ?>