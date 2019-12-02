<?php

    session_start();

    $connexion = mysqli_connect("localhost", "root", "", "moduleconnexion");

    $requete = "SELECT * FROM utilisateurs";

    $query = mysqli_query($connexion, $requete);

    $resultat = mysqli_fetch_all($query);


?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
            // Si il y a quelque chose dans la variable session
            if(!empty($_SESSION)):
                // Si il y a un utilisateur connecté et que cette utilisateur est l'admin
                if($_SESSION["login"] == "admin"): ?>
                    <!-- // J'affiche le tableau -->
                <?php require("partials/header.phtml"); ?>
                    <table id="tbl-admin" >
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Login</th>
                                <th>Prénom</th> 
                                <th>Nom</th>
                                <th>Mot de passe</th>
                            </tr>
                        </thead>
                        </tbody>
                        <?php if(isset($_POST["delete"])){
                            echo "L'utilisateur " . $_POST['delete']. " a bien été supprimé";
                        }
                        ?>
                            <!-- // Je boucle dans le tableau de la requete et je recupere son contenu -->
                        <?php foreach($resultat as $cle => $valeur): ?>
                                <tr>
                                <!-- // Je boucle dans le tableau valeur et pour chaque valeur j'affiche le contendu via l'id -->
                                <?php foreach($valeur as $id => $value): ?>
                                <td><?php echo $value ?></td>
                                <?php endforeach; ?>
                                </tr>
                        <?php endforeach; ?>
                        
                        </tbody>
                    </table>
                <?php require("partials/footer.phtml"); ?>
                <?php else: ?>
                    <?php echo "Vous n'avez pas accès à cette page."; ?>
                    <?php  mysqli_close($connexion); ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(isset($_POST["delete"]) == "45"): ?>
                            <?php header("Location:admin.php");
                                echo "Vous ne pouvez pas supprimer ce compte"; ?>
                        <?php else : ?>
                            <div id="admin-form">
                                <h2 id="title-admin2">Entrez l'identifiant de l'utilisateur a supprimer</h2>
                                <form id="form-of-admin" action="delete.php" method="post">
                                    <input id="admin-put-del" type="number" name="delete" id="delete" placeholder="example = 21" />
                                    <input id="admin-put-sub-del" type="submit" value="Supprimer" />
                                </form>
                            </div>
                        <?php endif; ?>
    </body>
</html>