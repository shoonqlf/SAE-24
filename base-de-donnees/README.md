# Base de données

`database.sql` crée la base `capteur_db` avec la table `mesures` :

| Colonne | Type | Rôle |
|---|---|---|
| `id` | INT, clé primaire, auto-incrément | identifiant de la mesure |
| `id_capteur` | VARCHAR(50) | nom du capteur, par exemple `capteur1` |
| `valeur` | INT | 1 pour présence, 0 pour absence |
| `date_heure` | DATETIME | date de la mesure, mise automatiquement |

```bash
# remplace <MOT_DE_PASSE> dans database.sql avant
sudo mysql < database.sql
```

Le script crée aussi un utilisateur `capteur` qui n'a de droits que sur cette base, pour ne pas utiliser `root` dans les programmes.
