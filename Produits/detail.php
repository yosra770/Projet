<?php
require_once("../config/db.php");
include("../includes/header.php");

$conn = (new Connexion())->CNXbase();

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM produits WHERE id = :id");
$stmt->execute(['id' => $id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
<div class="card p-4 shadow text-center">

    <img src="../uploads/<?php echo $p['image']; ?>" style="width:300px" class="mx-auto">

    <h2><?php echo $p['nom']; ?></h2>
    <p><?php echo $p['description']; ?></p>
    <h3 class="text-success"><?php echo $p['prix']; ?> DT</h3>

</div>
</div>

<?php include("../includes/footer.php"); ?>