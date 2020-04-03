<?php

session_start();

$connexion = mysqli_connect("localhost", "root", "", "moduleconnexion");
$requete="SELECT * from utilisateurs WHERE login = '".$_SESSION['login']."' ";
$query=mysqli_query($connexion,$requete);
$resultat=mysqli_fetch_assoc($query);

if(isset($_POST["modifier"])){
    $requete2 = "UPDATE utilisateurs SET login='".$_POST['login']."', prenom='".$_POST["prenom"]."', nom='".$_POST["nom"]."' WHERE login='".$_SESSION['login']."'";

        if($resultat['login'] != $_POST['login']){
            mysqli_query($connexion,$requete2);
            $_SESSION['login'] = $_POST['login'];
            header('Location:index.php');
        }
        else if($resultat["prenom"] != $_POST["prenom"]){
            mysqli_query($connexion,$requete2);
            header("Location:index.php");
        }
        else if($resultat["nom"] != $_POST["nom"]){
            mysqli_query($connexion,$requete2);
            header("Location:index.php");
        }
        else if($resultat['password'] != $_POST['password']){
            if($_POST['password'] != NULL && $_POST["password"] == $_POST["confirmPassword"]){
                $pass=$_POST['password'];
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $requete2 = "UPDATE utilisateurs SET password='".$hash."' WHERE login = '".$_SESSION['login']."'";
                mysqli_query($connexion,$requete2);
                header("Location:index.php"); 
            } else {
                $erreur ="Les mots de passes ne correspondent pas";
            }
        } else {
            $erreur = "Erreur lors du changement d'informations";
        }
}

require("partials/header.phtml");
?>
            <h1 id="title-box3">Modifiez votre profil</h1>
            <form id="form-log" action="profil.php" method="POST">
            <?php if(isset($erreur)): ?>
                <div id="error-mod"><?php echo $erreur; ?></div>
            <?php endif; ?>
                <input class="input-form-log" type="text" name="login" placeholder="login" value="<?php echo $resultat["login"] ?>">
                <input class="input-form-log" type="text" name="prenom" placeholder="prenom" value="<?php echo $resultat["prenom"] ?>">
                <input class="input-form-log" type="text" name="nom" placeholder="nom" value="<?php echo $resultat["nom"] ?>">
                <input class="input-form-log" type="password" placeholder="mot de passe" name="password" value="<?php echo $resultat["password"] ?>">
                <input class="input-form-log" type="password" placeholder="mdp confirm" name="confirmPassword">
                <button id="sub-form-log" type="submit" name="modifier" value="modifier">Modifier</button>
            </form>
<?php
require("partials/footer.phtml");


?>
