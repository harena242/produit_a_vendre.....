<?php
// On démarre la session pour garder l'utilisateur connecté
session_start();

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
$email = $_POST['email'];
$mot_de_passe = $_POST['mot_de_passe'];

// 4. Chercher l'utilisateur avec cet e-mail
$requete = $connexion->prepare(
    "SELECT id_user, mot_de_passe FROM users WHERE email = ?"
);
$requete->bind_param("s", $email);
$requete->execute();
$resultat = $requete->get_result();

// 5. Vérifier le mot de passe
if ($resultat->num_rows == 1) {
    $ligne = $resultat->fetch_assoc();

    // password_verify compare le mot de passe tapé avec le mot de passe chiffré
    if (password_verify($mot_de_passe, $ligne['mot_de_passe'])) {

        // Connexion réussie : on garde l'identifiant dans la session
        $_SESSION['id_user'] = $ligne['id_user'];

        // On envoie l'utilisateur vers la page "mes produits"
        header("Location: ../accueil/accueil.html");
        exit();
    }
}

// Si on arrive ici, l'e-mail ou le mot de passe est faux
echo "E-mail ou mot de passe incorrect.<br>";
echo "<a href='connexion.html'>Réessayer</a>";

$requete->close();
$connexion->close();
?>