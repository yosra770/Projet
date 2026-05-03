<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once("../config/db.php");

if (!isset($_SESSION['user']['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$conn = (new Connexion())->CNXbase();
$user_id = $_SESSION['user']['id'];

$stmt = $conn->prepare("SELECT * FROM utilisateur WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php include("../includes/header.php"); ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap');

body { background-color: #F8F7F4; font-family: 'Inter', sans-serif; color: #1A1A1A; }

.edit-wrapper {
    height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 50px;
}

.auth-card {
    background: #FFFFFF;
    padding: 60px;
    width: 100%;
    max-width: 450px;
    border: 1px solid #E5E0D8;
    box-shadow: 0 10px 40px rgba(0,0,0,0.03);
}

h3 {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    margin-bottom: 10px;
    text-align: center;
}

.subtitle {
    color: #888;
    font-size: 14px;
    text-align: center;
    margin-bottom: 40px;
}

.field-wrapper { margin-bottom: 25px; }

.label-input {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #aaa;
    margin-bottom: 8px;
    display: block;
}

.custom-input {
    width: 100%;
    padding: 12px 0;
    border: none;
    border-bottom: 1px solid #E5E0D8;
    background: transparent;
    font-size: 16px;
}

.custom-input:focus {
    outline: none;
    border-bottom: 1px solid #1A1A1A;
}

.alert {
    border-radius: 0;
    border: none;
    font-size: 13px;
    padding: 15px;
    margin-bottom: 25px;
    text-align: center;
}

.btn-update {
    background: #1A1A1A;
    color: #fff;
    border: none;
    padding: 18px;
    width: 100%;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 20px;
}

.btn-update:hover {
    background: #333;
    letter-spacing: 3px;
}

.back-link {
    display: block;
    text-align: center;
    margin-top: 25px;
    font-size: 12px;
    color: #888;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.back-link:hover { color: #1A1A1A; }
</style>

<div class="container edit-wrapper">
    <div class="auth-card">

        <h3>Email Address</h3>
        <p class="subtitle">Update your contact information securely.</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" style="background:#FFF1F1;color:#A00;">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success" style="background:#F1F9F1;color:#287D28;">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="update_email.php">

            <!-- EMAIL -->
            <div class="field-wrapper">
                <label class="label-input">New Email</label>
                <input type="email" name="email" class="custom-input"
                       value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <!-- PASSWORD + EYE -->
            <div class="field-wrapper" style="position:relative;">
                <label class="label-input">Confirm with password</label>

                <input type="password" id="password" name="password"
                       class="custom-input"
                       placeholder="Your current password" required>

                <span onclick="togglePassword()" id="eyeIcon"
                      style="position:absolute; right:0; top:35px; cursor:pointer; font-size:18px;">
                    👁️
                </span>
            </div>

            <button type="submit" class="btn-update">
                Register the modifications
            </button>

            <a href="profile.php" class="back-link">← return to profile</a>

        </form>

    </div>
</div>

<!-- SCRIPT UNIQUE -->
<script>
function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (input.type === "password") {
        input.type = "text";
        icon.textContent = "🙈";
    } else {
        input.type = "password";
        icon.textContent = "👁️";
    }
}
</script>

<?php include("../includes/footer.php"); ?>