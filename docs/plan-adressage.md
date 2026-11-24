# Plan d'adressage — SAÉ 24

Préfixe global : **190.51.5.0/24** — Routage dynamique **EIGRP (AS 1)**

> Les liens entre routeurs sont en `/30` (2 adresses utilisables, idéal pour du point-à-point).
> Les réseaux locaux (LAN) sont en `/28` (14 adresses utilisables).

## Liens d'interconnexion (backbone, /30)

| Lien | Réseau | Routeur A | Routeur B |
|------|--------|-----------|-----------|
| R1 ↔ R2 | 190.51.5.0/30 | R1 f0/0 = .1 | R2 f0/0 = .2 |
| R1 ↔ R3 | 190.51.5.4/30 | R1 f1/0 = .5 | R3 f0/0 = .6 |
| R2 ↔ R4 | 190.51.5.8/30 | R2 f1/0 = .9 | R4 f0/0 = .10 |
| R3 ↔ R4 | 190.51.5.12/30 | R3 f1/0 = .13 | R4 f1/0 = .14 |
| R2 ↔ R5 | 190.51.5.16/30 | R2 f2/0 = .17 | R5 f0/0 = .22 — **lien redondant** |

## Réseaux locaux (LAN, /28)

| LAN | Réseau | Passerelle(s) | Hôtes |
|-----|--------|---------------|-------|
| LAN Collecteur | 190.51.5.48/28 | R3 f2/0 = .50 | Collecteur .51, Visu .52 |
| LAN Serveur | 190.51.5.64/28 | R4 f2/0 = .65 (+ R5 f1/0 = .66, redondant) | Serveur .67, W1 .68, W2 .69 |

## Postes et équipements

| Équipement | Adresse IP | Passerelle | Rôle |
|------------|-----------|------------|------|
| Collecteur | 190.51.5.51/28 | .50 | Reçoit les données du capteur |
| Visu | 190.51.5.52/28 | .50 | Poste de visualisation (navigateur) |
| Arduino | 190.51.5.53/28 | .50 | Capteur de présence (envoi TCP) |
| Serveur | 190.51.5.67/28 | .65 | MySQL + Apache/PHP + serveur Python |
| W1 | 190.51.5.68/28 | .65 | Poste de travail (isolé par ACL) |
| W2 | 190.51.5.69/28 | .65 | Poste de travail (isolé par ACL) |

## Sécurité — Isolation par ACL

Les postes de travail **W1 et W2** sont dans le LAN serveur mais **isolés du système de collecte**
par une liste de contrôle d'accès étendue (`BLOQUER_POSTES`) appliquée en entrée sur l'interface
`f2/0` de **R4** :

```
ip access-list extended BLOQUER_POSTES
 deny   ip host 190.51.5.68 190.51.5.48 0.0.0.15   ! W1 -> LAN collecteur : bloqué
 deny   ip host 190.51.5.69 190.51.5.48 0.0.0.15   ! W2 -> LAN collecteur : bloqué
 permit ip any any                                 ! tout le reste : autorisé
```

Preuve de fonctionnement : un `ping` de W1 vers le collecteur renvoie
*« Communication administratively prohibited »* (le trafic est bien filtré par R4).
