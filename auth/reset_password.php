<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once("../config/db.php");

$conn = (new Connexion())->CNXbase();
$token = $_GET['token'] ?? '';

$stmt = $conn->prepare("SELECT * FROM utilisateur WHERE reset_token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    // Design d'erreur élégant si le token est invalide
    include("../includes/header.php");
    echo "<div class='container text-center' style='margin-top:150px; font-family:Inter;'>
            <h1 style='font-family:Playfair Display;'>Lien expiré</h1>
            <p style='color:#888;'>Ce lien de réinitialisation n'est plus valide ou a déjà été utilisé.</p>
            <a href='forgot_password.php' style='color:#1A1A1A; text-decoration:underline;'>Demander un nouveau lien</a>
          </div>";
    exit;
}
?>

<?php include("../includes/header.php"); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap');

    body { background-color: #F8F7F4; font-family: 'Inter', sans-serif; color: #1A1A1A; }
    
    .reset-wrapper { height: 80vh; display: flex; align-items: center; justify-content: center; }
    
    .auth-card { 
        background: #FFFFFF; padding: 60px; width: 100%; max-width: 420px; 
        border: 1px solid #E5E0D8; box-shadow: 0 10px 40px rgba(0,0,0,0.03);
    }

    h3 { font-family: 'Playfair Display', serif; font-size: 28px; margin-bottom: 10px; text-align: center; }
    .subtitle { color: #888; font-size: 14px; text-align: center; margin-bottom: 40px; }

    /* Inputs Luxe */
    .field-wrapper { margin-bottom: 30px; }
    .custom-input { 
        width: 100%; padding: 12px 0; border: none; border-bottom: 1px solid #E5E0D8; 
        background: transparent; font-size: 16px; transition: 0.3s;
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
    
    .security-note { font-size: 12px; color: #999; margin-top: 20px; line-height: 1.5; }
</style>

<div class="container reset-wrapper">
    <div class="auth-card">
        
        <h3>New Password</h3>
        <p class="subtitle">Create a strong password to secure your account.</p>

        <form method="POST" action="update_password.php">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <div class="field-wrapper">
                <label class="label-input">New Password</label>
                <input type="password" name="password" class="custom-input" placeholder="Password" required autofocus>
            </div>

            <button type="submit" class="btn-submit">Update Password</button>

            <div class="security-note text-center">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 2px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                Use at least 8 characters with letters and numbers.
            </div>
        </form>

    </div>
</div>

<?php include("../includes/footer.php"); ?>