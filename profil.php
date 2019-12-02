<?php

session_start();

// Je me connecte a ma base de donnée
$connexion = mysqli_connect("localhost", "root", "", "moduleconnexion");
// Je récupère tout mes informations dans ma table utilisateurs quand login est égale au login que je viens de connecter
$query="SELECT * from utilisateurs WHERE login = '".$_SESSION['login']."' ";
$resultat=mysqli_query($connexion,$query);
// J'utilise mysqli_fetch_array qui est similaire a fetch_all mais qui est un tableau un peu différent
$row=mysqli_fetch_array($resultat);


require("partials/header.phtml");
?>
            <h1 id="title-box3">Modifiez votre profil</h1>
            <form id="form-log" action="profil.php" method="POST">
                <input class="input-form-log" type="text" name="login" value="<?php echo $row["login"] ?>">
                <input class="input-form-log" type="text" name="prenom" value="<?php echo $row["prenom"] ?>">
                <input class="input-form-log" type="text" name="nom" value="<?php echo $row["nom"] ?>">
                <input class="input-form-log" type="password" name="password" value="<?php echo $row["password"] ?>">
                <input class="input-form-log" type="password" name="confirmPassword">
                <button id="sub-form-log" type="submit" name="modifier" value="modifier">Modifier</button>
            </form>
<?php
require("partials/footer.phtml");

// Si la variable $_POST["modifier"] contient quelque chose
if(isset($_POST["modifier"])){
    // Je me connecte a ma base de donnée
    $connexion = mysqli_connect("localhost", "root", "", "moduleconnexion");
    $login = $_POST["login"];
    $requete2 = "SELECT login FROM utilisateurs WHERE login = \"$login\" ";
    $query2 = mysqli_query($connexion,$requete2);
    $resultat2 = mysqli_fetch_all($query2);
    // Si il y a quelque chose dans ma variable de requete resultat
    if(!empty($resultat2)){
        // Alors j'affiche que le login estdeja prit
        echo "<div id=\"pro-log-used\">Ce login est déjà pris</div>";
    } // Sinon si le password soumis est différent de la confirmation de password soumise
    else if ($_POST["password"] != $_POST["confirmPassword"]){
        // Alors j'affiche que le mots de passe ne correspond pas
        echo "<div id=\"pro-mdp-false\">Les mots de passe ne correspondent pas</div>";
    } // Sinon
    else{
        // Si le login que j'ai soumis est différent du login de ma base de donnée initiale
        if($_POST["login"] != $row["login"]){
            // Je me connecte a la base de donnée
            $connexion = mysqli_connect("localhost", "root","","moduleconnexion");
            // je modifie dans la table utilisateurs le login que je viens d'entrer et je vais le mettre dans la boite ou il y avait l'ancien login
            $query = "UPDATE utilisateurs SET login = '".$_POST['login']."' WHERE utilisateurs.login='".$row['login']."' ";
            $resultat = mysqli_query($connexion,$query);
        }
        if($_POST['prenom'] != $row['prenom']){
			$connexion = mysqli_connect("localhost","root","","moduleconnexion");
			$query = "UPDATE utilisateurs SET prenom = '".$_POST['prenom']."' WHERE utilisateurs.prenom='".$row['prenom']."'";
		    $resultat = mysqli_query($connexion, $query);
        }
        if($_POST['nom'] != $row['nom']){
		   $connexion = mysqli_connect("localhost","root","","moduleconnexion");
		   $query = "UPDATE utilisateurs SET nom = '".$_POST['nom']."' WHERE utilisateurs.nom='".$row['nom']."'";
		   $resultat = mysqli_query($connexion, $query);
		}
		if($_POST['password'] != $row['password']){
		   $connexion = mysqli_connect("localhost","root","","moduleconnexion");
		   $query = "UPDATE utilisateurs SET password = '".$_POST['password']."' WHERE utilisateurs.password='".$row['password']."'";
		   $resultat = mysqli_query($connexion, $query);
		}    
    }
} 


?>
