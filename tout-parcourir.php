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
                echo "ID : " . htmlspecialchars($coach['id']) . "<br>";
                echo "Nom : " . htmlspecialchars($coach['nom']) . "<br>";
                echo "Photo : " . htmlspecialchars($coach['photo']) . "<br>";
                echo "Bureau : " . htmlspecialchars($coach['bureau']) . "<br>";
                echo "Téléphone : " . htmlspecialchars($coach['Telephone']) . "<br>";
                echo "Email : " . htmlspecialchars($coach['Email']) . "<br>";
            } else {
                echo "Aucun coach trouvé avec l'ID 1.";
            }
        } else {
            echo "Erreur lors de la récupération des informations du coach : " . mysqli_error($db_handle);
        }
    }
}

// Récupérer toutes les données des tables
$query_all = "
    SELECT
        activites.nom AS activite_nom,
        coachs.nom AS coach_nom, coachs.photo, coachs.CV, coachs.bureau, coachs.Telephone, coachs.Email,
        creneaux.date AS creneaux_date, creneaux.heure_debut, creneaux.heure_fin, creneaux.type AS creneaux_type,
        messages.contenu AS message_contenu, messages.date_envoi AS message_date,
        rendez_vous.date AS rendez_vous_date, rendez_vous.heure AS rendez_vous_heure,
        utilisateurs.nom AS utilisateur_nom, utilisateurs.email AS utilisateur_email
    FROM activites
    LEFT JOIN coachs ON activites.id = coachs.activite_id
    LEFT JOIN creneaux ON coachs.id = creneaux.coach_id
    LEFT JOIN messages ON coachs.id = messages.coach_id OR utilisateurs.id = messages.utilisateur_id
    LEFT JOIN rendez_vous ON coachs.id = rendez_vous.coach_id
    LEFT JOIN utilisateurs ON rendez_vous.utilisateur_id = utilisateurs.id
";

$result_all = mysqli_query($db_handle, $query_all);

if ($result_all && mysqli_num_rows($result_all) > 0) {
    echo "<h2>Liste des enregistrements</h2>";
    echo "<table border='1'>
            <tr>
                <th>Activité</th>
                <th>Coach</th>
                <th>Photo</th>
                <th>CV</th>
                <th>Bureau</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Date Creneaux</th>
                <th>Heure Début</th>
                <th>Heure Fin</th>
                <th>Type Creneaux</th>
                <th>Message Contenu</th>
                <th>Date Message</th>
                <th>Date Rendez-vous</th>
                <th>Heure Rendez-vous</th>
                <th>Utilisateur</th>
                <th>Email Utilisateur</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result_all)) {
        echo "<tr>
                <td>" . htmlspecialchars($row["activite_nom"]) . "</td>
                <td>" . htmlspecialchars($row["coach_nom"]) . "</td>
                <td>" . htmlspecialchars($row["photo"]) . "</td>
                <td>" . htmlspecialchars($row["CV"]) . "</td>
                <td>" . htmlspecialchars($row["bureau"]) . "</td>
                <td>" . htmlspecialchars($row["Telephone"]) . "</td>
                <td>" . htmlspecialchars($row["Email"]) . "</td>
                <td>" . htmlspecialchars($row["creneaux_date"]) . "</td>
                <td>" . htmlspecialchars($row["heure_debut"]) . "</td>
                <td>" . htmlspecialchars($row["heure_fin"]) . "</td>
                <td>" . htmlspecialchars($row["creneaux_type"]) . "</td>
                <td>" . htmlspecialchars($row["message_contenu"]) . "</td>
                <td>" . htmlspecialchars($row["message_date"]) . "</td>
                <td>" . htmlspecialchars($row["rendez_vous_date"]) . "</td>
                <td>" . htmlspecialchars($row["rendez_vous_heure"]) . "</td>
                <td>" . htmlspecialchars($row["utilisateur_nom"]) . "</td>
                <td>" . htmlspecialchars($row["utilisateur_email"]) . "</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "0 résultats";
}

// Fermez la connexion à la base de données
mysqli_close($db_handle);
?>
