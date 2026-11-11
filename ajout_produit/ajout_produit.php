<?php
// On démarre la session pour savoir quel utilisateur est connecté
session_start();

// 1. Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base = "produit_a_vendre";

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base);

if ($connexion->connect_error) {
    die("Erreur de connexion : " . $connexion->connect_error);
}

// 2. Vérifier que l'utilisateur est connecté
// (la page de connexion mettra id_user dans la session plus tard)
if (!isset($_SESSION['id_user'])) {
    die("Vous devez être connecté pour publier un produit.");
}
$id_user = $_SESSION['id_user'];

// 3. Vérifier que le formulaire a bien été envoyé
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Formulaire non envoyé.");
}

// 4. Récupérer les champs du formulaire
$titre = $_POST['titre'];
$description = $_POST['description'];
$prix = $_POST['prix'];

// 5. Gérer la photo
if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== 0) {
    die("Erreur lors de l'envoi de la photo.");
}

// On vérifie que c'est bien une image (jpg, png, gif, webp)
$extensions_permises = ["jpg", "jpeg", "png", "gif", "webp"];
$extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

if (!in_array($extension, $extensions_permises)) {
    die("Le fichier doit être une image (jpg, png, gif ou webp).");
}

// On crée le dossier "uploads" s'il n'existe pas
if (!is_dir("uploads")) {
    mkdir("uploads");
}

// On donne un nom unique à la photo pour éviter les doublons
$nom_photo = uniqid() . "." . $extension;
$chemin_photo = "uploads/" . $nom_photo;

// On déplace la photo dans le dossier uploads
if (!move_uploaded_file($_FILES['photo']['tmp_name'], $chemin_photo)) {
    die("Impossible d'enregistrer la photo.");
}

// 6. Insérer le produit dans la table "produit"
$requete = $connexion->prepare(
    "INSERT INTO produit (titre, description, prix, photo, id_user) VALUES (?, ?, ?, ?, ?)"
);
$requete->bind_param("ssdsi", $titre, $description, $prix, $chemin_photo, $id_user);

if ($requete->execute()) {
    echo "Produit publié avec succès !<br>";
    echo "<a href='ajout_produit.html'>Ajouter un autre produit</a>";
} else {
    echo "Erreur : " . $requete->error;
}

$requete->close();
$connexion->close();
?>