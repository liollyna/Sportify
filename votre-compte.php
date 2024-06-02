

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Votre Compte</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="votre-compte.css" rel="stylesheet" type="text/css" /> 
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
        </header>
        <main class="d-flex flex-column align-items-center justify-content-center" style="height: 150vh;">
            <section class="text-center">
                <?php
                session_start();
				 // Vérifier si l'utilisateur demande la déconnexion
             if (isset($_POST['logout'])) {
               session_destroy();
              header("Location: votre-compte.php");
              exit();
                  }
    
                if (isset($_SESSION['user'])) {
                    $user = $_SESSION['user'];
					$_SESSION['user_id'] = $user['id'];
                    

                    
                    echo "<div class='alert alert-success text-center'>
                            Vous êtes connecté avec succès.<br>
                            Bonjour " . $user['nom'] . ".<br>
                            Email : " . $user['email'] . ".<br>
                            Adresse : " . $user['adresse'] . ".<br>
                            Téléphone : " . $user['telephone'] . ".<br>
                            Type de compte : " . $user['type'] . ".

                            <form method='post' action='votre-compte.php'>
                                <button type='submit' name='logout' class='btn btn-danger mt-3'>Se Déconnecter</button>
                            </form>
                          </div>";
                          // Vérifier si le type de compte est admin
                          if ($user['type'] == 'admin') {
                          // Afficher les fonctionnalités admin
                         echo "<h2>Fonctionnalités administrateur :</h2>
                         <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#deleteCoachModal'>Supprimer un coach</button>
                         <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#addCoachModal'>Ajouter un Coach</button>
                          <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#addCalender'>Modifier le calendrier</button>
                          <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#createAccountModal'>Créer un Compte</button>
                          <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addClientModal'name=addClient'>Ajouter un Client</button>
                          <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#deleteClientModal'>Supprimer un Client </button>";}
                          




                } else {
                    echo '<div class="caption">
                            <form method="post" action="votre-compte.php" class="mb-4">
                                <h2>Authentification </h2>
                                <label for="email">Email :</label>
                                <input type="email" id="email" name="email" class="form-control mb-2">
                                <label for="password">Mot de Passe :</label>
                                <input type="password" id="password" name="password" class="form-control mb-2">
                                <button type="submit" class="btn btn-primary">Se Connecter</button>
                            </form>




                            
                            <h2>Créer un Compte</h2>
                            <form method="post" action="votre-compte.php">
                                <label for="nom">Nom :</label>
                                <input type="text" id="nom" name="nom" required class="form-control mb-2">
                                <label for="email">Email :</label>
                                <input type="email" id="email" name="email" required class="form-control mb-2">
                                <label for="adresse">Adresse :</label>
                                <input type="text" id="adresse" name="adresse" class="form-control mb-2">
                                <label for="telephone">Téléphone :</label>
                                <input type="text" id="telephone" name="telephone" class="form-control mb-2">
                                <label for="mot_de_passe">Mot de Passe :</label>
                                <input type="password" id="mot_de_passe" name="mot_de_passe" required class="form-control mb-2">
                                <label for="type_compte">Type de Compte :</label>
                                <select id="type_compte" name="type_compte" class="form-control mb-2">
                                    <option value="client">Client</option>
                                    <option value="coach">Coach</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Créer un Compte</button>
                            </form>
                            <p>Catégories des services disponibles chez Sportify :</p>
                            <p>Gérez votre compte Sportify et accédez à vos informations personnelles.</p>
                        </div>';
                }





                
                ?>
                
                <!-- Modale pour créer un compte -->
                <div class="modal fade" id="createAccountModal" tabindex="-1" role="dialog" aria-labelledby="createAccountModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createAccountModalLabel">Créer un Compte1</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="votre-compte.php">
                                    <label for="nom">Nom :</label>
                                    <input type="text" id="nom" name="nom" required class="form-control mb-2">
                                    <label for="email">Email :</label>
                                    <input type="email" id="email" name="email" required class="form-control mb-2">
                                    <label for="adresse">Adresse :</label>
                                    <input type="text" id="adresse" name="adresse" class="form-control mb-2">
                                    <label for="telephone">Téléphone :</label>
                                    <input type="text" id="telephone" name="telephone" class="form-control mb-2">
                                    <label for="mot_de_passe">Mot de Passe :</label>
                                    <input type="password" id="mot_de_passe" name="mot_de_passe" required class="form-control mb-2">
                                    <label for="type_compte">Type de Compte :</label>
                                    <select id="type_compte" name="type_compte" class="form-control mb-2">
                                        <option value="admin"> Admin</option>
                                        
                                    </select>
                                    <button type="submit" name="createAccount" class="btn btn-primary">Créer un Compte</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Formulair pour ajouter un client -->
<div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Ajouter un Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button >
            </div>
            <div class="modal-body">
                <form method="post" action="votre-compte.php">
                    <div class="form-group">
                        <label for="clientName">Nom</label>
                        <input type="text" class="form-control" id="clientName" name="clientName" required>
                    </div>
                    <div class="form-group">
                        <label for="clientEmail">Email</label>
                        <input type="email" class="form-control" id="clientEmail" name="clientEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="clientAddress">Adresse</label>
                        <input type="text" class="form-control" id="clientAddress" name="clientAddress">
                    </div>
                    <div class="form-group">
                        <label for="clientPhone">Téléphone</label>
                        <input type="text" class="form-control" id="clientPhone" name="clientPhone">
                    </div>
                    <div class="form-group">
                        <label for="clientPassword">Mot de passe</label>
                        <input type="password" class="form-control" id="clientPassword" name="clientPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="addClient">Ajouter</button>
                </form>
            </div>

        </div>
    </div>
</div>
  <!-- Modale pour supprimer un client -->
<div class="modal fade" id="deleteClientModal" tabindex="-1" role="dialog" aria-labelledby="deleteClientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteClientModalLabel">Supprimer un Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="votre-compte.php">
                    <div class="form-group">
                        <label for="clientToDelete">Sélectionnez le client à supprimer :</label>
                        <select class="form-control" id="clientToDelete" name="clientToDelete" required>
                            <?php
                            $conn = new mysqli("localhost", "root", "", "spotify2");
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Récupérer uniquement les clients
                            $result = $conn->query("SELECT id, nom FROM utilisateurs WHERE type = 'client'");
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>Aucun client trouvé</option>";
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="suppClient" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>



                <!-- Modale pour ajouter un coach -->
                <div class="modal fade" id="addCoachModal" tabindex="-1" role="dialog" aria-labelledby="addCoachModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addCoachModalLabel">Ajouter un Coach</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="votre-compte.php" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="coachName">Nom</label>
                                        <input type="text" class="form-control" id="coachName" name="coachName" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="coachPhoto">Photo</label>
                                        <input type="file" class="form-control" id="coachPhoto" name="coachPhoto" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="coachCV">CV</label>
                                        <input type="file" class="form-control" id="coachCV" name="coachCV" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="coachOffice">Bureau</label>
                                        <input type="text" class="form-control" id="coachOffice" name="coachOffice" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="coachPhone">Téléphone</label>
                                        <input type="text" class="form-control" id="coachPhone" name="coachPhone" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="coachEmail">Email</label>
                                        <input type="email" class="form-control" id="coachEmail" name="coachEmail" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="coachActivity">Activité</label>
                                        <select class="form-control" id="coachActivity" name="coachActivity" required>
                                    </div>
            </div>
            </div>
            
      
            
            


                                            <!-- Remplir avec les activités disponibles -->
                                            <?php
                                            $conn = new mysqli("localhost", "root", "", "spotify2");
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }
                                            $result = $conn->query("SELECT * FROM activites");
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
                                                }
                                            }
                                            $conn->close();
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="coachRoom">Salle</label>
                                        <select class="form-control" id="coachRoom" name="coachRoom" required>
                                            <!-- Remplir avec les salles disponibles -->
                                            <?php
                                            $conn = new mysqli("localhost", "root", "", "spotify2");
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }
                                            $result = $conn->query("SELECT * FROM salles");
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
                                                }
                                            }
                                            $conn->close();
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" name="addCoach" class="btn btn-primary">Ajouter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                                        </div>
                
  <!-- Modale pour supprimer un coach -->
