# Configurations des équipements réseau

Configurations Cisco IOS extraites de la maquette GNS3 (fichiers `startup-config`).

| Fichier | Équipement | Rôle |
|---------|-----------|------|
| `R1.cfg` | Routeur R1 | Backbone (coin du losange de redondance) |
| `R2.cfg` | Routeur R2 | Backbone + lien redondant vers R5 |
| `R3.cfg` | Routeur R3 | Backbone + passerelle du LAN collecteur (.50) |
| `R4.cfg` | Routeur R4 | Backbone + passerelle du LAN serveur (.65) + **ACL BLOQUER_POSTES** |
| `R5.cfg` | Routeur R5 | Chemin redondant vers le LAN serveur (.66) |
| `SW1.cfg` | Switch SW1 | Commutation du LAN collecteur (EtherSwitch c3725 + NM-16ESW) |
| `SW2.cfg` | Switch SW2 | Commutation du LAN serveur (EtherSwitch c3725 + NM-16ESW) |

Tous les routeurs exécutent **EIGRP (AS 1)**. Le filtrage inter-réseaux est porté par
la liste de contrôle d'accès `BLOQUER_POSTES` sur **R4** (voir `R4.cfg`).

> Les adresses `190.51.5.0/24` sont le plan d'adressage pédagogique imposé par le sujet
> (réseau émulé, non routable sur Internet).
