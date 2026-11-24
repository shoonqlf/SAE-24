<?php
// ================================================================
//  SAE 24 - Partie Info - Etape 4 : Page web dynamique
//  ----------------------------------------------------------------
//  Affiche les dernieres mesures du capteur depuis MySQL.
//  Rafraichissement automatique toutes les 2 secondes.
//  A placer dans /var/www/html/ (Apache + PHP).
// ================================================================

$host = "localhost";
$user = "capteur";
$pass = "<MOT_DE_PASSE>";
$db   = "capteur_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connexion echouee : " . $conn->connect_error);
}

$res_last = $conn->query("SELECT id_capteur, valeur, date_heure FROM mesures ORDER BY id DESC LIMIT 1");
$statut = "Aucune donnee"; $heure = ""; $capteur = "";
if ($res_last && $res_last->num_rows > 0) {
    $row = $res_last->fetch_assoc();
    $statut  = ($row['valeur'] == 1) ? "Main detectee" : "Pas de presence";
    $heure   = $row['date_heure'];
    $capteur = $row['id_capteur'];
}

$res_list = $conn->query("SELECT id_capteur, valeur, date_heure FROM mesures ORDER BY id DESC LIMIT 10");
$res_stat = $conn->query("SELECT MIN(valeur) mn, MAX(valeur) mx, AVG(valeur) moy, COUNT(*) nb FROM mesures");
$stat = $res_stat->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="2">
    <title>Capteur de presence - SAE 24</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f0f0f0; text-align:center; padding:30px; }
        h1 { color:#1a3a6b; }
        .statut { font-size:42px; font-weight:bold; padding:30px 50px; border-radius:12px; display:inline-block; margin:20px; }
        .detecte { background:#d6efd6; color:#1d6b1d; }
        .absent { background:#eeeeee; color:#555; border:2px solid #ccc; }
        .heure { color:#777; font-size:15px; }
        table { margin:25px auto; border-collapse:collapse; min-width:480px; background:white; }
        th, td { border:1px solid #ccc; padding:8px 14px; font-size:14px; }
        th { background:#1a3a6b; color:white; }
        .stats { margin-top:15px; font-size:15px; }
        img { margin-top:25px; max-width:700px; border:1px solid #ccc; background:white; }
    </style>
</head>
<body>
    <h1>SAE 24 - Capteur de presence MTCH101</h1>
    <div class="statut <?php echo ($statut == 'Main detectee') ? 'detecte' : 'absent'; ?>">
        <?php echo $statut; ?>
    </div>
    <p class="heure">Capteur : <?php echo htmlspecialchars($capteur); ?> &mdash; Derniere mesure : <?php echo $heure; ?></p>
    <div class="stats">
        <?php if ($stat['nb'] > 0): ?>
            Mesures : <b><?php echo $stat['nb']; ?></b> | Min : <b><?php echo $stat['mn']; ?></b> | Max : <b><?php echo $stat['mx']; ?></b> | Moyenne : <b><?php echo number_format($stat['moy'], 2); ?></b>
        <?php endif; ?>
    </div>
    <table>
        <tr><th>Capteur</th><th>Valeur</th><th>Etat</th><th>Date / heure</th></tr>
        <?php if ($res_list && $res_list->num_rows > 0): ?>
            <?php while ($r = $res_list->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($r['id_capteur']); ?></td>
                    <td><?php echo $r['valeur']; ?></td>
                    <td><?php echo ($r['valeur'] == 1) ? 'Main detectee' : 'Pas de presence'; ?></td>
                    <td><?php echo $r['date_heure']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </table>
    <br><img src="courbe.png" width="600">
</body>
</html>
