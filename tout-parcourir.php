<?php
$database = "bdd";
$db_handle = mysqli_connect('localhost', 'root', '', $database);

if (!$db_handle) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

if (isset($_POST['sports'])) {
    $query = "SELECT * FROM activites";
    $result = mysqli_query($db_handle, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($activity = mysqli_fetch_assoc($result)) {
            echo '<li>' . htmlspecialchars($activity['nom']) . '</li>';
        }
    } else {
        echo 'Aucune activité sportive trouvée.';
    }
}

// Vérifiez l'action à effectuer
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Action "ajouter" pour la musculation
    if ($action == "A") {
        // Récupérer les informations du coach avec l'id 1
        $query = "SELECT * FROM coachs WHERE id = 1";
        $result = mysqli_query($db_handle, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                // Récupérer les données du coach
                $coach = mysqli_fetch_assoc($result);

                // Afficher les informations du coach
                echo "Informations du coach A :<br>";
                echo "ID : " . $coach['id'] . "<br>";
                echo "Nom : " . $coach['nom'] . "<br>";
                echo "Photo : <img src='" . $coach['photo'] . "' alt='Photo du coach' width='100'><br>"; // Affichage de l'image du coach
                echo "Bureau : " . $coach['bureau'] . "<br>";
                echo "Téléphone : " . $coach['Telephone'] . "<br>";
                echo "Email : " . $coach['Email'] . "<br>";
                // Afficher d'autres informations si nécessaire
            } else {
                echo "Aucun coach trouvé avec l'ID 1.";
            }
        } else {
            echo "Erreur lors de la récupération des informations du coach : " . mysqli_error($db_handle);
        }
    }



if ($action == "B") {
    // Récupérer les informations du coach avec l'id 1
    $query = "SELECT * FROM coachs WHERE id = 2";
    $result = mysqli_query($db_handle, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Récupérer les données du coach
            $coach = mysqli_fetch_assoc($result);

            // Afficher les informations du coach
            echo "Informations du coach B :<br>";
            echo "ID : " . $coach['id'] . "<br>";
            echo "Nom : " . $coach['nom'] . "<br>";
            echo "Photo : <img src='" . $coach['photo'] . "' alt='Photo du coach' width='100'><br>"; // Affichage de l'image du coach
            echo "Bureau : " . $coach['bureau'] . "<br>";
            echo "Téléphone : " . $coach['Telephone'] . "<br>";
            echo "Email : " . $coach['Email'] . "<br>";
            // Afficher d'autres informations si nécessaire
        } else {
            echo "Aucun coach trouvé avec l'ID 2.";
        }
    } else {
        echo "Erreur lors de la récupération des informations du coach : " . mysqli_error($db_handle);
    }
}
if ($action == "C") {
    // Récupérer les informations du coach avec l'id 1
    $query = "SELECT * FROM coachs WHERE id = 3";
    $result = mysqli_query($db_handle, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Récupérer les données du coach
            $coach = mysqli_fetch_assoc($result);

            // Afficher les informations du coach
            echo "Informations du coach C :<br>";
            echo "ID : " . $coach['id'] . "<br>";
            echo "Nom : " . $coach['nom'] . "<br>";
            echo "Photo : <img src='" . $coach['photo'] . "' alt='Photo du coach' width='100'><br>"; // Affichage de l'image du coach
            echo "Bureau : " . $coach['bureau'] . "<br>";
            echo "Téléphone : " . $coach['Telephone'] . "<br>";
            echo "Email : " . $coach['Email'] . "<br>";
            // Afficher d'autres informations si nécessaire
        } else {
            echo "Aucun coach trouvé avec l'ID 3.";
        }
    } else {
        echo "Erreur lors de la récupération des informations du coach : " . mysqli_error($db_handle);
    }
}

}

$query_all = "SELECT activites.nom AS activites, coachs.*, creneaux.date AS creneaux, messages.contenu AS messages, rendez_vous.date AS rendez_vous, utilisateurs.nom AS utilisateurs
              FROM activites
              INNER JOIN coachs ON activites.id = coachs.activite_id
              INNER JOIN creneaux ON coachs.id = creneaux.coach_id
              INNER JOIN messages ON coachs.id = messages.coach_id
              INNER JOIN rendez_vous ON coachs.id = rendez_vous.coach_id
              INNER JOIN utilisateurs ON messages.utilisateur_id = utilisateurs.id";

$result_all = mysqli_query($db_handle, $query_all);

if ($result_all && mysqli_num_rows($result_all) > 0) {
    echo "<h2>Liste des enregistrements</h2>";
    echo "<table border='1'>
            <tr>
                <th>Activités</th>
                <th>ID Coach</th>
                <th>Nom Coach</th>
                <th>Photo</th>
                <th>CV</th>
                <th>Bureau</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Date Créneaux</th>
                <th>Messages</th>
                <th>Date Rendez-vous</th>
                <th>Utilisateurs</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result_all)) {
        echo "<tr>
                <td>".$row["activites"]."</td>
                <td>".$row["id"]."</td>
                <td>".$row["nom"]."</td>
                <td><img src='" . $row["photo"] . "' alt='Photo du coach' width='100'></td>
                <td>".$row["CV"]."</td>
                <td>".$row["bureau"]."</td>
                <td>".$row["Telephone"]."</td>
                <td>".$row["Email"]."</td>
                <td>".$row["creneaux"]."</td>
                <td>".$row["messages"]."</td>
                <td>".$row["rendez_vous"]."</td>
                <td>".$row["utilisateurs"]."</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "0 résultats";
}

// Fermez la connexion à la base de données
mysqli_close($db_handle);
?>
