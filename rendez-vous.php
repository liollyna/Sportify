<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $activite = $_POST['activite'];

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

        $sql = "INSERT INTO rendez_vous (date, heure, activite) VALUES ('$date', '$heure', '$activite')";

        if ($conn->query($sql) === TRUE) {
            echo "Nouveau rendez-vous créé avec succès";
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>
