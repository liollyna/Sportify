<?php

$database = "spotify2";
$db_handle = mysqli_connect('localhost', 'root', '', $database);

if (!$db_handle) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

$searchResults = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = mysqli_real_escape_string($db_handle, $_POST['search']);
    
    $sql = "SELECT c.nom AS coach_nom, c.photo AS coach_photo, c.CV AS coach_cv, c.Email AS coach_email, c.bureau AS coach_bureau, c.Telephone AS coach_phone, a.nom AS activite_nom, s.nom AS salle_nom
            FROM coachs c
            JOIN activites a ON c.activite_id = a.id
            JOIN salles s ON c.salle_id = s.id
            WHERE c.nom LIKE '%$searchTerm%' 
               OR a.nom LIKE '%$searchTerm%' 
               OR s.nom LIKE '%$searchTerm%'
               OR c.Email LIKE '%$searchTerm%'";
               
    $result = mysqli_query($db_handle, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $searchResults[] = $row;
        }
    } else {
        $message = "Aucun résultat trouvé";
    }
}

mysqli_close($db_handle);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="recherche.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <title>Rechercher - Sportify</title>
	<style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
        }

        .background-wrapper {
            flex: 1;
            background-image: url('AAA.jpg');
            background-size: cover;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: rgba(51, 0, 255, 0.8);
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
		.coach-result {
			display: flex;
			align-items: center;
			background-color:white;
            border: 1px solid #ddd;
			padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		}
		.coach-photo {
            max-width: 150px;
            margin-right: 20px;
        }
        .coach-info {
            flex-grow: 1;
        }
        .coach-info h3 {
            margin-top: 0;
        }
        .coach-info p {
            margin: 5px 0;
        }
        .coach-cv {
            margin-top: 10px;
        }
        .contact-button {
            margin-left: 10px;
        }
		
        header nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        header nav ul li {
            display: inline;
        }

        header nav ul li a {
            text-decoration: none;
            color: #fff;
            padding: 10px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);
            transition: box-shadow 0.3s;
            border-radius: 10px;
            text-align: center;
        }

        header nav ul li a:hover {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.7);
        }

        h1 {
            color: #fff;
            font-size: 30px;
            text-align: center;
            padding: 20px;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .chat-section {
            width: 80%;
            max-width: 800px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .texte1 {
            color: rgb(55, 107, 128);
            text-align: center;
            margin-bottom: 20px;
        }

        .messages {
            border: 1px solid #ccc;
            padding: 10px;
            height: 300px;
            overflow-y: scroll;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 10px;
        }

        .message {
            border-bottom: 1px solid #eee;
            padding: 5px 0;
        }

        .message p {
            margin: 0;
        }

        .message span {
            display: block;
            font-size: 0.8em;
            color: #999;
        }

        .message-form {
            display: flex;
            flex-direction: column;
        }

        .message-form label, .message-form select, .message-form textarea, .message-form button {
            margin-bottom: 10px;
        }

        .message-form textarea {
            resize: vertical;
            min-height: 100px;
        }

        .message-form button {
            padding: 10px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .message-form button:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: rgba(51, 0, 255, 0.8);
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <div class="background-wrapper">
	<header>
        <h1>Sportify - Consultation sportive en ligne</h1>
        <!-- Barre de navigation -->
        <nav>
            <ul>
                <li><a href="index.html" class="occasion-button">Accueil</a></li>
                <li><a href="tout-parcourir.php" class="occasion-button">Tout Parcourir</a></li>
                <li><a href="recherche.php" class="occasion-button">Recherche</a></li>
                <li><a href="rendez-vous.php" class="occasion-button">Rendez-vous</a></li>
                <li><a href="votre-compte.php" class="occasion-button">Votre Compte</a></li>
                <li><a href="chatroom.php" class="occasion-button">Chatroom</a></li>
            </ul>
        </nav>
		</header>
        <main>
            <!-- Contenu principal de la page -->
            <section>
                <h1>Rechercher</h1>
                <p>Utilisez cette fonction de recherche pour trouver rapidement des informations sur les coaches, les sports et les établissements sportifs.</p>
                
                <form method="post" action="recherche.php">
                    <label for="search">Recherche :</label>
                    <input type="text" id="search" name="search" placeholder="Entrez votre recherche ici">
                    
                    <button type="submit">Rechercher</button>
                </form>
                
                <!-- Résultats de la recherche -->
                <div id="search-results">
                    <?php if (!empty($searchResults)): ?>
                        <?php foreach ($searchResults as $result): ?>
                            <div class="coach-result">
                                <img src="<?php echo htmlspecialchars($result['coach_photo']); ?>" alt="Photo de <?php echo htmlspecialchars($result['coach_nom']); ?>" class="coach-photo">
                                <div class="coach-info">
                                    <h3><?php echo htmlspecialchars($result['coach_nom']); ?></h3>
                                    <p><strong>Activité :</strong> <?php echo htmlspecialchars($result['activite_nom']); ?></p>
                                    <p><strong>Salle :</strong> <?php echo htmlspecialchars($result['salle_nom']); ?></p>
                                    <p>
                                        <strong>Email :</strong> <?php echo htmlspecialchars($result['coach_email']); ?>
                                        <a href="mailto:<?php echo htmlspecialchars($result['coach_email']); ?>" class="btn btn-secondary contact-button">Contacter</a>
                                    </p>
                                    <p><strong>Bureau :</strong> <?php echo htmlspecialchars($result['coach_bureau']); ?></p>
                                    <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($result['coach_phone']); ?></p>
                                    <a href="<?php echo htmlspecialchars($result['coach_cv']); ?>" class="btn btn-primary coach-cv" target="_blank">Voir le CV</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php elseif (isset($message)): ?>
                        <p><?php echo htmlspecialchars($message); ?></p>
                    <?php endif; ?>
                </div>
            </section>
        </main>
        
        <footer class="page-footer">
            <div class="container">
                <div class="row custom-row">
                    <div class="col-lg-4 col-md-6">
                        <div class="infos text-left">
                            <h4 class="A" style="margin-left: 100px;">
                                Besoin d'aide ?
                            </h4>
                            <p style="margin-left: 70px;">Questions fréquentes ?</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="infos text-left">
                            <h4 class="A" style="margin-left: 150px;">
                                Contact
                            </h4>
                            <p style="margin-left: 50px;">
                                30, Avenue de Breteuil, 75012 Paris, France <br>
                                info@Sporfity.fr <br>
                                numéro de téléphone : +33 01 02 03 04 05 <br>
                                +33 01 03 02 05 04
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="infos text-left">
                            <h4 class="A" style="margin-left: 150px;">
                                Rejoignez-nous !
                            </h4>
                            <div>
                                <a target="_blank" href="https://twitter.com/">
                                    <img src="image/twitter.png" alt="Logo Twitter" style="margin-left: 150px; margin-right: 20px;">
                                </a>
                                <a target="_blank" href="https://www.instagram.com/">
                                    <img src="image/instagram.png" alt="Logo Instagram" style="margin-right: 50px;">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="infos text-left">
                            <h3>
                                Achats 100% sécurisés
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="footer-copyright">
                            &copy; Site préféré de coaching français en 2022
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
