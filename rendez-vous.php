<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

$user_id = $_SESSION['user_id'];

$database = "spotify2";
$db_handle = mysqli_connect('localhost', 'root', '', $database);

if (!$db_handle) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Vérifier si l'utilisateur est un administrateur
$user_type_query = "SELECT type FROM utilisateurs WHERE id = $user_id";
$user_type_result = mysqli_query($db_handle, $user_type_query);
$user_type_row = mysqli_fetch_assoc($user_type_result);
$user_type = $user_type_row['type'];

$query = "SELECT rendez_vous.*, coachs.nom as coach_nom, activites.nom as activite_nom 
          FROM rendez_vous 
          JOIN coachs ON rendez_vous.coach_id = coachs.id 
          JOIN activites ON rendez_vous.activite_id = activites.id 
          WHERE rendez_vous.utilisateur_id = $user_id 
          ORDER BY date, heure";
$result = mysqli_query($db_handle, $query);

// Récupérer la date et l'heure actuelles
$currentDateTime = new DateTime();

// Initialiser les listes pour les rendez-vous passés et à venir
$pastAppointments = [];
$upcomingAppointments = [];

while ($row = mysqli_fetch_assoc($result)) {
    $appointmentDateTime = new DateTime($row['date'] . ' ' . $row['heure']);
    if ($appointmentDateTime < $currentDateTime) {
        $pastAppointments[] = $row;
    } else {
        $upcomingAppointments[] = $row;
    }
}

// Récupérer les données des coachs et des activités pour le formulaire d'ajout de créneau
$coachsQuery = "SELECT id, nom FROM coachs";
$coachsResult = mysqli_query($db_handle, $coachsQuery);

$activitesQuery = "SELECT id, nom FROM activites";
$activitesResult = mysqli_query($db_handle, $activitesQuery);

mysqli_close($db_handle);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Rendez-vous - Sportify</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
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
		color: rgb(255, 255, 255);
		font-size: 30px;
		text-align: center;
		padding: 50px;
		}
        .background-wrapper {
            background-image: url('AAA.jpg');
            background-size: cover;
        }
        .occasion-button {
            text-decoration: none;
            color: #333;
            padding: 10px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);
            transition: box-shadow 0.3s;
            display: inline-block;
            border-radius: 10px;
            width: 100px;
            text-align: center;
        }
        .texte1 {
            color: rgb(55, 107, 128);
            text-align: center;
        }

        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background-color: white;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .cancel-button {
            padding: 5px 10px;
            color: white;
            background-color: red;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .date, .time {
            display: block;
        }
        .date {
            font-weight: bold;
        }
        .time {
            color: grey;
        }
        .form-container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 20px;
        }
        .form-container h2 {
            text-align: center;
            color: rgb(51, 0, 255);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: rgb(51, 0, 255);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
		footer {
		background-color: rgba(51, 0, 255, 0.8);
		color: #fff;
		text-align: center;
		padding: 10px 0;
		margin-top: auto;
		}
    </style>
    <script>
        function annulerRendezVous(rendezVousId) {
            if (confirm("Voulez-vous vraiment annuler ce rendez-vous ?")) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'annuler-rendez-vous.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        alert('Rendez-vous annulé avec succès.');
                        location.reload();
                    } else {
                        alert('Erreur lors de l\'annulation du rendez-vous.');
                    }
                };
                xhr.send('rendezVousId=' + rendezVousId);
            }
        }
    </script>
</head>
<body>
    <div class="background-wrapper">
        <header>
            <h1 >Sportify - Consultation sportive en ligne</h1>
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
            <br><br>
        </header>
        <main>
            <section>
                <h1>Mes Rendez-vous</h1>
                <h2 style="text-align: center;">Rendez-vous à venir</h2>
                <?php if (count($upcomingAppointments) > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Coach</th>
                                <th>Activité</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($upcomingAppointments as $row): ?>
                                <?php
                                $appointmentDate = new DateTime($row['date']);
                                $appointmentTime = new DateTime($row['heure']);
                                ?>
                                <tr>
                                    <td><span class="date"><?php echo $appointmentDate->format('d/m/Y'); ?></span></td>
                                    <td><span class="time"><?php echo $appointmentTime->format('H:i'); ?></span></td>
                                    <td><?php echo htmlspecialchars($row['coach_nom']); ?></td>
                                    <td><?php echo htmlspecialchars($row['activite_nom']); ?></td>
                                    <td><button class="cancel-button" onclick="annulerRendezVous(<?php echo $row['id']; ?>)">Annuler</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center;">Vous n'avez aucun rendez-vous à venir.</p>
                <?php endif; ?>

                <h2 style="text-align: center;">Rendez-vous passés</h2>
                <?php if (count($pastAppointments) > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Coach</th>
                                <th>Activité</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pastAppointments as $row): ?>
                                <?php
                                $appointmentDate = new DateTime($row['date']);
                                $appointmentTime = new DateTime($row['heure']);
                                ?>
                                <tr>
                                    <td><span class="date"><?php echo $appointmentDate->format('d/m/Y'); ?></span></td>
                                    <td><span class="time"><?php echo $appointmentTime->format('H:i'); ?></span></td>
                                    <td><?php echo htmlspecialchars($row['coach_nom']); ?></td>
                                    <td><?php echo htmlspecialchars($row['activite_nom']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center;">Vous n'avez aucun rendez-vous passé.</p>
                <?php endif; ?>
                
                <?php if ($user_type === 'admin'): ?>
                    <div class="form-container">
                        <h2>Ajouter un créneau</h2>
                        <form action="ajouter-creneau.php" method="POST">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" id="date" name="date" required>
                            </div>
                            <div class="form-group">
                                <label for="heure_debut">Heure de début</label>
                                <input type="time" id="heure_debut" name="heure_debut" required>
                            </div>
                            <div class="form-group">
                                <label for="coach_id">Coach</label>
                                <select id="coach_id" name="coach_id" required>
                                    <?php while ($coach = mysqli_fetch_assoc($coachsResult)): ?>
                                        <option value="<?php echo $coach['id']; ?>"><?php echo htmlspecialchars($coach['nom']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="activite_id">Activité</label>
                                <select id="activite_id" name="activite_id" required>
                                    <?php while ($activite = mysqli_fetch_assoc($activitesResult)): ?>
                                        <option value="<?php echo $activite['id']; ?>"><?php echo htmlspecialchars($activite['nom']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit">Ajouter</button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
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
