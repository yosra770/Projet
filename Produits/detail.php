<?php
require_once("../config/db.php");
include("../includes/header.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

$id = $_GET['id'];

$sql = "SELECT * FROM produits WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $id]);

$p = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <div class="card p-4 shadow">

        <img src="../uploads/<?php echo $p['image']; ?>" style="width:300px">

        <h2><?php echo $p['nom']; ?></h2>
        <p><?php echo $p['description']; ?></p>
        <h4><?php echo $p['prix']; ?> DT</h4>

    </div>
</div>

<?php include("../includes/footer.php"); ?>