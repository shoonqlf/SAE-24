<?php
// ================================================================
//  SAE 24 - Variante PHP d'insertion (optionnelle)
//  ----------------------------------------------------------------
//  Point d'entree HTTP qui insere une mesure dans la base.
//  NOTE : dans la version finale du projet, la reception des
//  donnees de l'Arduino se fait par le serveur Python (socket TCP,
//  voir /serveur). Ce fichier est conserve comme variante HTTP.
//
//  Les identifiants sont des placeholders : remplacer <MOT_DE_PASSE>
//  par le mot de passe reel avant deploiement (ne jamais commiter
//  un mot de passe en clair).
// ================================================================

$host = "localhost";
$user = "capteur";
$pass = "<MOT_DE_PASSE>";
$db   = "capteur_db";

// Valeur recue (0 = pas de presence, 1 = presence)
$valeur = isset($_GET['valeur']) ? intval($_GET['valeur']) : 0;
// Identifiant du capteur (par defaut capteur1)
$capteur = isset($_GET['capteur']) ? $_GET['capteur'] : "capteur1";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connexion echouee : " . $conn->connect_error);
}

// Requete preparee (protege contre les injections SQL)
$sql = "INSERT INTO mesures (id_capteur, valeur) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $capteur, $valeur);
$stmt->execute();

$stmt->close();
$conn->close();

echo "OK";
?>
