# Page web

| Fichier | Ce qu'il fait |
|---|---|
| `affichage.php` | état actuel du capteur, dernières mesures, statistiques, rafraîchie toutes les 2 secondes |
| `insert.php` | variante pour insérer une mesure en HTTP, pas utilisée dans la version finale (c'est le serveur Python qui reçoit) |

```bash
sudo cp affichage.php insert.php /var/www/html/
```

Puis `http://<ip-serveur>/affichage.php`. Le mot de passe est `<MOT_DE_PASSE>` à remplacer. `insert.php` utilise une requête préparée contre les injections SQL, et tout passe par le compte `capteur`, jamais `root`.
