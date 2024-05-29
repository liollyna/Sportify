<?php

// Identifier le nom de la base de données
$database = "spotify2";

// Connectez-vous à votre BDD
$db_handle = mysqli_connect('localhost', 'root', '');
if (!$db_handle) {
    die("Erreur de connexion : " . mysqli_connect_error());
}
$db_found = mysqli_select_db($db_handle, $database);

// Vérifiez si la connexion à la base de données est réussie
if (!$db_found) {
    die("Erreur lors de la sélection de la base de données.");
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Action pour afficher les informations du coach pour la musculation
    if ($action == "musculation") {
        // Remplacer '1' par l'ID du coach spécifique à la musculation si nécessaire
        $query = "SELECT * FROM coachs WHERE id = 1";
        $result = mysqli_query($db_handle, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $coach = mysqli_fetch_assoc($result);

                // Afficher les informations du coach
                echo "Informations du coach Musculation :<br>";
                echo "ID : " . $coach['id'] . "<br>";
                echo "Nom : " . $coach['nom'] . "<br>";
                // Afficher d'autres informations si nécessaire
            } else {
                echo "Aucun coach trouvé avec l'ID 1.";
            }
        } else {
            echo "Erreur lors de la récupération des informations du coach : " . mysqli_error($db_handle);
        }
    }
}

// Fermez la connexion à la base de données
mysqli_close($db_handle);
?>


