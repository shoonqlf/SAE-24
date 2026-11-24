-- ================================================================
--  SAE 24 - Partie Info - Etape 1 : Base de donnees
--  ----------------------------------------------------------------
--  Creation de la base et de la table des mesures.
--  Lancer :  mysql < database.sql
-- ================================================================

CREATE DATABASE IF NOT EXISTS capteur_db;
USE capteur_db;

CREATE TABLE IF NOT EXISTS mesures (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    id_capteur  VARCHAR(50) NOT NULL,
    valeur      INT NOT NULL,
    date_heure  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Utilisateur dedie pour le programme Python
CREATE USER IF NOT EXISTS 'capteur'@'localhost' IDENTIFIED BY '<MOT_DE_PASSE>';
GRANT ALL PRIVILEGES ON capteur_db.* TO 'capteur'@'localhost';
FLUSH PRIVILEGES;
