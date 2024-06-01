<?php
session_start();
$database = "spotify3";
$db_handle = mysqli_connect('localhost', 'root', '', $database);

if (!$db_handle) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $creneauId = $_POST['creneauId'];
    $utilisateurId = $_SESSION['utilisateur_id']; // ID de l'utilisateur connecté

    // Mettre à jour le créneau pour le marquer comme "réservé"
    $updateCreneauQuery = "UPDATE creneaux SET type='reserve' WHERE id=$creneauId";
    if (mysqli_query($db_handle, $updateCreneauQuery)) {
        // Mettre à jour la table rendez_vous
        $updateRendezVousQuery = "UPDATE rendez_vous SET utilisateur_id=$utilisateurId WHERE id=$creneauId";
        if (mysqli_query($db_handle, $updateRendezVousQuery)) {
            echo "success";
        } else {
            echo "Erreur lors de la mise à jour de la table rendez_vous : " . mysqli_error($db_handle);
        }
    } else {
        echo "Erreur lors de la mise à jour du créneau : " . mysqli_error($db_handle);
    }
}

mysqli_close($db_handle);
?>
