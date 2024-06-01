

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
                    <li><a href="chatroom.php" class="occasion-button">Chatroom</a></li>
                </ul>
            </nav>
        </header>
        <main class="d-flex flex-column align-items-center justify-content-center" style="height: 150vh;">
            <section class="text-center">
                <?php
                session_start();
				 // Vérifier si l'utilisateur demande la déconnexion
             if (isset($_POST['logout'])) {
               session_destroy();
              header("Location: votre-compte.php");
              exit();
                  }
    
                if (isset($_SESSION['user'])) {
                    $user = $_SESSION['user'];
					$_SESSION['user_id'] = $user['id'];
                    

                    
                    echo "<div class='alert alert-success text-center'>
                            Vous êtes connecté avec succès.<br>
                            Bonjour " . $user['nom'] . ".<br>
                            Email : " . $user['email'] . ".<br>
                            Adresse : " . $user['adresse'] . ".<br>
                            Téléphone : " . $user['telephone'] . ".<br>
                            Type de compte : " . $user['type'] . ".

                            <form method='post' action='votre-compte.php'>
                                <button type='submit' name='logout' class='btn btn-danger mt-3'>Se Déconnecter</button>
                            </form>
                          </div>";
                          // Vérifier si le type de compte est admin
                          if ($user['type'] == 'admin') {
                          // Afficher les fonctionnalités admin
                         echo "<h2>Fonctionnalités administrateur :</h2>
                         <button type='button' class='btn btn-danger' onclick='supprimerCoach()'>Supprimer un Coach</button>
                         <button type='button' class='btn btn-success' onclick='ajouterCoach()'>Ajouter un Coach</button>";
                              }
                          




                } else {
                    echo '<div class="caption">
                            <form method="post" action="votre-compte.php" class="mb-4">
                                <h2>Authentification </h2>
                                <label for="email">Email :</label>
                                <input type="email" id="email" name="email" class="form-control mb-2">
                                <label for="password">Mot de Passe :</label>
                                <input type="password" id="password" name="password" class="form-control mb-2">
                                <button type="submit" class="btn btn-primary">Se Connecter</button>
                            </form>




                            
                            <h2>Créer un Compte</h2>
                            <form method="post" action="votre-compte.php">
                                <label for="nom">Nom :</label>
                                <input type="text" id="nom" name="nom" required class="form-control mb-2">
                                <label for="email">Email :</label>
                                <input type="email" id="email" name="email" required class="form-control mb-2">
                                <label for="adresse">Adresse :</label>
                                <input type="text" id="adresse" name="adresse" class="form-control mb-2">
                                <label for="telephone">Téléphone :</label>
                                <input type="text" id="telephone" name="telephone" class="form-control mb-2">
                                <label for="mot_de_passe">Mot de Passe :</label>
                                <input type="password" id="mot_de_passe" name="mot_de_passe" required class="form-control mb-2">
                                <label for="type_compte">Type de Compte :</label>
                                <select id="type_compte" name="type_compte" class="form-control mb-2">
                                    <option value="client">Client</option>
                                    <option value="coach">Coach</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Créer un Compte</button>
                            </form>
                            <p>Catégories des services disponibles chez Sportify :</p>
                            <p>Gérez votre compte Sportify et accédez à vos informations personnelles.</p>
                        </div>';
                }
                ?>
                
            </section>
        </main>
        <footer class="page-footer">
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

    // Vérifier si l'utilisateur demande la déconnexion
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: votre-compte.php");
        exit();
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
            // Récupérer les informations de l'utilisateur
            $user = $result->fetch_assoc();
            $_SESSION['user'] = $user;
            //header("Location: votre-compte.php");
            exit();
        } else {
            echo "<div class='container mt-5'>
                    <div class='alert alert-danger text-center'>
                        Adresse e-mail ou mot de passe incorrect.
                    </div>
                  </div>";
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
            echo "<div class='container mt-5'>
                    <div class='alert alert-success text-center'>
                        Nouveau compte créé avec succès !
                    </div>
                  </div>";
        } else {
            echo "<div class='container mt-5'>
                    <div class='alert alert-danger text-center'>
                        Erreur : " . $stmt->error . "
                    </div>
                  </div>";
        }

        // Fermer la déclaration
        $stmt->close();
    }

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    echo "";
}
?>
