<?php
// Connexion à la base de données
$servername = "localhost";
$username = "votre_nom_utilisateur";
$password = "votre_mot_de_passe";
$dbname = "spotify2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Vérification si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Requête SQL pour récupérer l'utilisateur avec cet e-mail et ce mot de passe
    $sql = "SELECT id, nom FROM utilisateurs WHERE email='$email' AND mot_de_passe='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Utilisateur trouvé dans la base de données, rediriger vers la page client par exemple
        header("Location: page_client.html");
        exit;
    } else {
        // Utilisateur non trouvé, afficher un message d'erreur ou rediriger vers une autre page
        echo "Adresse e-mail ou mot de passe incorrect.";
    }
}

// Fermeture de la connexion à la base de données
$conn->close();
?>