<div class="modal fade" id="deleteCoachModal" tabindex="-1" role="dialog" aria-labelledby="deleteCoachModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCoachModalLabel">Supprimer un Coach</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="votre-compte.php">
                    <div class="form-group">
                        <label for="coachToDelete">Sélectionnez le coach à supprimer :</label>
                        <select class="form-control" id="coachToDelete" name="coachToDelete" required>
                            <?php
                            $conn = new mysqli("localhost", "root", "", "spotify2");
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $result = $conn->query("SELECT * FROM coachs ");
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>Aucun coach trouvé</option>";
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <button type="submit" name="deleteCoach" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Vérifier si une demande de suppression de coach est soumise
if (isset($_POST['deleteCoach'])) {
    $conn = new mysqli("localhost", "root", "", "spotify2");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $coachToDelete = $_POST['coachToDelete'];
    
    // Supprimer le coach de la base de données
    $stmt = $conn->prepare("DELETE FROM coachs WHERE id = ?");
    $stmt->bind_param("i", $coachToDelete);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Coach supprimé avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Erreur lors de la suppression du coach.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>
<?php
// Vérifier si une demande de suppression de client est soumise
if (isset($_POST['suppClient'])) {
    $conn = new mysqli("localhost", "root", "", "spotify2");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $clientToDelete = $_POST['clientToDelete'];

    // Supprimer le client de la base de données
    $stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id = ? AND type = 'client'");
    $stmt->bind_param("i", $clientToDelete);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Client supprimé avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Erreur lors de la suppression du client.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<?php

// Vérifier si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $db_password = ""; // Assurez-vous de mettre votre mot de passe de base de données ici
    $dbname = "spotify2";
    $conn = new mysqli($servername, $username, $db_password, $dbname);

    // Vérifier la connexion à la base de données
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Vérifier si l'utilisateur demande la déconnexion
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: votre-compte.php");
        exit();
    }

    // Vérifier si les clés email et password existent dans le tableau $_POST pour l'authentification
    if (isset($_POST['email']) && isset($_POST['password']) && !isset($_POST['nom'])) {
        // Récupérer les valeurs du formulaire
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Préparer et exécuter la requête SQL pour vérifier les informations de connexion
        $query = "SELECT * FROM utilisateurs WHERE email='$email' AND mot_de_passe='$password'";
        $result = $conn->query($query);

        // Vérifier si l'utilisateur est authentifié avec succès
        if ($result->num_rows > 0) {
            // Récupérer les informations de l'utilisateur
            $user = $result->fetch_assoc();
            $_SESSION['user'] = $user;
            //header("Location: votre-compte.php");
            exit();
        } else {
            echo "<div class='container mt-5'>
                    <div class='alert alert-danger text-center'>
                        Adresse e-mail ou mot de passe incorrect.
                    </div>
                  </div>";
        }
    }

    // Vérifier si les informations de création de compte sont soumises
    if (isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['mot_de_passe']) && isset($_POST['type_compte'])) {
        // Récupérer les valeurs du formulaire de création de compte
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : null;
        $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : null;
        $mot_de_passe = $_POST['mot_de_passe'];
        $type_compte = $_POST['type_compte'];

        // Hacher le mot de passe
        $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);

        // Préparer la requête SQL pour insérer les données dans la table utilisateurs
        $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, adresse, telephone, mot_de_passe, type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nom, $email, $adresse, $telephone, $mot_de_passe_hache, $type_compte);


    





        
        // Exécuter la requête
        if ($stmt->execute()) {
            echo "<div class='container mt-5'>
                    <div class='alert alert-success text-center'>
                        Nouveau compte créé avec succès !
                    </div>
                  </div>";
        } else {
            echo "<div class='container mt-5'>
                    <div class='alert alert-danger text-center'>
                        Erreur : " . $stmt->error . "
                    </div>
                  </div>";
        }
    

        // Fermer la déclaration
        $stmt->close();
    
}

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    echo "";
}
?>
    <?php
