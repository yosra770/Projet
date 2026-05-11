<?php include("includes/header.php"); ?>
<!-- HERO -->
<section class="hero-slider">

  <div class="slide active" style="background-image:url('https://www.doitinparis.com/files/eshop/collections/343//thumbs-1760x525/mode-sneakers-fevrier-2025.jpg')">
    <div class="overlay"></div>
    <div class="content">
      <h1>Step Into Style</h1>
      <p>Sneakers premium collection</p>
      <a href="#" class="btn-main">Shop Now</a>
    </div>
  </div>

  <div class="slide" style="background-image:url('/web2/projet/images/baskt.jpg')">
    <div class="overlay"></div>
    <div class="content">
      <h1>New Drops</h1>
      <p>Latest sneaker trends</p>
      <a href="#" class="btn-main">Discover</a>
    </div>
  </div>

  <div class="slide" style="background-image:url('/web2/projet/images/basket1.jpg')">
    <div class="overlay"></div>
    <div class="content">
      <h1>Premium Quality</h1>
      <p>Only the best brands</p>
      <a href="#" class="btn-main">Shop Now</a>
    </div>
  </div>

</section>

<!-- FEATURES -->
<section class="container py-5 text-center">
  <div class="row g-4">

    <div class="col-md-4">
      <div class="feature-box">
        🚚
        <h5>Fast delivery</h5>
        <p>Throughout Tunisia</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="feature-box">
        💳
        <h5>Secure Payment</h5>
        <p>100% Reliable</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="feature-box">
        🔥
        <h5>Premium Quality</h5>
        <p>Best brands</p>
      </div>
    </div>

  </div>
</section>

<!-- BEST SELLERS -->
<section class="container py-5">

  <div class="section-title text-center mb-5">
    <h2>Best Sellers</h2>
    <p>Most popular sneakers this week</p>
  </div>

  <div class="row">
<script>
let slides = document.querySelectorAll(".slide");
let index = 0;

setInterval(() => {
  slides[index].classList.remove("active");
  index = (index + 1) % slides.length;
  slides[index].classList.add("active");
}, 3000);
</script>
<?php
require_once(__DIR__ . "/config/db.php");

$connexion = new \Connexion();
$conn = $connexion->CNXbase();

$result = $conn->query("SELECT * FROM produits LIMIT 6");

while($row = $result->fetch(PDO::FETCH_ASSOC)) {
?>

    <div class="col-md-4 mb-4">
      <div class="product-card position-relative">

        <!-- RUBAN -->
        <div class="badge-ribbon">
          Best Seller
        </div>

        <!-- IMAGE (temporaire) -->
        <img src="/web2/projet/uploads/<?php echo $row['image']; ?>" alt="product">

        <h5><?php echo $row['nom']; ?></h5>
        <p><?php echo $row['prix']; ?> DT</p>

        
        <a  class="btn-main" href="/web2/projet/produits/detail.php?id=<?= $row['id'] ?>">
    Add to cart
</a>
      </div>
    </div>

<?php } ?>

  </div>
</section>

<?php include("includes/footer.php"); ?>