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

// 2. Récupérer le titre tapé dans le formulaire
if (!isset($_GET['titre']) || trim($_GET['titre']) == "") {
    die("Veuillez écrire un titre à rechercher.");
}

$titre = $_GET['titre'];

// Les % permettent de trouver les titres qui CONTIENNENT le mot cherché
$recherche = "%" . $titre . "%";

// 3. Chercher les produits dont le titre ressemble au mot cherché
$requete = $connexion->prepare(
    "SELECT produit.titre, produit.description, produit.prix, produit.photo,
            users.nom, users.telephone
     FROM produit
     INNER JOIN users ON produit.id_user = users.id_user
     WHERE produit.titre LIKE ?
     ORDER BY produit.date_publication DESC"
);
$requete->bind_param("s", $recherche);
$requete->execute();
$resultat = $requete->get_result();

// 4. Afficher les produits trouvés
echo "<p>Résultat de la recherche : " . htmlspecialchars($titre) . "</p>";

if ($resultat->num_rows == 0) {
    echo "Aucun produit trouvé.";
}

while ($ligne = $resultat->fetch_assoc()) {
    echo "<div>";
    echo "<img src='../ajout_produit/" . htmlspecialchars($ligne['photo']) . "' width='150'><br>";
    echo "<b>" . htmlspecialchars($ligne['titre']) . "</b><br>";
    echo "Prix : " . htmlspecialchars($ligne['prix']) . "<br>";
    echo htmlspecialchars($ligne['description']) . "<br>";
    echo "Vendeur : " . htmlspecialchars($ligne['nom']) . "<br>";
    echo "Téléphone : " . htmlspecialchars($ligne['telephone']) . "<br>";
    echo "</div>";
    echo "<hr>";
}

$requete->close();
$connexion->close();
?>