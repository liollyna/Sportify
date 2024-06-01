<?php

$database = "spotify2";
$db_handle = mysqli_connect('localhost', 'root', '', $database);

if (!$db_handle) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

$searchResults = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = $conn->real_escape_string($_POST['search']);
    
    $sql = "SELECT c.nom AS coach_nom, a.nom AS activite_nom, s.nom AS salle_nom
            FROM coachs c
            JOIN activites a ON c.activite_id = a.id
            JOIN salles s ON c.salle_id = s.id
            WHERE c.nom LIKE '%$searchTerm%' 
               OR a.nom LIKE '%$searchTerm%' 
               OR s.nom LIKE '%$searchTerm%'";
               
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    } else {
        $message = "Aucun résultat trouvé";
    }
}

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
                        <ul>
                            <?php foreach ($searchResults as $result): ?>
                                <li>Coach: <?php echo $result['coach_nom']; ?>, Activité: <?php echo $result['activite_nom']; ?>, Salle: <?php echo $result['salle_nom']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php elseif (isset($message)): ?>
                        <p><?php echo $message; ?></p>
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
