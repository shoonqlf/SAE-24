// ================================================================
//  SAE 24 - Code Arduino + Ethernet Shield
//  ----------------------------------------------------------------
//  Lit le capteur de presence MTCH101 (sortie MTO sur la broche 2)
//  et envoie la mesure au serveur Python en TCP, format "capteur;valeur".
//  Transmission en TCP via Ethernet Shield (pas de pySerial/USB).
// ================================================================

#include <SPI.h>
#include <Ethernet.h>

// Adresse MAC d'exemple (a remplacer par celle imprimee sous le shield)
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };

// IP de l'Arduino dans le LAN collecteur
IPAddress ip(190, 51, 5, 53);
IPAddress gateway(190, 51, 5, 50);
IPAddress subnet(255, 255, 255, 240);

// IP + port du serveur Python
IPAddress serveur(190, 51, 5, 67);
const int PORT = 5000;

const char* ID_CAPTEUR = "capteur1";
const int PIN_MTO = 2;

EthernetClient client;

void setup() {
  Serial.begin(9600);
  pinMode(PIN_MTO, INPUT);
  Ethernet.begin(mac, ip, gateway, gateway, subnet);
  delay(1000);
  Serial.print("Arduino IP : ");
  Serial.println(Ethernet.localIP());
}

void loop() {
  // MTO actif-bas : LOW = presence detectee
  int presence = (digitalRead(PIN_MTO) == LOW) ? 1 : 0;
  envoyerTCP(presence);
  delay(1000);
}

void envoyerTCP(int valeur) {
  if (client.connect(serveur, PORT)) {
    client.print(ID_CAPTEUR);
    client.print(";");
    client.println(valeur);
    client.stop();
    Serial.print("Envoye : ");
    Serial.print(ID_CAPTEUR);
    Serial.print(";");
    Serial.println(valeur);
  } else {
    Serial.println("Connexion echouee");
  }
}
