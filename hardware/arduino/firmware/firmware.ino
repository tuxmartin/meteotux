#include <DHT22.h>

// Connect a 4.7K resistor between VCC and the data pin (strong pullup)
#define DHT22_PIN 2

// Setup a DHT22 instance
DHT22 myDHT22(DHT22_PIN);

void setup(void)
{
  Serial.begin(9600);
}

void loop(void)
{ 
  DHT22_ERROR_t errorCode;
  
  // The sensor can only be read from every 1-2s, and requires a minimum
  // 2s warm-up after power-on.
  delay(5000);
  
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
