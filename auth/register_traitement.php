<?php
include("../config/db.php");

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$date = $_POST['date_naissance'];
$sexe = $_POST['sexe'];

// upload image
$photo = $_FILES['photo']['name'];
$tmp = $_FILES['photo']['tmp_name'];
move_uploaded_file($tmp, "../uploads/".$photo);

$sql = "INSERT INTO users (nom, prenom, email, password, sexe, date_naissance, photo)
        VALUES ('$nom','$prenom','$email','$password','$sexe','$date','$photo')";

if($conn->query($sql)){
    header("Location: login.php");
} else {
    echo "Erreur";
}
?>