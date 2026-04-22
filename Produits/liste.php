<?php
require_once("../config/db.php");
include("../includes/header.php");

$connexion = new Connexion();
$conn = $connexion->CNXbase();

$sql = "SELECT * FROM produits";
$stmt = $conn->query($sql);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
<h2 class="mb-4">Nos Chaussures</h2>

<div class="row">
<?php foreach($produits as $p){ ?>
    <div class="col-md-3">
        <div class="card shadow-sm mb-4">

            <img src="../uploads/<?php echo $p['image']; ?>" class="card-img-top">

            <div class="card-body text-center">
                <h5><?php echo $p['nom']; ?></h5>
                <p class="text-muted"><?php echo $p['prix']; ?> DT</p>

                <a href="detail.php?id=<?php echo $p['id']; ?>" class="btn btn-dark btn-sm">Voir</a>
            </div>

        </div>
    </div>
<?php } ?>
</div>
</div>

<?php include("../includes/footer.php"); ?>