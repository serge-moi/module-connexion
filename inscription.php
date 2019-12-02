<?php

session_start();

// On commence par récuperer les champs

// Si la variable $_POST["nom"] existe
    if(isset($_POST["nom"]))
    {
// Je la mets dans une variable nommé nom
        $nom=$_POST["nom"];
    }
    else
    {
// Sinon la variable est vide
        $nom="";
    }

    if(isset($_POST["prenom"]))
	{
		$prenom=$_POST["prenom"];
	}
	else      
	{
			$prenom="";
	}



	if(isset($_POST["login"]))
	{
		$login=$_POST["login"];
	}      
	else 
	{
		$login="";
	}     



	if(isset($_POST["password"]))
	{
		$password=$_POST["password"];
	}      
	else
	{
		$password="";
	}     

	if(isset($_POST["confirmPassword"])) 
	{
		 $confirmPassword=$_POST["confirmPassword"];
	}    
	else  
	{
		 $confirmPassword="";
    }
    

// Si le formulaire est validé, donc qu'il existe, ["confirm"] est le nom de mon input submit
    if(isset($_POST["confirm"]))
    {
        // Alors je me connecte a ma base de donnée
        $connexion = mysqli_connect("localhost", "root", "", "moduleconnexion");
        // Je crée ma requete, je selectionne le login dans la table utilisateurs quand le login est le nom de la personne qu'on vient d'entrer
        $requete = "SELECT login FROM utilisateurs WHERE login = \"$login\" ";
        // J'envoie ma base de donnée et ma requete
        $query = mysqli_query($connexion, $requete);
        // On recupere tout avec fetchall
        $resultat = mysqli_fetch_all($query);
        // Si il y a quelque chose dans la requete c'est que le login est deja pris
        if(!empty($resultat)){
            echo "<div id=\"sub-log-used\">Ce login est déjà pris</div>";
        // Sinon si le mot de passe est différent de la confirmation de mot de passe
        } else if($_POST["password"] != $_POST["confirmPassword"]){
            echo "<div id=\"sub-mdp-false\">Les mots de passe ne correspondent pas</div>";
        } else {
        // Sinon je fais une requete pour inserer un nouvelle utilisateur
            $requete = "INSERT INTO utilisateurs (login, prenom, nom, password) VALUES ('$login', '$prenom', '$nom', '$password')";
            $query = mysqli_query($connexion, $requete);
            header("Location:connexion.php");
        }
    }

?>



<?php require("partials/header.phtml"); ?>
            <h1 id="title-box2">Inscrivez vous</h1>
            <form id="form-sub" action="inscription.php" method="POST">
                <input class="put-form-sub" type="text" name="login" placeholder="Votre login" >
                <input class="put-form-sub" type="text" name="prenom" placeholder="Votre prénom">
                <input class="put-form-sub" type="text" name="nom" placeholder="Votre nom" >
                <label class="lab-form-sub" for="pass">Votre mot de passe : entre 5 et 10 caractères</label>
                <input class="put-form-sub" type="password" name="password" minlength="5" maxlength="10" >
                <label class="lab-form-sub" for="pass">Confirmer le mot de passe :</label>
                <input class="put-form-sub" type="password" name="confirmPassword" minlength="5" maxlength="10">
                <button id="sub-form-sub" type="submit" name="confirm">Valider</button>
            </form>
<?php require("partials/footer.phtml");






