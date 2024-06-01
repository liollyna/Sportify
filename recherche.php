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
    </style>
</head>
<body>
    <div class="background-wrapper">
        <h1 class="texte1">Sportify - Consultation sportive en ligne</h1>
        <!-- Barre de navigation -->
        <nav>
            <ul>
                <li><a href="index.html" class="occasion-button">Accueil</a></li>
                <li><a href="tout-parcourir.php" class="occasion-button">Tout Parcourir</a></li>
                <li><a href="recherche.php" class="occasion-button">Recherche</a></li>
                <li><a href="rendez-vous.html" class="occasion-button">Rendez-vous</a></li>
                <li><a href="votre-compte.php" class="occasion-button">Votre Compte</a></li>
                <li><a href="chatroom.php" class="occasion-button">Chatroom</a></li>
            </ul>
        </nav>
    
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
        
        <footer>
            <!-- Pied de page -->
            <p>Contactez-nous par mail, téléphone ou à notre adresse physique.</p>
            <!-- Inclure éventuellement une carte Google Maps -->
        </footer>
    </div>
</body>
</html>
