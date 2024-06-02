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
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-around;
        }
        .texte1 {
            color: rgb(55, 107, 128);
            text-align: center;
        }
        h1 {
            color: rgb(51, 0, 255);
            font-size: 30px;
            text-align: center;
            padding: 50px;
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
            <h1 class="texte1">Sportify - Consultation sportive en ligne</h1>
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
                                <tr>
                                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['heure']); ?></td>
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
                                <tr>
                                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['heure']); ?></td>
                                    <td><?php echo htmlspecialchars($row['coach_nom']); ?></td>
                                    <td><?php echo htmlspecialchars($row['activite_nom']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center;">Vous n'avez aucun rendez-vous passé.</p>
                <?php endif; ?>
            </section>
        </main>
        <footer>
            <p style="text-align: center;">Contactez-nous par mail, téléphone ou à notre adresse physique.</p>
        </footer>
    </div>
</body>
</html>
