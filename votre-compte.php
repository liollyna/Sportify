<?php
// Vérifier si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Vérifier si les clés email et password existent dans le tableau $_POST pour l'authentification
    if (isset($_POST['email']) && isset($_POST['password']) && !isset($_POST['nom'])) {
        // Récupérer les valeurs du formulaire
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Préparer et exécuter la requête SQL pour vérifier les informations de connexion
        $query = "SELECT * FROM utilisateurs WHERE email='$email' AND mot_de_passe='$password'";
        $result = $conn->query($query);

        // Vérifier si l'utilisateur est authentifié avec succès
        if ($result->num_rows > 0) {
            echo "Vous êtes connecté avec succès.";
        } else {
            echo "Adresse e-mail ou mot de passe incorrect.";
        }
    }

    // Vérifier si les informations de création de compte sont soumises
    if (isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['mot_de_passe']) && isset($_POST['type_compte'])) {
        // Récupérer les valeurs du formulaire de création de compte
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : null;
        $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : null;
        $mot_de_passe = $_POST['mot_de_passe'];
        $type_compte = $_POST['type_compte'];

        // Hacher le mot de passe
        $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);

        // Préparer la requête SQL pour insérer les données dans la table utilisateurs
        $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, adresse, telephone, mot_de_passe, type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nom, $email, $adresse, $telephone, $mot_de_passe_hache, $type_compte);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Nouveau compte créé avec succès !";
        } else {
            echo "Erreur : " . $stmt->error;
        }

        // Fermer la déclaration
        $stmt->close();
    }

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    echo "Erreur : la méthode de requête HTTP n'est pas POST.";
}
?>
