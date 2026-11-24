# Code Arduino

| Fichier | Ce qu'il fait |
|---|---|
| `capteur_presence_mtch101.ino` | version de test : lit le capteur et affiche l'état dans le moniteur série |
| `capteur_arduino_ethernet.ino` | version finale : lit le capteur et envoie la mesure en TCP avec le shield Ethernet |

Le capteur est un MTCH101 (Microchip), un détecteur de proximité capacitif : quand une main s'approche, sa sortie passe à l'état bas.

L'envoi se fait en TCP vers le serveur, au format `capteur;valeur`, sans liaison série pour les données (c'était imposé par le sujet).

L'adresse MAC du sketch (`DE:AD:BE:EF:FE:ED`) est une valeur d'exemple : mets celle collée sous ton shield.
