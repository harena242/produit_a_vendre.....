<?php
// 1. Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe_bd = "";
$base = "produit_a_vendre";

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe_bd, $base);

if ($connexion->connect_error) {
    die("Erreur de connexion : " . $connexion->connect_error);
}

// 2. Vérifier que le formulaire a bien été envoyé
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Formulaire non envoyé.");
}

// 3. Récupérer les champs du formulaire
$nom = trim($_POST['nom'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$email = trim($_POST['email'] ?? '');
$mot_de_passe = $_POST['mot_de_passe'] ?? '';

// 4. Vérifier que rien n'est vide
if ($nom == "" || $telephone == "" || $email == "" || $mot_de_passe == "") {
    die("Tous les champs sont obligatoires.");
}

// 5. Vérifier que l'e-mail n'est pas déjà utilisé
$verification = $connexion->prepare("SELECT id_user FROM users WHERE email = ?");
$verification->bind_param("s", $email);
$verification->execute();
$verification->store_result();

if ($verification->num_rows > 0) {
    echo "Cet e-mail est déjà utilisé.<br>";
    echo "<a href='inscription.html'>Retour à l'inscription</a>";
    exit();
}
$verification->close();

// 6. Chiffrer le mot de passe
$mot_de_passe_chiffre = password_hash($mot_de_passe, PASSWORD_DEFAULT);

// 7. Insérer le nouvel utilisateur
$requete = $connexion->prepare(
    "INSERT INTO users (nom, telephone, email, mot_de_passe) VALUES (?, ?, ?, ?)"
);
$requete->bind_param("ssss", $nom, $telephone, $email, $mot_de_passe_chiffre);

if ($requete->execute()) {
    $requete->close();
    $connexion->close();
    // Redirection après inscription réussie
    header("Location: ../tout_produit/tout_produit.html");
    exit();
} else {
    echo "Erreur : " . $requete->error;
    $requete->close();
    $connexion->close();
}
?><?php
// 1. Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe_bd = "";
$base = "produit_a_vendre";

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe_bd, $base);

if ($connexion->connect_error) {
    die("Erreur de connexion : " . $connexion->connect_error);
}

// 2. Vérifier que le formulaire a bien été envoyé
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Formulaire non envoyé.");
}

// 3. Récupérer les champs du formulaire
$nom = trim($_POST['nom'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$email = trim($_POST['email'] ?? '');
$mot_de_passe = $_POST['mot_de_passe'] ?? '';

// 4. Vérifier que rien n'est vide
if ($nom == "" || $telephone == "" || $email == "" || $mot_de_passe == "") {
    die("Tous les champs sont obligatoires.");
}

// 5. Vérifier que l'e-mail n'est pas déjà utilisé
$verification = $connexion->prepare("SELECT id_user FROM users WHERE email = ?");
$verification->bind_param("s", $email);
$verification->execute();
$verification->store_result();

if ($verification->num_rows > 0) {
    echo "Cet e-mail est déjà utilisé.<br>";
    echo "<a href='inscription.html'>Retour à l'inscription</a>";
    exit();
}
$verification->close();

// 6. Chiffrer le mot de passe
$mot_de_passe_chiffre = password_hash($mot_de_passe, PASSWORD_DEFAULT);

// 7. Insérer le nouvel utilisateur
$requete = $connexion->prepare(
    "INSERT INTO users (nom, telephone, email, mot_de_passe) VALUES (?, ?, ?, ?)"
);
$requete->bind_param("ssss", $nom, $telephone, $email, $mot_de_passe_chiffre);

if ($requete->execute()) {
    $requete->close();
    $connexion->close();
    // Redirection après inscription réussie
    header("Location: ../tout_produit/tout_produit.html");
    exit();
} else {
    echo "Erreur : " . $requete->error;
    $requete->close();
    $connexion->close();
}
?><?php
// 1. Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe_bd = "";
$base = "produit_a_vendre";

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe_bd, $base);

if ($connexion->connect_error) {
    die("Erreur de connexion : " . $connexion->connect_error);
}

// 2. Vérifier que le formulaire a bien été envoyé
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Formulaire non envoyé.");
}

// 3. Récupérer les champs du formulaire
$nom = trim($_POST['nom'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$email = trim($_POST['email'] ?? '');
$mot_de_passe = $_POST['mot_de_passe'] ?? '';

// 4. Vérifier que rien n'est vide
if ($nom == "" || $telephone == "" || $email == "" || $mot_de_passe == "") {
    die("Tous les champs sont obligatoires.");
}

// 5. Vérifier que l'e-mail n'est pas déjà utilisé
$verification = $connexion->prepare("SELECT id_user FROM users WHERE email = ?");
$verification->bind_param("s", $email);
$verification->execute();
$verification->store_result();

if ($verification->num_rows > 0) {
    echo "Cet e-mail est déjà utilisé.<br>";
    echo "<a href='inscription.html'>Retour à l'inscription</a>";
    exit();
}
$verification->close();

// 6. Chiffrer le mot de passe
$mot_de_passe_chiffre = password_hash($mot_de_passe, PASSWORD_DEFAULT);

// 7. Insérer le nouvel utilisateur
$requete = $connexion->prepare(
    "INSERT INTO users (nom, telephone, email, mot_de_passe) VALUES (?, ?, ?, ?)"
);
$requete->bind_param("ssss", $nom, $telephone, $email, $mot_de_passe_chiffre);

if ($requete->execute()) {
    $requete->close();
    $connexion->close();
    // Redirection après inscription réussie
    header("Location: ../accueil/accueil.html");
    exit();
} else {
    echo "Erreur : " . $requete->error;
    $requete->close();
    $connexion->close();
}
?>