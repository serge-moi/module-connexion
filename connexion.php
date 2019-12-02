<?php

session_start();

require("partials/header.phtml");
require("partials/footer.phtml");

$connexion = mysqli_connect("localhost", "root", "", "moduleconnexion");
$requete = "SELECT * FROM utilisateurs";
$query = mysqli_query($connexion, $requete);
$resultat = mysqli_fetch_all($query);

// Compte n'existe pas
$compte = false;

// Si on est connecté
if(isset($_POST["connexion"]) == true){
    // Je boucle sur ma requete pour recuperer les valeurs
    foreach($resultat as $key => $value){
        // Si la valeur 1 de la clef de ma requete est égale a l'élément login de mon tableau post et que la valeur 4 de ma requete est égale a l'élement password de mon tableau
        if($resultat[$key][1] == $_POST["login"] && $resultat[$key][4] == $_POST["password"]){
            // Alors compte existe
            $compte = true;
        }
    }
    // Si le compte existe
    if($compte == true){
        // J'ouvre une nouvelle session
        
        // J'attribue a ma session le login que je viens de soumettre
        $_SESSION["login"] = $_POST["login"];
        header("Location:index.php");
        // J'affiche bienvenue a l'utilisateur
        echo "Bienvenue".$_SESSION['login'];
    } else {
        echo "<div id='error-login'>Login ou mot de passe incorrect</div>";
    }

}

// <!-- // Si il n'y a pas de session ouverte -->
if(!isset($_SESSION["login"])): 
    require("partials/header.phtml"); ?>
        <h1 id="title-box"><span>Driv</span>ozar</h1>
        <form id="form-co" action="" method="post">
        <div id="input-box">
            <input class="input-form-co" type="text" name="login" placeholder="Login">
            <input class="input-form-co" type="password" name="password" placeholder="Password">
        </div>
        <button id="sub-form-co" type="submit" name="connexion">Se connecter</button>
        </form>
<?php require("partials/footer.phtml");  endif; ?>

<?php

// Si un nom d'utilisateur a été soumis
if(isset($_POST["login"])){
    // Alors je le stock dans une variable
    $login = $_POST["login"];
    // Sinon
} else {
    $login="";
}
if(isset($_SESSION["login"])){
// Si le tableau session contient le login correspondant a l'utilisateur
if($_SESSION["login"] == "admin"){
    // Je le redirige vers la page admin.php
    header("Location:admin.php");
}
}
// je ferme la connexion a la base de donnée
mysqli_close($connexion);

?>


