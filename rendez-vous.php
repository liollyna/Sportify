<?php
// Informations de connexion à la base de données
$database = "spotify2";
$db_handle = mysqli_connect('localhost', 'root', '', $database);

if (!$db_handle) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    $action = $_REQUEST['action'];

    switch ($action) {
        case 'consult':
            $activite_id = $_GET['activite'];

            // Requête pour obtenir les créneaux disponibles pour une activité donnée
            $sql_creneaux = "SELECT coachs.nom AS coach, disponibilites.date, disponibilites.heure_debut, disponibilites.heure_fin, activites.nom AS activite
                             FROM coachs
                             JOIN disponibilites ON coachs.id = disponibilites.coach_id
                             JOIN activites ON activites.id = $activite_id
                             ORDER BY disponibilites.date, disponibilites.heure_debut";

            $result_creneaux = mysqli_query($db_handle, $sql_creneaux);

            if (mysqli_num_rows($result_creneaux) > 0) {
                echo "<h2>Créneaux Disponibles</h2>";
                echo "<table>
                        <tr>
                            <th>Date</th>
                            <th>Heure Début</th>
                            <th>Heure Fin</th>
                            <th>Activité</th>
                            <th>Coach</th>
                        </tr>";
                while ($row = mysqli_fetch_assoc($result_creneaux)) {
                    echo "<tr>
                            <td>" . $row['date'] . "</td>
                            <td>" . $row['heure_debut'] . "</td>
                            <td>" . $row['heure_fin'] . "</td>
                            <td>" . $row['activite'] . "</td>
                            <td>" . $row['coach'] . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "Aucun créneau disponible trouvé.";
            }
            break;

        case 'book':
            $date = $_POST['date'];
            $heure = $_POST['heure'];
            $activite_id = $_POST['activite'];
            $utilisateur_id = 1; // Supposons que l'utilisateur est connecté et son id est 1

            // Vérifier la disponibilité des coachs pour le créneau choisi
            $sql_dispos = "SELECT coachs.id AS coach_id, coachs.nom AS coach, disponibilites.date, disponibilites.heure_debut, disponibilites.heure_fin, activites.nom AS activite
                           FROM coachs
                           JOIN disponibilites ON coachs.id = disponibilites.coach_id
                           JOIN activites ON activites.id = $activite_id
                           WHERE disponibilites.date = '$date'
                           AND disponibilites.heure_debut <= '$heure'
                           AND disponibilites.heure_fin > '$heure'";

            $result_dispos = mysqli_query($db_handle, $sql_dispos);

            if (mysqli_num_rows($result_dispos) > 0) {
                echo "<h2>Disponibilités</h2>";
                echo "<table>
                        <tr>
                            <th>Date</th>
                            <th>Heure Début</th>
                            <th>Heure Fin</th>
                            <th>Activité</th>
                            <th>Coach</th>
                        </tr>";
                while ($row = mysqli_fetch_assoc($result_dispos)) {
                    echo "<tr>
                            <td>" . $row['date'] . "</td>
                            <td>" . $row['heure_debut'] . "</td>
                            <td>" . $row['heure_fin'] . "</td>
                            <td>" . $row['activite'] . "</td>
                            <td>" . $row['coach'] . "</td>
                          </tr>";

                    // Insérer le rendez-vous
                    $coach_id = $row['coach_id'];
                    $sql_insert = "INSERT INTO rendez_vous (utilisateur_id, date, heure, activite_id, coach_id)
                                   VALUES ('$utilisateur_id', '$date', '$heure', '$activite_id', '$coach_id')";

                    if (mysqli_query($db_handle, $sql_insert)) {
                        echo "Nouveau rendez-vous créé avec succès avec le coach " . $row['coach'] . "<br>";
                    } else {
                        echo "Erreur: " . mysqli_error($db_handle) . "<br>";
                    }
                }
                echo "</table>";
            } else {
                echo "Aucune disponibilité trouvée.";
            }
            break;
    }
}


// Fermer la connexion
mysqli_close($db_handle);
?>
