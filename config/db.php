<?php
class Connexion
{
    public function CNXbase()
    {
            $dbc = new PDO('mysql:host=localhost;dbname=projetproduit;charset=utf8', 'root', '');
    
            return $dbc;
       
    }
}
?>