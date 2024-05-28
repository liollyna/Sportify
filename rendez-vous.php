<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $activite = $_POST['activite'];
    $utilisateur_id = 1; // Supposons que l'utilisateur est connecté et son id est 1

    // Validation des données
    if (!empty($date) && !empty($heure) && !empty($activite)) {
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sportify";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connexion échouée: " . $conn->connect_error);
        }

        // Vérifier la disponibilité des coachs pour le créneau choisi
        $sql = "SELECT coachs.id, coachs.nom, disponibilites.heure_debut, disponibilites.heure_fin 
                FROM coachs 
                JOIN disponibilites ON coachs.id = disponibilites.coach_id 
                WHERE disponibilites.date = '$date' AND 
                      disponibilites.heure_debut <= '$heure' AND 
                      disponibilites.heure_fin > '$heure'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Un coach est disponible
            $row = $result->fetch_assoc();
            $coach_id = $row['id'];

            // Insérer le rendez-vous
            $sql_insert = "INSERT INTO rendez_vous (utilisateur_id, date, heure, activite, coach_id) 
                           VALUES ('$utilisateur_id', '$date', '$heure', '$activite', '$coach_id')";

            if ($conn->query($sql_insert) === TRUE) {
                echo "Nouveau rendez-vous créé avec succès avec le coach " . $row['nom'];
            } else {
                echo "Erreur: " . $sql_insert . "<br>" . $conn->error;
            }
        } else {
            echo "Aucun coach n'est disponible pour ce créneau.";
        }

        $conn->close();
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>
