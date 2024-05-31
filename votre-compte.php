
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Votre Compte</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="votre-compte.css" rel="stylesheet" type="text/css" /> 
</head>
<body>
    <div class="background-wrapper">
        <header>
            <h1 class="texte1">Sportify - Consultation sportive en ligne</h1>
            <nav>
                <ul>
                    <li><a href="index.html" class="occasion-button">Accueil</a></li>
                    <li><a href="tout-parcourir.php" class="occasion-button">Tout Parcourir</a></li>
                    <li><a href="recherche.html" class="occasion-button">Recherche</a></li>
                    <li><a href="rendez-vous.html" class="occasion-button">Rendez-vous</a></li>
                    <li><a href="votre-compte.php" class="occasion-button">Votre Compte</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <section>
                <h1>Votre Compte</h1>
                <h2>Choisissez votre type de compte :</h2>
                <div class="caption">
                    <form method="post" action="votre-compte.php">
                        <ul>
                            <li><button class="button" type="submit" name="account_type" value="client">Clients</button></li>
                            <li><button class="button" type="submit" name="account_type" value="coach">Coachs</button></li>
                            <li><button class="button" type="submit" name="account_type" value="admin">Administrateurs</button></li>
                        </ul>

                        <!-- Formulaire d'authentification pour les clients -->
                        <h2>Authentification Client</h2>
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email">

                        <label for="password">Mot de Passe :</label>
                        <input type="password" id="password" name="password">

                        <button type="submit">Se Connecter</button>
                    </form>
                    <h1>Créer un Compte</h1>
                    <form method="post" action="votre-compte.php">
                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" required><br><br>

                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" required><br><br>

                        <label for="adresse">Adresse :</label>
                        <input type="text" id="adresse" name="adresse"><br><br>

                        <label for="telephone">Téléphone :</label>
                        <input type="text" id="telephone" name="telephone"><br><br>

                        <label for="mot_de_passe">Mot de Passe :</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br>

                        <label for="type_compte">Type de Compte :</label>
                        <select id="type_compte" name="type_compte">
                            <option value="client">Client</option>
                            <option value="coach">Coach</option>
                        </select><br><br>

                        <button type="submit">Créer un Compte</button>
                    </form>
                    <p>Catégories des services disponibles chez Sportify :</p>
                    <p>Gérez votre compte Sportify et accédez à vos informations personnelles.</p>
                    <h2>Informations Personnelles</h2>
                    <ul>
                        <li>Nom : John Doe</li>
                        <li>Email : johndoe@example.com</li>
                        <li>Adresse : 123 Rue Sport, Ville Sportive</li>
                        <li>Téléphone : 123-456-7890</li>
                    </ul>
                </div>
            </section>
        </main>
        <footer>
            <p>Contactez-nous par mail, téléphone ou à notre adresse physique.</p>
        </footer>
    </div>
</body>
</html>




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
