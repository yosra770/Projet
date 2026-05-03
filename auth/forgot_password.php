<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include("../includes/header.php"); 
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@300;400;600&display=swap');

    body { background-color: #F8F7F4; font-family: 'Inter', sans-serif; color: #1A1A1A; }
    
    .reset-wrapper { height: 75vh; display: flex; align-items: center; justify-content: center; }
    
    .auth-card { 
        background: #FFFFFF; padding: 60px; width: 100%; max-width: 420px; 
        border: 1px solid #E5E0D8; box-shadow: 0 10px 40px rgba(0,0,0,0.03);
    }

    h3 { font-family: 'Playfair Display', serif; font-size: 28px; margin-bottom: 15px; text-align: center; }
    .subtitle { color: #888; font-size: 14px; text-align: center; margin-bottom: 35px; line-height: 1.6; }

    /* Inputs Luxe */
    .field-wrapper { margin-bottom: 25px; }
    .custom-input { 
        width: 100%; padding: 12px 0; border: none; border-bottom: 1px solid #E5E0D8; 
        background: transparent; font-size: 15px; transition: 0.3s;
    }
    .custom-input:focus { outline: none; border-bottom: 1px solid #1A1A1A; }
    
    /* Boutons */
    .btn-submit { 
        background: #1A1A1A; color: #fff; border: none; padding: 18px; width: 100%; 
        text-transform: uppercase; letter-spacing: 2px; font-weight: 600; cursor: pointer;
        transition: 0.3s; margin-top: 10px;
    }
    .btn-submit:hover { background: #333; letter-spacing: 3px; }

    .btn-link-custom {
        display: inline-block; margin-top: 20px; padding: 12px 20px;
        border: 1px solid #1A1A1A; color: #1A1A1A; text-decoration: none;
        font-size: 12px; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s;
    }
    .btn-link-custom:hover { background: #1A1A1A; color: #fff; }

    .alert { border-radius: 0; border: none; font-size: 13px; padding: 15px; margin-bottom: 25px; }
</style>

<div class="container reset-wrapper">
    <div class="auth-card text-center">
        
        <h3>Reset Password</h3>
        <p class="subtitle">Enter your email address to receive a secure password reset link</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" style="background: #FFF1F1; color: #A00;">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success" style="background: #F1F9F1; color: #287D28;">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
            
            <?php if (isset($_SESSION['link'])): ?>
                <div class="mt-2">
                    <p style="font-size: 12px; color: #888;">Email simulator (development):</p>
                    <a href="<?= $_SESSION['link'] ?>" target="_blank" class="btn-link-custom">
                        Please follow the link to reset your password
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form method="POST" action="send_reset.php">
            <div class="field-wrapper text-start">
                <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #aaa;">Email Address</label>
                <input type="email" name="email" class="custom-input" placeholder="example@domain.com" required>
            </div>

            <button type="submit" class="btn-submit">send the link</button>

            <div class="mt-4">
                <a href="login.php" style="font-size: 12px; color: #1A1A1A; text-decoration: underline;">Return to login</a>
            </div>
        </form>

    </div>
</div>

<?php include("../includes/footer.php"); ?>