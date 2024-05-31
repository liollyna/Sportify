
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tout Parcourir - Sportify</title>
    <link rel="stylesheet" href="tout-parcourir.css"/>
    

    <link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script></head></head>
   <script src="tout-parcourir.js" defer></script>
<body>
    <div class="background-wrapper">
        <header>
            <h1 class = "texte1">Sportify - Consultation sportive en ligne</h1>
            
            <nav>
                <ul>
                    <li><a href="index.html" class="occasion-button">Accueil</a></li>
                    <li><a href="tout-parcourir.php" class="occasion-button">Tout Parcourir</a></li>
                    <li><a href="recherche.html"class="occasion-button">Recherche</a></li>
                    <li><a href="rendez-vous.html"class="occasion-button">Rendez-vous</a></li>
                    <li><a href="votre-compte.html"class="occasion-button">Votre Compte</a></li>
                </ul>
            </nav>
            <br><br>
			 
        </header>
    
        <main>
        <section>
            <h1>Tout Parcourir</h1>
			
			<div class="caption"> 
                <p>Catégories des services disponibles chez Sportify :</p>
                <ul>
                    <li><button class="button" name="sports" value="1">Activités sportives</button></li>
                    <li><button class="button" name="sports" value="2">Les Sports de compétition</button></li>
                    <li><button class="button" name="sports" value="3">Salle de sport Omnes</button></li>
                </ul>
                <form id="bookForm" method="POST" action="tout-parcourir.php">
                    <div id="activites-sportives" class="details">
                        <h3>Activités sportives</h3>
                        <ul>
                            <li><button type="submit" class="button" name="action" value="A">Séance de natation</button></li>
                            <li><button type="submit" class="button" name="action" value="B">Entraînement de rugby</button></li>
                            <li><button type="submit" class="button" name="action" value="C">Cours de Musculation</button></li>
                        </ul>
                    </div>
                    <div id="sports-competition" class="details" style="display: none;">
                        <h3>Sports de compétition</h3>
                        <ul>
                            <li><button type="submit" class="button" name="action" value="D">Match de tennis</button></li>
                            <li><button type="submit" class="button" name="action" value="E">Match de basket</button></li>
                            <li><button type="submit" class="button" name="action" value="F">Match de football</button></li>
                        </ul>
                    </div>
                </form>
                <!-- Ajoutez les autres sections comme nécessaire -->
            </div>
        </section>
    </main>
    
    <footer>
        <!-- Pied de page -->
        <p>Contactez-nous par mail, téléphone ou à notre adresse physique.</p>
        <!-- Inclure éventuellement une carte Google Maps -->
    </footer>


    <?php
$database = "spotify2";
$db_handle = mysqli_connect('localhost', 'root', '', $database);

if (!$db_handle) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

if (isset($_POST['sports'])) {
    $query = "SELECT * FROM activites";
    $result = mysqli_query($db_handle, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($activity = mysqli_fetch_assoc($result)) {
            echo '<li>' . htmlspecialchars($activity['nom']) . '</li>';
        }
    } else {
        echo 'Aucune activité sportive trouvée.';
    }
}

// Initialisez la variable $action
$action = isset($_POST['action']) ? $_POST['action'] : null;

