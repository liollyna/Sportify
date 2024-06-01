<?php
session_start(); // Démarrer la session
// Pour le test, nous allons définir un utilisateur_id de test dans la session
if (!isset($_SESSION['utilisateur_id'])) {
    $_SESSION['utilisateur_id'] = 0; // Remplacez cette valeur par l'ID réel de l'utilisateur connecté
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tout Parcourir - Sportify</title>
    <link rel="stylesheet" href="tout-parcourir.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="tout-parcourir.js" defer></script>
    <style>
        .coach-container {
            display: flex;
            align-items: flex-start;
            margin-top: 20px;
        }
        .coach-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            margin-right: 20px;
            background-color: #f9f9f9;
        }
        .agenda-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            background-color: #f9f9f9;
            flex: 1;
        }
        .coach-photo {
            max-width: 100%;
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
            height: 100px; /* Hauteur uniforme pour toutes les cellules */
            width: 100px;  /* Largeur uniforme pour toutes les cellules */
            vertical-align: middle; /* Centrage vertical du contenu */
        }
        th {
            background-color: #f2f2f2;
        }
        .empty-cell {
            background-color: #333;
            color: #fff;
        }
        .disponible {
            background-color: #fff;
            cursor: pointer;
        }
        .reserve, .conge {
            background-color: #add8e6;
            background-image: linear-gradient(45deg, #add8e6 25%, #87ceeb 25%, #87ceeb 50%, #add8e6 50%, #add8e6 75%, #87ceeb 75%, #87ceeb 100%);
            background-size: 20px 20px;
            color: #000;
        }
        .disponible:hover {
            background-color: #e0f7fa;
        }
    </style>
    <script>
        function colorierCreneaux() {
            var creneaux = document.querySelectorAll('.creneau');
            creneaux.forEach(function(creneau) {
                if (creneau.dataset.type === 'disponible') {
                    creneau.classList.add('disponible');
                } else {
                    creneau.classList.add('reserve');
                }
            });
        }

        function prendreRendezVous(coachId) {
            var url = 'creneaux.php?coach_id=' + coachId;
            window.open(url, '_blank');
        }
    </script>
</head>
<body>
    <div class="background-wrapper">
        <header>
            <h1 class="texte1">Sportify - Consultation sportive en ligne</h1>
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
                        <li>
                            <form action="SalleDeSport.html" method="GET">
                                <button type="submit" class="button" name="action" value="3">Salle de sport Omnes</button>
                            </form>
                        </li>
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
                </div>
            </section>
            <section id="coach-section">
                <?php
				if (isset($_SESSION['user_id'])) {
					// L'ID de l'utilisateur est disponible dans la session
					$user_id = $_SESSION['user_id'];
					// Vous pouvez maintenant utiliser $user_id comme bon vous semble, par exemple, pour effectuer des requêtes SQL
					echo "L'ID de l'utilisateur connecté est : $user_id";
				} else {
					// L'ID de l'utilisateur n'est pas présent dans la session, cela signifie probablement que l'utilisateur n'est pas connecté
					echo "L'utilisateur n'est pas connecté.";
				}
                //echo "<p>Utilisateur ID: " . $_SESSION['utilisateur_id'] . "</p>"; // Test pour afficher l'utilisateur ID

                $database = "spotify2";
                $db_handle = mysqli_connect('localhost', 'root', '', $database);

                if (!$db_handle) {
                    die("Échec de la connexion : " . mysqli_connect_error());
                }

                // Initialisez la variable $action
                $action = isset($_POST['action']) ? $_POST['action'] : null;

                // Vérifiez l'action à effectuer
                if ($action) {
                    // Mapper les actions aux IDs de coachs
                    $actionToIdMap = [
                        'A' => 1,
                        'B' => 2,
                        'C' => 3,
                        'D' => 4,
                        'E' => 5,
                        'F' => 6
                    ];

                    if (array_key_exists($action, $actionToIdMap)) {
                        $coachId = $actionToIdMap[$action];
                        $query = "SELECT coachs.*, activites.nom as activite_nom 
                                  FROM coachs 
                                  JOIN activites ON coachs.activite_id = activites.id 
                                  WHERE coachs.id = $coachId";
                        $result = mysqli_query($db_handle, $query);

                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                // Récupérer les données du coach
                                $coach = mysqli_fetch_assoc($result);

                                // Afficher les informations du coach et ses créneaux
                                echo "<div class='coach-container'>";
                                echo "<div class='coach-card'>";
                                echo "<img src='" . htmlspecialchars($coach['photo']) . "' alt='Photo du coach' class='coach-photo'>";
                                echo "<div class='coach-info'>";
                                echo "<h2 class='coach-name'>" . htmlspecialchars($coach['nom']) . "</h2>";
                                echo "<p>Bureau : " . htmlspecialchars($coach['bureau']) . "</p>";
                                echo "<p>Téléphone : " . htmlspecialchars($coach['Telephone']) . "</p>";
                                echo "<p>Email : " . htmlspecialchars($coach['Email']) . "</p>";
								echo "<a href='mailto:" . htmlspecialchars($coach['Email']) . "'><button>Contacter par mail</button></a>";
                                echo "<button type='button' onclick='prendreRendezVous(" . $coach['id'] . ")'>Prendre rendez-vous</button>";
                                echo "<button onclick='window.location.href=\"chatroom.php?coach_id=" . $coach['id'] . "\"'>Contacter le coach</button>";
                                echo "<button onclick='voirCV(\"" . htmlspecialchars($coach['CV']) . "\")'>Voir CV</button>";
                                echo "</div>";
								echo "</div>";
                        							
								
                                // Récupérer les créneaux du coach
                                $creneauxQuery = "SELECT * FROM creneaux WHERE coach_id = $coachId ORDER BY date, heure_debut";
                                $creneauxResult = mysqli_query($db_handle, $creneauxQuery);

                                echo "<div class='agenda-card'>";
						
                                echo "<h3>Agenda de la Semaine :</h3>";
                                if ($creneauxResult) {
                                    $dates = [
                                        '2024-06-01', '2024-06-02', '2024-06-03', '2024-06-04', 
                                        '2024-06-05', '2024-06-06', '2024-06-07', '2024-06-08'
                                    ];
                                    $creneauxParDate = [];

                                    // Initialiser les créneaux par date
                                    foreach ($dates as $date) {
                                        $creneauxParDate[$date] = [
                                            'AM' => [],
                                            'PM' => []
                                        ];
                                    }

                                    // Remplir les créneaux par date
                                    while ($creneaux = mysqli_fetch_assoc($creneauxResult)) {
                                        $date = $creneaux['date'];
                                        $heureDebut = new DateTime($creneaux['heure_debut']);
                                        $periode = $heureDebut->format('H') < 12 ? 'AM' : 'PM';
                                        $creneauxParDate[$date][$periode][] = $creneaux;
                                    }

                                    echo "<table class='table'>";
                                    echo "<thead><tr><th>Spécialité</th><th>Coach</th>";
                                    foreach ($dates as $date) {
                                        echo "<th colspan='2'>" . htmlspecialchars($date) . "</th>";
                                    }
                                    echo "</tr></thead>";
                                    echo "<tbody>";
                                    echo "<tr><td rowspan='2'>" . htmlspecialchars($coach['activite_nom']) . "</td>";
                                    echo "<td rowspan='2'>" . htmlspecialchars($coach['nom']) . "</td>";

                                    // Afficher les créneaux AM
                                    foreach ($dates as $date) {
                                        echo "<td>AM</td>";
                                        echo "<td>";
                                        if (empty($creneauxParDate[$date]['AM'])) {
                                            echo "<div class='empty-cell'>&nbsp;</div>";
                                        } else {
                                            foreach ($creneauxParDate[$date]['AM'] as $creneau) {
                                                echo "<div class='creneau' data-id='" . $creneau['id'] . "' data-type='" . $creneau['type'] . "' onclick='prendreRendezVous(" . $creneau['id'] . ")'>";
                                                echo htmlspecialchars($creneau['heure_debut'] . ' - ' . $creneau['heure_fin']);
                                                echo "</div>";
                                            }
                                        }
                                        echo "</td>";
                                    }
                                    echo "</tr><tr>";

                                    // Afficher les créneaux PM
                                    foreach ($dates as $date) {
                                        echo "<td>PM</td>";
                                        echo "<td>";
                                        if (empty($creneauxParDate[$date]['PM'])) {
                                            echo "<div class='empty-cell'>&nbsp;</div>";
                                        } else {
                                            foreach ($creneauxParDate[$date]['PM'] as $creneau) {
                                                echo "<div class='creneau' data-id='" . $creneau['id'] . "' data-type='" . $creneau['type'] . "' onclick='prendreRendezVous(" . $creneau['id'] . ")'>";
                                                echo htmlspecialchars($creneau['heure_debut'] . ' - ' . $creneau['heure_fin']);
                                                echo "</div>";
                                            }
                                        }
                                        echo "</td>";
                                    }

                                    echo "</tr></tbody>";
                                    echo "</table>";
                                } else {
                                    echo "Erreur lors de la récupération des créneaux : " . mysqli_error($db_handle);
                                }
                                echo "</div>"; // Fin de la agenda-card

                                echo "</div>"; // Fin de la coach-container
                            } else {
                                echo "Aucun coach trouvé avec l'ID $coachId.";
                            }
                        } else {
                            echo "Erreur lors de la récupération des informations du coach : " . mysqli_error($db_handle);
                        }
                    } else {
                        echo "Action invalide.";
                    }
                }

                mysqli_close($db_handle);
                ?>
            </section>
        </main>
        <footer>
            <p>Contactez-nous par mail, téléphone ou à notre adresse physique.</p>
        </footer>
    </div>
</body>
</html>
