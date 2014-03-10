#include "DHT22.h"

// Connect a 4.7K resistor between VCC and the data pin (strong pullup)
#define DHT22_PIN 8

// Setup a DHT22 instance
DHT22 myDHT22(DHT22_PIN);

// #############################

// A4 is referred to as Pin 18
// A5 is referred to as Pin 19
const byte relayPin1 =  18;      // the number of the LED pin
const byte relayPin2 =  19;      // the number of the LED pin

// Variables will change:
int relayState = LOW;
long previousMillis = 0; 
long previousMillisDHT = 0;

// the follow variables is a long because the time, measured in miliseconds,
// will quickly become a bigger number than can be stored in an int.
long interval = 900000;
long relayOnInterval = 10000;
long intervalDHT = 5000;

unsigned long currentMillis;

DHT22_ERROR_t errorCode;

void setup() {
  Serial.begin(9600);
  //Serial.println("START");
  pinMode(relayPin1, OUTPUT); 
  pinMode(relayPin2, OUTPUT);   
}

void loop() {  
  currentMillis = millis(); // milis = "Arduino uptime."
  
  if (Serial.available() > 0) {
    char inChar = Serial.read();
    if (inChar == 'r') {
      previousMillis = currentMillis;
      relayState = LOW;
      //Serial.println("reset casovace z PC");
    }
  }
 
  if(currentMillis - previousMillis > interval) {
    //Serial.println("pretekl casovac, zapinam rele");
    previousMillis = currentMillis;      
    relayState = HIGH;    
  }
  
  if (relayState == HIGH) {
    if(currentMillis - previousMillis > relayOnInterval) {
      //Serial.println("vypinam rele");
      relayState = LOW;
    }
  }
  
  digitalWrite(relayPin1, relayState);
  digitalWrite(relayPin2, relayState);
  
  dht();
}

void dht(){
  if(currentMillis - previousMillisDHT > intervalDHT) {
    previousMillisDHT = currentMillis;
    
    // The sensor can only be read from every 1-2s, and requires a minimum
    // 2s warm-up after power-on.
        
    //Serial.print("Requesting data...");
    errorCode = myDHT22.readData();
    switch(errorCode)
    {
      case DHT_ERROR_NONE:
        //Serial.print("Got Data ");
        Serial.print(myDHT22.getTemperatureC());
        Serial.print("C ");
        Serial.print(myDHT22.getHumidity());
        Serial.println("%");
        break;
      case DHT_ERROR_CHECKSUM:
        Serial.print("check_sum_error ");
        Serial.print(myDHT22.getTemperatureC());
        Serial.print("C ");
        Serial.print(myDHT22.getHumidity());
        Serial.println("%");
        break;
      case DHT_BUS_HUNG:
        Serial.println("BUS_Hung");
        break;
      case DHT_ERROR_NOT_PRESENT:
        Serial.println("Not_Present");
        break;
      case DHT_ERROR_ACK_TOO_LONG:
        Serial.println("ACK_time_out");
        break;
      case DHT_ERROR_SYNC_TIMEOUT:
        Serial.println("Sync_Timeout");
        break;
      case DHT_ERROR_DATA_TIMEOUT:
        Serial.println("Data_Timeout");
        break;
      case DHT_ERROR_TOOQUICK:
        Serial.println("Polled_to_quick");
        break;
    }
  }
}
