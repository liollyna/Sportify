<?php
session_start(); // Démarrer la session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = "spotify2";
    $db_handle = mysqli_connect('localhost', 'root', '', $database);

    if (!$db_handle) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }

    $date = $_POST['date'];
    $heure_debut = $_POST['heure_debut'];
    $coach_id = $_POST['coach_id'];
    $activite_id = $_POST['activite_id'];

    // Calculer l'heure de fin en ajoutant 2 heures à l'heure de début
    $heure_fin = date('H:i:s', strtotime($heure_debut . ' +2 hours'));

    // Ajouter le créneau à la table creneaux
    $insertCreneauQuery = "INSERT INTO creneaux (coach_id, date, heure_debut, heure_fin, type) VALUES ($coach_id, '$date', '$heure_debut', '$heure_fin', 'disponible')";
    if (mysqli_query($db_handle, $insertCreneauQuery)) {
        header('Location: rendez-vous.php'); // Rediriger vers la page des rendez-vous après l'ajout
        exit();
    } else {
        echo "Erreur lors de l'insertion dans la table creneaux : " . mysqli_error($db_handle);
    }

    mysqli_close($db_handle);
}
?>
