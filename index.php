<?php
// Fusion avec la classe voiture
require_once 'classes/User.php';

$pdo = new PDO("mysql:host=mysql8;dbname=FluffyRagdolls", "root", "root_password");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fil rouge php - FluffyRagdolls</title>
</head>
<body>
    <?php

    // Instanciation de l'utilisateur
    $moi1 = new User("AgatheDups","agathe.dupuis@gmail.com","MotDePasse3210" ,"Gouvieux",false);
    $moiEleveur = new User("Pseudo4","prenom.nom@gmail.com","MotDePasse1234" ,"Paris",true,220184,"0680945843");


    // // Contenu de l'objet instancié
    // var_dump($moi1);
    // echo "<br/><br/>";
    // var_dump($moiEleveur);
    ?>
    <h2>Utilisateur instancié en php :</h2>
    <table border='1'>
        <thead>
            <tr>
                <th> </th>
                <th>Données user 1</th>
                <th>Données user 2</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Pseudo</th>
                <td><?php echo $moi1 -> getPseudo() ; ?></td>
                <td><?php echo $moiEleveur -> getPseudo() ; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $moi1 -> getEmail() ; ?></td>
                <td><?php echo $moiEleveur -> getEmail() ; ?></td>
            </tr>
            <tr>
                <th>Mot de passe</th>
                <td><?php echo $moi1 -> getPassword() ; ?></td>
                <td><?php echo $moiEleveur -> getPassword() ; ?></td>
            </tr>
            <tr>
                <th>Ville</th>
                <td><?php echo $moi1 -> getCity() ; ?></td>
                <td><?php echo $moiEleveur -> getCity() ; ?></td>
            </tr>
            <tr>
                <th>Eleveur</th>
                <td><?php echo $moi1 -> getIsBreeder() ; ?></td>
                <td><?php echo $moiEleveur -> getIsBreeder() ; ?></td>
            </tr>
            <tr>
                <th>Siret</th>
                <td><?php echo $moi1 -> getSiret() ; ?></td>
                <td><?php echo $moiEleveur -> getSiret() ; ?></td>
            </tr>
            <tr>
                <th>Numéro de telephone</th>
                <td><?php echo $moi1 -> getPhoneNumber() ; ?></td>
                <td><?php echo $moiEleveur -> getPhoneNumber() ; ?></td>
            </tr>
        </tbody>
    </table>
    <br>

    <h2>Utilisateur dans la base de donnée:</h2>
    <?php
    // With BDD
    $id = 2;

    // Retrieve user by ID
    $user = User::findById($pdo, $id);

    if ($user) {
        $user->displayUser();
    } else {
        echo "Aucun utilisateur trouvé avec l'ID : " . $id;
    }
    ?>
    
</body>
</html>