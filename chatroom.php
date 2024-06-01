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
    <title>Chatroom</title>
</head>
<body>
    <div class="background-wrapper">
        <header>
            <h1>Chatroom - Sportify</h1>
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
        <footer>
            <p>Contactez-nous par mail, téléphone ou à notre adresse physique.</p>
        </footer>
    </div>
</body>
</html>
