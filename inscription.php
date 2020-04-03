<?php

session_start();

if(isset($_SESSION["login"])){
    header("Location: index.php");
    die;
}


if(isset($_POST["confirm"])){
    $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_SPECIAL_CHARS);
    $prenom = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_SPECIAL_CHARS);
    $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password");
    $password2 = filter_input(INPUT_POST, "password2");
    $hash = password_hash($password, PASSWORD_DEFAULT);



    // Si elles ne sont pas vide
    if(!empty($login) && !empty($prenom) && !empty($nom) && !empty($password)){
        


        $loginsize = strlen($login);
        if($loginsize <= 255){
            $connexion = mysqli_connect("localhost", "root", "", "moduleconnexion");
            $requete = "SELECT login FROM utilisateurs WHERE login = \"$login\" ";
            $query = mysqli_query($connexion, $requete);
            $resultat = mysqli_fetch_all($query);
            if(!empty($resultat)){
                echo "Ce login est déjà pris";
            }else{
                if($password == $password2){
                    $requete = "INSERT INTO utilisateurs(login, prenom, nom, password) VALUES ('$login','$prenom','$nom','$hash')";
                    $query = mysqli_query($connexion, $requete);
                    header("Location:index.php");
                }
                else{
                    
                    $erreur = "Vos mots de passes ne correspondent pas !";
                }
            }
        }
        else
        {
            $erreur = "Votre pseudo ne doit pas dépasser 255 caractères";
        }
    } else {
        $erreur = "Tous les champs doivent être completé";
    }
}



require("partials/header.phtml"); ?>
            <h1 id="title-box2">Inscrivez vous</h1>
            <form id="form-sub" action="inscription.php" method="POST">
            <?php if(isset($erreur)): ?>
                <div id="error-sub"><?php echo $erreur; ?></div>
            <?php endif; ?>
                <input class="put-form-sub" type="text" name="login" placeholder="Votre login" >
                <input class="put-form-sub" type="text" name="prenom" placeholder="Votre prénom">
                <input class="put-form-sub" type="text" name="nom" placeholder="Votre nom" >
                <label class="lab-form-sub" for="pass">Votre mot de passe : entre 5 et 10 caractères</label>
                <input class="put-form-sub" type="password" name="password">
                <label class="lab-form-sub" for="pass">Confirmer le mot de passe :</label>
                <input class="put-form-sub" type="password" name="password2">
                <button id="sub-form-sub" type="submit" name="confirm">Valider</button>
            </form>
<?php require("partials/footer.phtml");






