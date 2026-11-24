const int PIN_MTO = 2;

void setup() {
  Serial.begin(9600);
  pinMode(PIN_MTO, INPUT);
}

void loop() {
  int etatMTO = digitalRead(PIN_MTO);

  if (etatMTO == LOW) {
    Serial.println("PRESENCE DETECTEE");
  } else {
    Serial.println("Pas de presence");
  }

  delay(1000);
}
