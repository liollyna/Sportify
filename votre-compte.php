<?php
// Vérifier si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les clés email et password existent dans le tableau $_POST
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Récupérer les valeurs du formulaire
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $db_password = ""; // Assurez-vous de mettre votre mot de passe de base de données ici
        $dbname = "spotify2";
        $conn = new mysqli($servername, $username, $db_password, $dbname);
        
        // Vérifier la connexion à la base de données
        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }

        // Préparer et exécuter la requête SQL pour vérifier les informations de connexion
        $query = "SELECT * FROM utilisateurs WHERE email='$email' AND mot_de_passe='$password'";
        $result = $conn->query($query);

        // Vérifier si l'utilisateur est authentifié avec succès
        if ($result->num_rows > 0) {
            // L'utilisateur est authentifié avec succès
            echo "Vous êtes connecté avec succès.";
        } else {
            // L'authentification a échoué
            echo "Adresse e-mail ou mot de passe incorrect.";
        }

        // Fermer la connexion à la base de données
        $conn->close();
    } else {
        // Afficher un message d'erreur si les champs email et password ne sont pas définis dans $_POST
        echo "Erreur : champs email et/ou mot de passe manquants dans le formulaire.";
    }
} else {
    echo "Erreur : la méthode de requête HTTP n'est pas POST.";
}
?>
