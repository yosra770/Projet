<?php
session_start();
require_once("../config/db.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

$panier = $_SESSION['panier'] ?? [];

if (empty($panier)) {
    echo "<div style='text-align:center;margin-top:100px;'>
            <h3>🛒 Your cart is empty</h3>
            <a href='../index.php'>Go Shopping</a>
          </div>";
    exit;
}

$user = $_SESSION['user'] ?? null;
?>

<?php include("../includes/header.php"); ?>

<div class="container py-5" style="margin-top:110px;">

<div class="row g-5">

<!-- LEFT: FORM -->
<div class="col-lg-7">

    <h2 style="font-weight:900;">Checkout</h2>
    <p style="color:#777;">Fill your delivery information</p>

<form action="valider_commande.php" method="POST"
      style="
        background:#fff;
        padding:25px;
        border-radius:20px;
        border:1px solid #eee;
        box-shadow:0 20px 60px rgba(0,0,0,0.05);
      ">

    <!-- NAME -->
    <div class="mb-3">
        <label>Full Name</label>
        <input type="text" name="nom" class="form-control" required>
    </div>

    <!-- EMAIL -->
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <!-- PHONE +216 -->
    <div class="mb-3">
        <label>Phone</label>
        <div class="input-group">
            <span class="input-group-text">+216</span>
           <input type="text"
       name="tel"
       class="form-control"
       placeholder="Ex: 12345678"
       pattern="[0-9]{8}"
       maxlength="8"
       required>
        </div>
    </div>

    <!-- ADDRESS -->
    <div class="mb-3">
        <label>Address</label>
        <textarea name="adresse" class="form-control" required></textarea>
    </div>
    <!-- POSTAL CODE -->
<div class="mb-3">
    <label>Postal Code</label>
    <input type="text"
           name="code_postal"
           class="form-control"
           placeholder="Ex: 1000"
           maxlength="4"
           pattern="[0-9]{4}"
           required>
    <small style="color:#888;font-size:12px;">
        Enter 4-digit Tunisian postal code
    </small>
</div>
    <!-- CITY -->
    <div class="mb-3">
        <label>City</label>
        <select id="ville" name="ville" class="form-control" required>
            <option value="">Select City</option>
            <option value="Tunis">Tunis</option>
            <option value="Ariana">Ariana</option>
            <option value="Ben Arous">Ben Arous</option>
            <option value="Manouba">Manouba</option>
            <option value="Nabeul">Nabeul</option>
            <option value="Bizerte">Bizerte</option>
            <option value="Beja">Béja</option>
            <option value="Jendouba">Jendouba</option>
            <option value="Zaghouan">Zaghouan</option>
            <option value="Siliana">Siliana</option>
            <option value="Kairouan">Kairouan</option>
            <option value="Kasserine">Kasserine</option>
            <option value="Sidi Bouzid">Sidi Bouzid</option>
            <option value="Sousse">Sousse</option>
            <option value="Monastir">Monastir</option>
            <option value="Mahdia">Mahdia</option>
            <option value="Sfax">Sfax</option>
            <option value="Gafsa">Gafsa</option>
            <option value="Tozeur">Tozeur</option>
            <option value="Kebili">Kébili</option>
            <option value="Gabes">Gabès</option>
            <option value="Medenine">Médenine</option>
            <option value="Tataouine">Tataouine</option>
        </select>
    </div>

    <!-- REGION (DYNAMIC) -->
    <div class="mb-3">
        <label>Region</label>
        <select id="region" name="region" class="form-control" required>
            <option value="">Select Region</option>
        </select>
    </div>

    <!-- SUBMIT -->
    <button type="submit"
            style="
                width:100%;
                padding:15px;
                border:none;
                border-radius:14px;
                background:linear-gradient(135deg,#000,#333);
                color:#fff;
                font-weight:900;
            ">
        Confirm Order →
    </button>

</form>
<script>
const regions = {

"Tunis": [
"Bab El Bhar","Bab Souika","Carthage","La Marsa","Le Bardo","El Menzah","El Omrane","El Ouardia","Ezzouhour","Hrairia","Sidi Hassine","Sidi Bou Said","La Goulette","Kram"
],

"Ariana": [
"Ariana Ville","Raoued","La Soukra","Ettadhamen","Sidi Thabet","Kalaat el Andalous"
],

"Ben Arous": [
"Ben Arous","Hammam Lif","Hammam Chott","Radès","Ezzahra","Mornag","Fouchana","Mohamedia","Medina Jedida"
],

"Manouba": [
"Manouba","Denden","Oued Ellil","Tebourba","Mornaguia","Borj El Amri","Douar Hicher"
],

"Nabeul": [
"Nabeul","Hammamet","Dar Chaabane","Menzel Temime","Korba","Kelibia","Menzel Bouzelfa","Grombalia","Soliman","Beni Khiar","Takelsa"
],

"Bizerte": [
"Bizerte","Menzel Bourguiba","Mateur","Ras Jebel","Sejnane","Ghar El Melh","Metline","Tinja"
],

"Beja": [
"Beja","Medjez El Bab","Testour","Nefza","Teboursouk","Amdoun"
],

"Jendouba": [
"Jendouba","Tabarka","Ain Draham","Fernana","Ghardimaou"
],

"Zaghouan": [
"Zaghouan","Zriba","Nadhour","Bir Mcherga","Fahs"
],

"Siliana": [
"Siliana","Makthar","Bou Arada","Gaafour","Kesra","Rouhia"
],

"Kairouan": [
"Kairouan","Haffouz","Sbikha","Oueslatia","Bouhajla","Chebika"
],

"Kasserine": [
"Kasserine","Sbeitla","Fériana","Thala","Majel Bel Abbès","Hidra"
],

"Sidi Bouzid": [
"Sidi Bouzid","Regueb","Meknassy","Jilma","Menzel Bouzaiane","Ouled Haffouz"
],

"Sousse": [
"Sousse","Hammam Sousse","Akouda","Kalaâ Kebira","Kalaâ Seghira","Sidi Bou Ali","Msaken","Enfidha","Sidi El Hani"
],

"Monastir": [
"Monastir","Skanes","Ksibet el Mediouni","Jemmal","Beni Hassen","Teboulba","Zeramdine","Moknine"
],

"Mahdia": [
"Mahdia","Ksour Essef","Chebba","Rejiche","El Jem","Bou Merdes"
],

"Sfax": [
"Sfax Ville","Sakiet Ezzit","Sakiet Eddaier","Sakiet Ezzit","Thyna","El Amra","Gremda","Agareb","Mahrès"
],

"Gafsa": [
"Gafsa","Metlaoui","Redeyef","Moularès","El Ksar","Sened"
],

"Tozeur": [
"Tozeur","Degache","Nefta","Tamerza","Hazoua"
],

"Kebili": [
"Kebili","Douz","Souk Lahad","Faouar","El Golâa"
],

"Gabes": [
"Gabes","Médenine","Matmata","Mareth","El Hamma","Zarat"
],

"Medenine": [
"Medenine","Djerba Houmt Souk","Midoun","Zarzis","Ben Guerdane","Beni Khedache"
],

"Tataouine": [
"Tataouine","Remada","Ghomrassen","Bir Lahmar","Dehiba"
]

};

document.getElementById("ville").addEventListener("change", function () {

    let ville = this.value;
    let regionSelect = document.getElementById("region");

    regionSelect.innerHTML = "<option value=''>Select Region</option>";

    if (regions[ville]) {
        regions[ville].forEach(r => {
            let option = document.createElement("option");
            option.value = r;
            option.textContent = r;
            regionSelect.appendChild(option);
        });
    }

});
</script>

</div>

<!-- RIGHT: ORDER SUMMARY -->
<div class="col-lg-5">

<div style="
    position:sticky;
    top:110px;
    background:#fff;
    padding:25px;
    border-radius:22px;
    border:1px solid #eee;
    box-shadow:0 25px 80px rgba(0,0,0,0.06);
">

    <h4 style="font-weight:900;">Your Order</h4>

    <?php
    $total = 0;

    foreach ($panier as $item):

        $stmt = $conn->prepare("SELECT * FROM produits WHERE id = ?");
        $stmt->execute([(int)$item['id']]);
        $p = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$p) continue;

        $qty = $item['qty'] ?? 1;
        $subtotal = $p['prix'] * $qty;
        $total += $subtotal;
    ?>

    <div style="display:flex;justify-content:space-between;margin-top:10px;">
        <span style="font-size:13px;">
            <?= $p['nom'] ?> × <?= $qty ?>
        </span>
        <span><?= $subtotal ?> DT</span>
    </div>

    <?php endforeach; ?>

    <hr style="margin:20px 0;">

    <div style="display:flex;justify-content:space-between;">
        <span style="font-weight:800;">Total</span>
        <span style="font-size:20px;font-weight:900;">
            <?= $total ?> DT
        </span>
    </div>

    <div style="
        margin-top:15px;
        padding:12px;
        background:#f7f7f7;
        border-radius:12px;
        font-size:12px;
        color:#555;
    ">
        🚚 Free delivery • Secure payment
    </div>

</div>

</div>

</div>
</div>

<?php include("../includes/footer.php"); ?>