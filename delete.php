<?php
    $connexion = mysqli_connect("localhost", "root", "", "moduleconnexion");
    $delete = $_POST["delete"];
    $requete = "DELETE FROM utilisateurs WHERE id = '$delete'";
    $query = mysqli_query($connexion, $requete);
    header("Location:admin.php");
    die(); 
?>
