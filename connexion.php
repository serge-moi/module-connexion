<?php

session_start();

if(isset($_SESSION["login"])){
    header("Location: index.php");
    die;
}

if(isset($_POST["connexion"])){
    $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password");
    $hash = password_hash($password, PASSWORD_DEFAULT);
    if(!empty($login) && !empty($password)){
        $connexion = mysqli_connect("localhost", "root", "", "moduleconnexion");
        $requete = "SELECT * FROM utilisateurs WHERE login = \"$login\"";
        $query = mysqli_query($connexion, $requete);
        $resultat = mysqli_fetch_all($query);
        // var_dump($resultat);
        if(!empty($resultat)){
            if(password_verify($password, $resultat[0][4])){
                $_SESSION["login"] = $login;
                $_SESSION["password"] = $password;
                $_SESSION["id"] = $resultat[0][0];
                header("Location:index.php");
                echo "Bienvenue".$_SESSION['login'];
            }
            else{
                $erreur = "Mauvais login ou mot de passe !";
            }
        }
        else{
            $erreur = "Cet identifiant n'existe pas";
        }
    }
    else{
        $erreur = "Tous les champs doivent être complétés !";
    }
}

if(!isset($_SESSION["login"])):
    require("partials/header.phtml"); ?>
        <h1 id="title-box"><span>Driv</span>ozar</h1>
        <form id="form-co" action="" method="post">
        <?php if(isset($erreur)): ?>
            <div id="error-co"><?php echo $erreur; ?></div>
        <?php endif; ?>
        <div id="input-box">
            <input class="input-form-co" type="text" name="login" placeholder="Login">
            <input class="input-form-co" type="password" name="password" placeholder="Password">
        </div>
        <button id="sub-form-co" type="submit" name="connexion">Se connecter</button>
        </form>
<?php require("partials/footer.phtml");  endif; 

if(isset($_SESSION["login"])){
    if($_SESSION["login"] == "admin"){
        header("Location:admin.php");
    }
}

?>