// Vérifiez l'action à effectuer
if ($action) {

    // Action "ajouter" pour la musculation
    if ($action == "A") {
        // Récupérer les informations du coach avec l'id 1
        $query = "SELECT * FROM coachs WHERE id = 1";
        $result = mysqli_query($db_handle, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                // Récupérer les données du coach
                $coach = mysqli_fetch_assoc($result);

                // Afficher les informations du coach
                echo "ID : " . $coach['id'] . "<br>";
                echo "Nom : " . $coach['nom'] . "<br>";
                echo "Photo : <img src='" . $coach['photo'] . "' alt='Photo du coach' width='300'><br>"; // Affichage de l'image du coach
                echo "Bureau : " . $coach['bureau'] . "<br>";
                echo "Téléphone : " . $coach['Telephone'] . "<br>";
                echo "Email : " . $coach['Email'] . "<br>";
                // Afficher d'autres informations si nécessaire
                // Afficher les boutons
                echo "<button onclick='prendreRendezVous(".$coach['id'].")'>Prendre rendez-vous</button>";
                echo "<button onclick='contacterCoach(".$coach['id'].")'>Contacter le coach</button>";
                echo "<button onclick='voirCV(".$coach['id'].")'>Voir CV</button>";
            } else {
                echo "Aucun coach trouvé avec l'ID 1.";
            }
        } else {
            echo "Erreur lors de la récupération des informations du coach : " . mysqli_error($db_handle);
        }
    }

    // Action "ajouter" pour le rugby
    if ($action == "B") {
        $query = "SELECT * FROM coachs WHERE id = 2";
        $result = mysqli_query($db_handle, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                // Récupérer les données du coach
                $coach = mysqli_fetch_assoc($result);

                // Afficher les informations du coach
                echo "ID : " . $coach['id'] . "<br>";
                echo "Nom : " . $coach['nom'] . "<br>";
                echo "Photo : <img src='" . $coach['photo'] . "' alt='Photo du coach' width='300'><br>"; // Affichage de l'image du coach
                echo "Bureau : " . $coach['bureau'] . "<br>";
                echo "Téléphone : " . $coach['Telephone'] . "<br>";
                echo "Email : " . $coach['Email'] . "<br>";
                // Afficher d'autres informations si nécessaire
                // Afficher les boutons
                echo "<button onclick='prendreRendezVous(".$coach['id'].")'>Prendre rendez-vous</button>";
                echo "<button onclick='contacterCoach(".$coach['id'].")'>Contacter le coach</button>";
                echo "<button onclick='voirCV(".$coach['id'].")'>Voir CV</button>";
            } else {
                echo "Aucun coach trouvé avec l'ID 2.";
            }
        } else {
            echo "Erreur lors de la récupération des informations du coach : " . mysqli_error($db_handle);
        }
    }

    // Action "ajouter" pour la musculation
    if ($action == "C") {
        $query = "SELECT * FROM coachs WHERE id = 3";
        $result = mysqli_query($db_handle, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                // Récupérer les données du coach
                $coach = mysqli_fetch_assoc($result);

                // Afficher les informations du coach
                echo "ID : " . $coach['id'] . "<br>";
                echo "Nom : " . $coach['nom'] . "<br>";
                echo "Photo : <img src='" . $coach['photo'] . "' alt='Photo du coach' width='300'><br>"; // Affichage de l'image du coach
                echo "Bureau : " . $coach['bureau'] . "<br>";
                echo "Téléphone : " . $coach['Telephone'] . "<br>";
                echo "Email : " . $coach['Email'] . "<br>";
                // Afficher d'autres informations si nécessaire
                // Afficher les boutons
                echo "<button onclick='prendreRendezVous(".$coach['id'].")'>Prendre rendez-vous</button>";
                echo "<button onclick='contacterCoach(".$coach['id'].")'>Contacter le coach</button>";
                echo "<button onclick='voirCV(".$coach['id'].")'>Voir CV</button>";
            } else {
                echo "Aucun coach trouvé avec l'ID 3.";
            }
        } else {
            echo "Erreur lors de la récupération des informations du coach : " . mysqli_error($db_handle);
        }
    }

    // Action "ajouter" pour le tennis
    if ($action == "D") {
        $query = "SELECT * FROM coachs WHERE id = 4";
        $result = mysqli_query($db_handle, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                // Récupérer les données du coach
                $coach = mysqli_fetch_assoc($result);

                // Afficher les informations du coach
                echo "ID : " . $coach['id'] . "<br>";
                echo "Nom : " . $coach['nom'] . "<br>";
                echo "Photo : <img src='" . $coach['photo'] . "' alt='Photo du coach' width='300'><br>"; // Affichage de l'image du coach
                echo "Bureau : " . $coach['bureau'] . "<br>";
                echo "Téléphone : " . $coach['Telephone'] . "<br>";
                echo "Email : " . $coach['Email'] . "<br>";
                // Afficher d'autres informations si nécessaire
                // Afficher les boutons
                echo "<button onclick='prendreRendezVous(".$coach['id'].")'>Prendre rendez-vous</button>";
                echo "<button onclick='contacterCoach(".$coach['id'].")'>Contacter le coach</button>";
                echo "<button onclick='voirCV(".$coach['id'].")'>Voir CV</button>";
            } else {
                echo "Aucun coach trouvé avec l'ID 4.";
            }
        } else {
            echo "Erreur lors de la récupération des informations du coach : " . mysqli_error($db_handle);
        }
    }

    // Action "ajouter" pour le basket
    if ($action == "E") {
        $query = "SELECT * FROM coachs WHERE id = 5";
        $result = mysqli_query($db_handle, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                // Récupérer les données du coach
                $coach = mysqli_fetch_assoc($result);

                // Afficher les informations du coach
                echo "ID : " . $coach['id'] . "<br>";
                echo "Nom : " . $coach['nom'] . "<br>";
                echo "Photo : <img src='" . $coach['photo'] . "' alt='Photo du coach' width='300'><br>"; // Affichage de l'image du coach
                echo "Bureau : " . $coach['bureau'] . "<br>";
                echo "Téléphone : " . $coach['Telephone'] . "<br>";
                echo "Email : " . $coach['Email'] . "<br>";
                // Afficher d'autres informations si nécessaire
                // Afficher les boutons
                echo "<button onclick='prendreRendezVous(".$coach['id'].")'>Prendre rendez-vous</button>";
                echo "<button onclick='contacterCoach(".$coach['id'].")'>Contacter le coach</button>";
                echo "<button onclick='voirCV(".$coach['id'].")'>Voir CV</button>";
            } else {
                echo "Aucun coach trouvé avec l'ID 5.";
            }
        } else {
            echo "Erreur lors de la récupération des informations du coach : " . mysqli_error($db_handle);
        }
    }

    // Action "ajouter" pour le football
    if ($action == "F") {
        $query = "SELECT * FROM coachs WHERE id = 6";
        $result = mysqli_query($db_handle, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                // Récupérer les données du coach
                $coach = mysqli_fetch_assoc($result);

                // Afficher les informations du coach
                echo "ID : " . $coach['id'] . "<br>";
                echo "Nom : " . $coach['nom'] . "<br>";
                echo "Photo : <img src='" . $coach['photo'] . "' alt='Photo du coach' width='300'><br>"; // Affichage de l'image du coach
                echo "Bureau : " . $coach['bureau'] . "<br>";
                echo "Téléphone : " . $coach['Telephone'] . "<br>";
                echo "Email : " . $coach['Email'] . "<br>";
                // Afficher d'autres informations si nécessaire
                // Afficher les boutons
                echo "<button onclick='prendreRendezVous(".$coach['id'].")'>Prendre rendez-vous</button>";
                echo "<button onclick='contacterCoach(".$coach['id'].")'>Contacter le coach</button>";
                echo "<button onclick='voirCV(".$coach['id'].")'>Voir CV</button>";
            } else {
                echo "Aucun coach trouvé avec l'ID 6.";
            }
        } else {
            echo "Erreur lors de la récupération des informations du coach : " . mysqli_error($db_handle);
        }
    }
}

mysqli_close($db_handle);
?>

</body>
</html>


