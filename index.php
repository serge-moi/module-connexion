<?php

session_start();

?>

<?php require("partials/header.phtml"); ?>
                <h1 id="title-box"><span>Driv</span>ozar</h1>
<?php require("partials/footer.phtml"); ?>

<?php

    // Si un utilisateur est bien connecté
    if(isset($_SESSION["login"]))
    {
        // alors j'affiche bienvenue a l'utilisateur
        echo "<div id=\"welcome\">Bienvenue ".$_SESSION["login"]."</div>";
    } else {
        // je demande a l'utilisateur de se connecter
        echo "<div id=\"echo-co\">Veuillez vous connecter</div>";
    }
?>


