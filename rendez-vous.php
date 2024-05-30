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
            $sql_creneaux = "SELECT coachs.nom AS coach, disponibilites.date, disponibilites.heure_debut, disponibilites.heure_fin, activites.nom AS activite, disponibilites.id AS dispo_id
                             FROM coachs
                             JOIN disponibilites ON coachs.id = disponibilites.coach_id
                             JOIN activites ON activites.id = $activite_id
                             WHERE disponibilites.id NOT IN (SELECT disponibilite_id FROM rendez_vous)
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
                            <th>Réserver</th>
                        </tr>";
                while ($row = mysqli_fetch_assoc($result_creneaux)) {
                    echo "<tr class='creneau-disponible' data-id='" . $row['dispo_id'] . "'>
                            <td>" . $row['date'] . "</td>
                            <td>" . $row['heure_debut'] . "</td>
                            <td>" . $row['heure_fin'] . "</td>
                            <td>" . $row['activite'] . "</td>
                            <td>" . $row['coach'] . "</td>
                            <td><a href='rendez-vous.php?action=book&dispo_id=" . $row['dispo_id'] . "' class='reserver-btn'>Réserver</a></td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "Aucun créneau disponible trouvé.";
            }
            break;

        case 'book':
            $dispo_id = $_GET['dispo_id'];
            $utilisateur_id = 1; // Supposons que l'utilisateur est connecté et son id est 1

            // Vérifier la disponibilité du créneau
            $sql_dispo = "SELECT * FROM disponibilites WHERE id = $dispo_id AND id NOT IN (SELECT disponibilite_id FROM rendez_vous)";

            $result_dispo = mysqli_query($db_handle, $sql_dispo);

            if (mysqli_num_rows($result_dispo) > 0) {
                $row = mysqli_fetch_assoc($result_dispo);
                $date = $row['date'];
                $heure_debut = $row['heure_debut'];
                $heure_fin = $row['heure_fin'];
                $coach_id = $row['coach_id'];

                // Insérer le rendez-vous
                $sql_insert = "INSERT INTO rendez_vous (utilisateur_id, date, heure, activite_id, coach_id, disponibilite_id)
                               VALUES ('$utilisateur_id', '$date', '$heure_debut', (SELECT activite_id FROM disponibilites WHERE id = $dispo_id), '$coach_id', '$dispo_id')";

                if (mysqli_query($db_handle, $sql_insert)) {
                    echo "Nouveau rendez-vous créé avec succès avec le coach " . $row['coach'] . "<br>";

                    // Envoyer un message de confirmation
                    $message = "Votre rendez-vous a été réservé avec succès pour le " . $date . " de " . $heure_debut . " à " . $heure_fin . ".";
                    mail('johndoe@example.com', 'Confirmation de Rendez-vous', $message);
                } else {
                    echo "Erreur: " . mysqli_error($db_handle) . "<br>";
                }
            } else {
                echo "Ce créneau n'est plus disponible.";
            }
            break;
    }
}

// Fermer la connexion
mysqli_close($db_handle);
?>
