<?php
session_start(); // Démarrer la session

$database = "spotify2";
$db_handle = mysqli_connect('localhost', 'root', '', $database);

if (!$db_handle) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rendezVousId = $_POST['rendezVousId'];
    $user_id = $_SESSION['user_id'];

    // Récupérer les détails du rendez-vous
    $rendezVousQuery = "SELECT * FROM rendez_vous WHERE id = $rendezVousId AND utilisateur_id = $user_id";
    $rendezVousResult = mysqli_query($db_handle, $rendezVousQuery);

    if (mysqli_num_rows($rendezVousResult) > 0) {
        $rendezVous = mysqli_fetch_assoc($rendezVousResult);
        $date = $rendezVous['date'];
        $heure_debut = $rendezVous['heure'];
        $coachId = $rendezVous['coach_id'];
        $type = 'disponible'; // Le créneau devient disponible après l'annulation

        // Supprimer le rendez-vous de la table rendez_vous
        $deleteRendezVousQuery = "DELETE FROM rendez_vous WHERE id = $rendezVousId";
        if (mysqli_query($db_handle, $deleteRendezVousQuery)) {
            // Calculer l'heure de fin en ajoutant 2 heures à l'heure de début
            $heure_fin = date('H:i:s', strtotime($heure_debut . ' +2 hours'));

            // Ajouter une nouvelle ligne à la table creneaux
            $insertCreneauQuery = "INSERT INTO creneaux (coach_id, date, heure_debut, heure_fin, type) VALUES ($coachId, '$date', '$heure_debut', '$heure_fin', '$type')";
            if (mysqli_query($db_handle, $insertCreneauQuery)) {
                echo "success";
            } else {
                echo "Erreur lors de l'insertion dans la table creneaux : " . mysqli_error($db_handle);
            }
        } else {
            echo "Erreur lors de la suppression du rendez-vous : " . mysqli_error($db_handle);
        }
    } else {
        echo "Rendez-vous introuvable.";
    }
}

mysqli_close($db_handle);
?>
