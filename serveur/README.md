# Serveur

| Fichier | Ce qu'il fait |
|---|---|
| `serveur_tcp.py` | reçoit les mesures de l'Arduino (module `socket`) et les met dans MySQL |
| `exploitation.py` | calcule min, max, moyenne et trace la courbe avec Matplotlib |

```bash
pip3 install mysql-connector-python matplotlib

python3 serveur_tcp.py        # écoute sur le port 5000
python3 exploitation.py       # génère courbe.png
```

Le mot de passe MySQL est `<MOT_DE_PASSE>` dans les fichiers, à remplacer avant de lancer. Les données arrivent sous la forme `capteur;valeur`, par exemple `capteur1;1`.
