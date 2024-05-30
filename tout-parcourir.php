<?php
$database = "spotify2";
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
                echo "photo :" .$coach['photo'] . "<br>";
                echo "bureau :" .$coach['bureau'] . "<br>";
                echo "Telephone :" .$coach['Telephone'] . "<br>";
                echo "Email :" .$coach['Email'] . "<br>";
                // Afficher d'autres informations si nécessaire
            } else {
                echo "Aucun coach trouvé avec l'ID 1.";
            }
        } else {
            echo "Erreur lors de la récupération des informations du coach : " . mysqli_error($db_handle);
        }
    }
}

$query_all = "SELECT * FROM activites, coachs, disponibilites, messages, rendez_vous, utilisateurs";
$result_all = mysqli_query($db_handle, $query_all);

if ($result_all && mysqli_num_rows($result_all) > 0) {
    echo "<h2>Liste des enregistrements</h2>";
    echo "<table border='1'>
            <tr>
                <th>activites</th>
                <th>coachs</th>
                <th>disponibilites</th>
                <th>messages</th>
                <th>rendez_vous</th>
                <th>utilisateurs</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result_all)) {
        echo "<tr>
                <td>".$row["activites"]."</td>
                <td>".$row["coachs"]."</td>
                <td>".$row["disponibilites"]."</td>
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
