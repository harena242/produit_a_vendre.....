<?php
// 1. Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base = "produit_a_vendre";

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base);

if ($connexion->connect_error) {
    die("Erreur de connexion : " . $connexion->connect_error);
}

// 2. Récupérer tous les produits avec les infos du vendeur
// (les plus récents en premier)
$sql = "SELECT produit.titre, produit.description, produit.prix, produit.photo,
               users.nom, users.telephone
        FROM produit
        INNER JOIN users ON produit.id_user = users.id_user
        ORDER BY produit.date_publication DESC";

$resultat = $connexion->query($sql);

// 3. Afficher les produits
if ($resultat->num_rows == 0) {
    echo "Aucun produit disponible pour le moment.";
}

while ($ligne = $resultat->fetch_assoc()) {
    echo "<div>";
    // La photo est enregistrée dans le dossier uploads de "ajout produit"
    echo "<img src='../ajout_produit/" . htmlspecialchars($ligne['photo']) . "' width='150'><br>";
    echo "<b>" . htmlspecialchars($ligne['titre']) . "</b><br>";
    echo "Prix : " . htmlspecialchars($ligne['prix']) . "<br>";
    echo htmlspecialchars($ligne['description']) . "<br>";
    echo "Vendeur : " . htmlspecialchars($ligne['nom']) . "<br>";
    echo "Téléphone : " . htmlspecialchars($ligne['telephone']) . "<br>";
    echo "</div>";
    echo "<hr>";
}

$connexion->close();
?>