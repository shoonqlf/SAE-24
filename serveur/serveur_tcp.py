# ================================================================
#  SAE 24 - Partie Info - Etape 2 : Serveur TCP de reception
#  ----------------------------------------------------------------
#  Serveur TCP (module socket) qui ecoute sur le reseau, recoit les
#  donnees envoyees par l'Arduino au format "capteur;valeur",
#  les decode et les insere dans la base MySQL.
#
#  Lancer :  python3 serveur_tcp.py
# ================================================================

import socket
import mysql.connector

# Connexion a la base de donnees
bdd = mysql.connector.connect(
    host="localhost",
    user="capteur",
    password="<MOT_DE_PASSE>",
    database="capteur_db"
)
curseur = bdd.cursor()

# Creation du serveur TCP qui ecoute sur le port 5000
serveur = socket.socket()
serveur.bind(("0.0.0.0", 5000))
serveur.listen()
print("Serveur en ecoute sur le port 5000")

while True:
    client, adresse = serveur.accept()
    donnee = client.recv(1024).decode().strip()
    client.close()

    # Verifie le format "capteur;valeur"
    if ";" not in donnee:
        continue
    capteur, valeur = donnee.split(";")
    if valeur.strip() == "":
        continue

    # Insertion dans la base de donnees
    curseur.execute(
        "INSERT INTO mesures (id_capteur, valeur) VALUES (%s, %s)",
        (capteur, int(valeur))
    )
    bdd.commit()
    print("Recu :", capteur, valeur)
