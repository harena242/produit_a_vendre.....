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
if (!isset($_SESSION['id_user'])) {
    die("Vous devez être connecté pour voir vos produits.");
}
$id_user = $_SESSION['id_user'];

// 3. Sélectionner seulement les produits de cet utilisateur
$requete = $connexion->prepare(
    "SELECT titre, description, prix, photo, date_publication
     FROM produit
     WHERE id_user = ?
     ORDER BY date_publication DESC"
);
$requete->bind_param("i", $id_user);
$requete->execute();
$resultat = $requete->get_result();

// 4. Afficher les produits
if ($resultat->num_rows == 0) {
    echo "Vous n'avez pas encore publié de produit.";
}

while ($ligne = $resultat->fetch_assoc()) {
    echo "<div>";
    // La photo est enregistrée dans le dossier uploads de "ajout produit"
    echo "<img src='../ajout_produit/" . htmlspecialchars($ligne['photo']) . "' width='150'><br>";
    echo "<b>" . htmlspecialchars($ligne['titre']) . "</b><br>";
    echo "Prix : " . htmlspecialchars($ligne['prix']) . "<br>";
    echo htmlspecialchars($ligne['description']) . "<br>";
    echo "Publié le : " . htmlspecialchars($ligne['date_publication']) . "<br>";
    echo "</div>";
    echo "<hr>";
}

$requete->close();
$connexion->close();
?>