<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle de Sport Omnes</title>
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
			justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        header {
            background-color: rgba(51, 0, 255, 0.8);
            color: #fff;
            padding: 10px 0;
            text-align: center;
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
        .content-section {
            width: 80%;
            max-width: 800px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
			justify-content: center;
            align-items: center;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        h2 {
            color: rgb(55, 107, 128);
            text-align: center;
            font-size: 30px;
            margin-bottom: 20px;
        }
        .service-item {
            margin-bottom: 20px;
        }
        .service-item h3 {
            margin-top: 0;
        }
        .info-button, .appointment-button, .contact-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);
            transition: background-color 0.3s, box-shadow 0.3s;
            font-size: 16px;
        }
        .info-button {
            background-color: #007bff;
        }
        .appointment-button {
            background-color: #333;
        }
        .contact-button {
            background-color: #28a745;
        }
        .info-button:hover {
            background-color: #0056b3;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.7);
        }
        .appointment-button:hover {
            background-color: #555;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.7);
        }
        .contact-button:hover {
            background-color: #218838;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.7);
        }
        .salle-item {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            text-align: center;
        }
        .salle-photo {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .creneaux {
            text-align: left;
            margin-top: 10px;
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
    <header>
        <h1>Salle de Sport Omnes</h1>
        <nav>
            <ul>
				<li><a href="index.html">Retour à la page d'accueil</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#regles">Règles</a></li>
                <li><a href="#horaires">Horaires</a></li>
                <li><a href="#questionnaire">Questionnaire</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="background-wrapper">
            <section id="services" class="content-section">
                <h2>Services Disponibles</h2>
                <div class="service-item">
                    <h3>Matériel d'entraînement</h3>
                    <p>Nous offrons des machines performantes et de dernière génération pour tous les types d'entraînement.</p>
                    <p>Nos machines sont variées pour tous les niveaux et types d'entraînement</p>
                    <a href="info-matos.html" class="info-button">Plus d'informations</a>
                    
                </div>
                <div class="service-item">
                    <h3>Programmes Personnalisés</h3>
                    <p>Des programmes d'entraînement personnalisés avec nos coachs sont disponibles sur demande.</p>
                </div>
                <a href="rendez-vous.php" class="info-button">Prendre un rendez-vous</a>
	
                <div class="service-item">
				</br>
                    <h3>Cours Collectifs</h3>
                    <p>Participez à nos cours collectifs pour une séance d'entraînement dynamique et motivante.</p>
                </div>
            </section>
            
            <section id="salles" class="content-section">
                <h2>Salles de Sport Disponibles</h2>
                <?php
                // Connexion à la base de données
                $database = "spotify2";
                $db_handle = mysqli_connect('localhost', 'root', '', $database);

                if (!$db_handle) {
                    die("Échec de la connexion : " . mysqli_connect_error());
                }

                // Récupération des salles de sport
                $query = "SELECT * FROM salles";
                $result = mysqli_query($db_handle, $query);

                if ($result) {
                    while ($salle = mysqli_fetch_assoc($result)) {
                        echo "<div class='salle-item'>";
                        echo "<h3>" . htmlspecialchars($salle['nom']) . "</h3>";
                        echo "<img src='" . htmlspecialchars($salle['photo']) . "' alt='Photo de " . htmlspecialchars($salle['nom']) . "' class='salle-photo'>";
                        
                        // Inventer des créneaux d'ouverture
                        echo "<div class='creneaux'>";
                        echo "<h4>Créneaux d'ouverture :</h4>";
                        echo "<ul>";
                        echo "<li>Lundi - Vendredi: 6h00 - 22h00</li>";
                        echo "<li>Samedi: 8h00 - 20h00</li>";
                        echo "<li>Dimanche: 8h00 - 18h00</li>";
                        echo "</ul>";
                        echo "</div>"; // Fin des créneaux

                        echo "</div>"; // Fin de salle-item
                    }
                } else {
                    echo "Erreur lors de la récupération des salles : " . mysqli_error($db_handle);
                }

                mysqli_close($db_handle);
                ?>
            </section>

            <section id="regles" class="content-section">
                <h2>Règles d'Utilisation des Machines :</h2>
                <ul>
                    <li>Pour l'hygiène de tous, veillez nettoyer les machines après chaque utilisation.</li>
                    <li>Respecter les autres utilisateurs et limiter le temps d'utilisation des machines en période de forte affluence.</li>
                    <li>Signaler tout dysfonctionnement ou problème concernant les machines au personnel.</li>
                </ul>
                <h2>Dans les vestiaires :</h2>
                <ul>
                    <li>Pour les casiers, veuillez apporter vos propres cadenas. La gym ne n'est pas responsable des pertes ou vols de toutes affaires personnelles.</li>
                    <li>Utiliser une serviette personnelle.</li>
                    <li>Respecter des autres utilisateurs.</li>
                </ul>
            </section>

            <section id="horaires" class="content-section">
                <h2>Horaires de la Salle de sport :</h2>
                <p>Lundi - Vendredi: 6h00 - 22h00</p>
                <p>Samedi: 8h00 - 20h00</p>
                <p>Dimanche: 8h00 - 18h00</p>
            </section>

            <section id="questionnaire" class="content-section">
                <h2>Questionnaire pour les Nouveaux Utilisateurs</h2>
                <p>Veuillez répondre à ce questionnaire avant de continuer</p>
                <form>
                    <label for="name">Nom:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="experience">Expérience en Salle de Sport:</label>
                    <textarea id="experience" name="experience" rows="4" required></textarea>

                    <label for="goals">Objectifs d'Entraînement:</label>
                    <textarea id="goals" name="goals" rows="4" required></textarea>

                    <button type="submit">Envoyer</button>
                </form>
            </section>

            <section id="contact" class="content-section">
                <h2>Coordonnées du Responsable</h2>
                <p>Nom : Bastien Savard</p>
                <p>Email : bastien.savard@salledesportomnes.com <a href="mailto:bastien.savard@salledesportomnes.com" class="contact-button">Contacter par mail</a></p>
                <p>Téléphone : +33 6 87 53 68 19</p>
            </section>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Salle de Sport Omnes. Tous droits réservés.</p>
    </footer>
</body>
</html>
