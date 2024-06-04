<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: votre-compte.php");
    exit();
}

// Récupérer les informations de l'utilisateur connecté
$user = $_SESSION['user'];
$user_id = $user['id'];
$user_type = $user['type'];

$servername = "localhost";
$username = "root";
$db_password = ""; // Assurez-vous de mettre votre mot de passe de base de données ici
$dbname = "spotify2";

$conn = new mysqli($servername, $username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les utilisateurs pour le formulaire de sélection
$users = [];
$query = "SELECT id, nom FROM utilisateurs WHERE id != $user_id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Récupérer les messages entre l'utilisateur connecté et les autres utilisateurs
$messages = [];
$query = "SELECT m.contenu, m.date_envoi, u.nom AS sender_name 
          FROM messages m 
          JOIN utilisateurs u ON (m.utilisateur_id = u.id OR m.coach_id = u.id)
          WHERE (m.utilisateur_id = $user_id OR m.coach_id = $user_id)
          AND (u.id != $user_id)
          ORDER BY m.date_envoi ASC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

// Gérer l'envoi de messages
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message']) && isset($_POST['recipient_id'])) {
    $message = $conn->real_escape_string($_POST['message']);
    $recipient_id = intval($_POST['recipient_id']);

    if ($user_type === 'client') {
        $query = "INSERT INTO messages (utilisateur_id, coach_id, contenu, date_envoi) VALUES ($user_id, $recipient_id, '$message', NOW())";
    } else {
        $query = "INSERT INTO messages (utilisateur_id, coach_id, contenu, date_envoi) VALUES ($recipient_id, $user_id, '$message', NOW())";
    }

    if ($conn->query($query) === TRUE) {
        header("Location: chatroom.php");
        exit();
    } else {
        echo "Erreur : " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="chatroom.css" rel="stylesheet" type="text/css">
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <title>Chatroom</title>
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
.texte1 {
    color: rgb(55, 107, 128);
    text-align: center;
    margin-bottom: 20px;
}

footer {
    background-color: rgba(51, 0, 255, 0.8);
    color: #fff;
    text-align: center;
    padding: 10px 0;
    margin-top: auto;
}

.chat-section {
    width: 80%;
    max-width: 800px;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
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


</style>
</head>
<body>
    <div class="background-wrapper">
        <header>
            <h1>Chatroom - Sportify</h1>
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
            <section class="chat-section">
                <h2 class="texte1">Messages</h2>
                <div class="messages caption">
                    <?php foreach ($messages as $message): ?>
                        <div class="message">
                            <p><?php echo htmlspecialchars($message['contenu']); ?></p>
                            <span><?php echo htmlspecialchars($message['sender_name']); ?> - <?php echo htmlspecialchars($message['date_envoi']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <form method="post" action="chatroom.php" class="message-form">
                    <label for="recipient">Envoyer à :</label>
                    <select name="recipient_id" id="recipient" required>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['nom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <textarea name="message" placeholder="Votre message..." required></textarea>
                    <button type="submit" class="button">Envoyer</button>
                </form>
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
