<!DOCTYPE html>
<html>
<head>
  <title>Maison NAYA</title>

  <!-- BOOTSTRAP CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- TON CSS -->
  <link rel="stylesheet" href="/web2/projet/style.css">

  <!-- BOOTSTRAP JS (IMPORTANT !!!) -->
</head>


<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
  <div class="container">

    <!-- LOGO -->
    <a class="navbar-brand d-flex align-items-center" href="/web2/projet/index.php" style="text-decoration: none;">
   <img src="/web2/projet/images/logo.png" 
        alt="Maison NYA Logo" 
        class="logo-minimalist">
   
   <div class="separator"></div>

   <div class="brand-signature">
      <span class="m-text">MAISON</span>
      <span class="n-text">NAYA</span>
   </div>
</a>
<!-- BOOTSTRAP JS (IMPORTANT) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- HAMBURGER -->
    <button class="navbar-toggler" type="button"
      data-bs-toggle="collapse"
      data-bs-target="#menu"
      aria-controls="menu"
      aria-expanded="false"
      aria-label="Toggle navigation">

      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENU -->
    <div class="collapse navbar-collapse" id="menu">

      <!-- LEFT MENU -->
      <ul class="navbar-nav me-auto">

        <li class="nav-item">
          <a class="nav-link" href="/web2/projet/index.php">Home</a>
        </li>

        <!-- MEN -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            Men
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/web2/projet/produits/liste.php?cat=men&style=running">Running</a></li>
            <li><a class="dropdown-item" href="/web2/projet/produits/liste.php?cat=men&style=basketball">Basketball</a></li>
            <li><a class="dropdown-item" href="/web2/projet/produits/liste.php?cat=men&style=lifestyle">Lifestyle</a></li>
            <li><a class="dropdown-item" href="/web2/projet/produits/liste.php?cat=men&style=training">Training</a></li>
          </ul>
        </li>

        <!-- WOMEN -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            Women
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/web2/projet/produits/liste.php?cat=women&style=running">Running</a></li>
            <li><a class="dropdown-item" href="/web2/projet/produits/liste.php?cat=women&style=fitness">Fitness</a></li>
            <li><a class="dropdown-item" href="/web2/projet/produits/liste.php?cat=women&style=fashion">Fashion</a></li>
          </ul>
        </li>

        <!-- KIDS -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            Kids
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/web2/projet/produits/liste.php?cat=kids&style=running">Running</a></li>
            <li><a class="dropdown-item" href="/web2/projet/produits/liste.php?cat=kids&style=sport">Sport</a></li>
            <li><a class="dropdown-item" href="/web2/projet/produits/liste.php?cat=kids&style=casual">Casual</a></li>
          </ul>
        </li>

      </ul>

      <!-- SEARCH -->
      <form class="d-flex me-3 search-bar">
        <input class="form-control" type="search" placeholder="Search sneakers...">
      </form>

      <!-- ICONS -->
      <div class="d-flex gap-3 align-items-center">

        <!-- FAVORIS -->
        <a href="#" class="fs-5 text-dark" title="Favorites">❤️</a>

        <!-- PANIER -->
        <a href="#" class="fs-5 text-dark" title="Cart">🛒</a>

        <?php if(!isset($_SESSION['user'])) { ?>

          <!-- NOT LOGGED -->
          <a href="/web2/projet/auth/login.php" class="btn btn-outline-dark btn-sm">
            Login
          </a>

          <a href="/web2/projet/auth/register_form.php" class="btn btn-dark btn-sm">
            Sign up
          </a>

        <?php } else { ?>

         <!-- LOGGED -->

<?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin') { ?>

  <!-- ADMIN BUTTON -->
  <a href="/web2/projet/admin/dashboard.php" class="btn btn-warning btn-sm">
    Dashboard
  </a>

<?php } ?>

<a href="/web2/projet/user/profile.php" class="btn btn-dark btn-sm">
  Profile
</a>

<a href="/web2/projet/auth/logout.php" class="btn btn-outline-dark btn-sm">
  Logout
</a>

        <?php } ?>

      </div>

    </div>
  </div>
</nav>