if (isset($_POST['addCoach'])) {
    $conn = new mysqli("localhost", "root", "", "spotify2");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $coachName = $_POST['coachName'];
    $coachOffice = $_POST['coachOffice'];
    $coachPhone = $_POST['coachPhone'];
    $coachEmail = $_POST['coachEmail'];
    $coachActivity = $_POST['coachActivity'];
    $coachRoom = $_POST['coachRoom'];

    // Upload files
    $target_dir = __DIR__ . "Upload/";
    $coachPhoto = $_FILES['coachPhoto']['name'];
    $coachCV = $_FILES['coachCV']['name'];
    $target_file_photo = $target_dir . basename($_FILES["coachPhoto"]["name"]);
    $target_file_cv = $target_dir . basename($_FILES["coachCV"]["name"]);

    if (move_uploaded_file($_FILES["coachPhoto"]["tmp_name"], $target_file_photo) && move_uploaded_file($_FILES["coachCV"]["tmp_name"], $target_file_cv)) {
        $stmt = $conn->prepare("INSERT INTO coachs (nom, photo, CV, bureau, Telephone, Email, activite_id, salle_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisii", $coachName, $coachPhoto, $coachCV, $coachOffice, $coachPhone, $coachEmail, $coachActivity, $coachRoom);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Coach ajouté avec succès.</div>";
        } else {
            echo "<div class='alert alert-danger'>Erreur lors de l'ajout du coach.</div>";
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Erreur lors du téléchargement des fichiers.</div>";
    }

    $conn->close();
}
                ?>

                <?php
               
