<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
$success = $_SESSION['success'] ?? null;

unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['success']);
?>

<?php include("../includes/header.php"); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap');

    body { background-color: #F8F7F4; font-family: 'Inter', sans-serif; color: #1A1A1A; }
    
    .register-wrapper { min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 40px 0; }
    
    .auth-card { 
        background: #FFFFFF; padding: 60px; width: 100%; max-width: 450px; 
        border: 1px solid #E5E0D8; box-shadow: 0 10px 40px rgba(0,0,0,0.03);
    }

    h3 { font-family: 'Playfair Display', serif; font-size: 28px; margin-bottom: 30px; text-align: center; }

    /* Inputs élégants */
    .field-wrapper { margin-bottom: 20px; position: relative; }
    .custom-input, .custom-select { 
        width: 100%; padding: 10px 0; border: none; border-bottom: 1px solid #E5E0D8; 
        background: transparent; font-size: 15px; transition: 0.3s;
    }
    .custom-input:focus, .custom-select:focus { outline: none; border-bottom: 1px solid #1A1A1A; }
    
    .label-input { font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #aaa; margin-bottom: 5px; display: block; }
    .error-text { font-size: 11px; color: #a00; margin-top: 5px; display: block; }

    /* Bouton */
    .btn-submit { 
        background: #1A1A1A; color: #fff; border: none; padding: 18px; width: 100%; 
        text-transform: uppercase; letter-spacing: 2px; font-weight: 600; cursor: pointer;
        transition: 0.3s; margin-top: 10px;
    }
    .btn-submit:hover { background: #333; letter-spacing: 3px; }
</style>

<div class="container register-wrapper">
    <div class="auth-card">
        
        <h3>Create an account</h3>

        <?php if ($success): ?>
            <div class="alert alert-success" style="font-size: 13px; border: none; background: #e8f5e9; color: #2e7d32; text-align: center;">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <form action="register_traitement.php" method="POST">
            
            <div class="field-wrapper">
                <label class="label-input">Last Name</label>
                <input type="text" name="nom" class="custom-input" value="<?= $old['nom'] ?? '' ?>" required>
                <span class="error-text"><?= $errors['nom'] ?? '' ?></span>
            </div>

            <div class="field-wrapper">
                <label class="label-input">First Name</label>
                <input type="text" name="prenom" class="custom-input" value="<?= $old['prenom'] ?? '' ?>" required>
                <span class="error-text"><?= $errors['prenom'] ?? '' ?></span>
            </div>

            <div class="field-wrapper">
                <label class="label-input">Email</label>
                <input type="email" name="email" class="custom-input" value="<?= $old['email'] ?? '' ?>" required>
                <span class="error-text"><?= $errors['email'] ?? '' ?></span>
            </div>

            <div class="field-wrapper">
    <label class="label-input">Password</label>

    <div style="position:relative;">
        <input type="password" name="password" id="password" class="custom-input" required>

        <span onclick="togglePassword()" 
              style="position:absolute; right:0; top:50%; transform:translateY(-50%); cursor:pointer; font-size:14px; color:#777;">
            👁
        </span>
    </div>

    <span class="error-text"><?= $errors['password'] ?? '' ?></span>
</div>
            <div class="field-wrapper">
                <label class="label-input">Date of birth</label>
                <input type="date" name="date_naissance" class="custom-input" max="<?= date('Y-m-d', strtotime('-5 years')) ?>" required>
            </div>

            <div class="field-wrapper">
                <label class="label-input">Gender</label>
                <select name="sexe" class="custom-select">
                    <option value="Homme">Man</option>
                    <option value="Femme">Women</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Sign up</button>

            <div class="text-center mt-4">
                <p style="font-size: 13px; color: #888;">
                    Already a member ? 
                    <a href="login.php" style="color: #1A1A1A; text-decoration: underline;">Log in</a>
                </p>
            </div>

        </form>
    </div>
</div>
<script>
function togglePassword() {
    const input = document.getElementById("password");

    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>
<?php include("../includes/footer.php"); ?>