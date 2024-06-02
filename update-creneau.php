<?php
session_start();
$database = "spotify2";
$db_handle = mysqli_connect('localhost', 'root', '', $database);

if (!$db_handle) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $creneauId = $_POST['creneauId'];
    $user_id = $_SESSION['user_id']; // ID de l'utilisateur connecté

    // Récupérer les détails du créneau
    $creneauQuery = "SELECT * FROM creneaux WHERE id = $creneauId";
    $creneauResult = mysqli_query($db_handle, $creneauQuery);

    if (mysqli_num_rows($creneauResult) > 0) {
        $creneau = mysqli_fetch_assoc($creneauResult);
        $date = $creneau['date'];
        $heure = $creneau['heure_debut'];
        $activiteId = $creneau['coach_id'];
        $coachId = $creneau['coach_id'];

        // Supprimer le créneau des creneaux
        $deleteCreneauQuery = "DELETE FROM creneaux WHERE id = $creneauId";
        if (mysqli_query($db_handle, $deleteCreneauQuery)) {
            // Ajouter une nouvelle ligne à la table rendez_vous
            $insertRendezVousQuery = "INSERT INTO rendez_vous (user_id, date, heure, activite_id, coach_id) VALUES ($utilisateurId, '$date', '$heure', $activiteId, $coachId)";
            if (mysqli_query($db_handle, $insertRendezVousQuery)) {
                echo "success";
            } else {
                echo "Erreur lors de l'insertion dans la table rendez_vous : " . mysqli_error($db_handle);
            }
        } else {
            echo "Erreur lors de la suppression du créneau : " . mysqli_error($db_handle);
        }
    } else {
        echo "Creneau introuvable.";
    }
}

mysqli_close($db_handle);
?>