if (isset($_POST['deleteCoach'])) {
    $conn = new mysqli("localhost", "root", "", "spotify2");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $coachToDelete = $_POST['coachToDelete'];
    
    // Supprimer le coach de la base de données
    $stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->bind_param("i", $coachToDelete);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Coach supprimé avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Erreur lors de la suppression du coach.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>
<?php
// Vérifier si une demande de suppression de client est soumise
if (isset($_POST['suppClient'])) {
    $conn = new mysqli("localhost", "root", "", "spotify2");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $clientToDelete = $_POST['clientToDelete'];
    
    // Supprimer le client de la base de données
    $stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id = ? AND type = 'client'");
    $stmt->bind_param("i", $clientToDelete);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Client supprimé avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Erreur lors de la suppression du client.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>


<?php
if (isset($_POST['addClient'])) {
    $conn = new mysqli("localhost", "root", "", "spotify2");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupérer les valeurs du formulaire
    $nom = $_POST['clientName'];
    $email = $_POST['clientEmail'];
    $adresse = isset ($_POST['clientAddress'])? $_POST['clientAddress'] : null;
    $telephone = isset($_POST['clientPhone'])? $_POST['clientPhone'] : null;
    $mot_de_passe = $_POST['clientPassword'];
    
     // Hacher le mot de passe
     $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);
    

    // Préparer la requête SQL pour insérer les données dans la table clients
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, adresse, telephone, mot_de_passe) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nom, $email, $adresse, $telephone, $mot_de_passe);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Client ajouté avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de l'ajout du client : " . $stmt->error . "</div>";
    }

    // Fermer la déclaration
    $stmt->close();

    $conn->close();
}
?>

                ?>
     </section>
        </main>
        <footer>
            <p>© 2023 Sportify - Tous droits réservés.</p>
        </footer>
    </div>
  

</body>
</html>


</body>
</html>