#include <OneWire.h>

#define CERVENA  5
#define ZELENA   6
#define ZLUTA    7
#define PWM_PIN  3
OneWire ds(8);  // pin pro DS18B20 (teplomery)

#define NOVY_RADEK "\r\n"

/* -------------------------------------------------------------- */ 
void setup() {
  Serial.begin(57600);  
  pinMode(CERVENA, OUTPUT);  
  pinMode(ZELENA,  OUTPUT);
  pinMode(ZLUTA,   OUTPUT);  
  pinMode(PWM_PIN, OUTPUT);
}
/* -------------------------------------------------------------- */ 

void loop() {

  if (Serial.available() > 0) {
    char nacteno = Serial.read();
    
    switch (nacteno) {
    case 'a': //CERVENA_ON    
      digitalWrite(CERVENA, HIGH);
      Serial.print("OK_CERVENA_ON");  // musi byt v " ne v '  (" vraci text, ' vraci cislo v ASCII)
      Serial.print(NOVY_RADEK);
      break;
      
    case 'b': //CERVENA_OFF    
      digitalWrite(CERVENA, LOW);
      Serial.print("OK_CERVENA_OFF"); 
      Serial.print(NOVY_RADEK);
      break;
      
    case 'c': //ZELENA_ON   
      digitalWrite(ZELENA, HIGH);
      Serial.print("OK_ZELENA_ON"); 
      Serial.print(NOVY_RADEK);
      break;  
      
    case 'd': //ZELENA_OFF   
      digitalWrite(ZELENA, LOW);
      Serial.print("OK_ZELENA_OFF"); 
      Serial.print(NOVY_RADEK);
      break; 
      
    case 'e': //ZLUTA_ON   
      digitalWrite(ZLUTA, HIGH);
      Serial.print("OK_ZLUTA_ON"); 
      Serial.print(NOVY_RADEK);
      break;  
      
    case 'f': //ZLUTA_OFF   
      digitalWrite(ZLUTA, LOW);
      Serial.print("OK_ZLUTA_OFF"); 
      Serial.print(NOVY_RADEK);
      break;  
      
    case 'g': //VSE_ON    
      digitalWrite(CERVENA, HIGH);
      digitalWrite(ZELENA, HIGH);
      digitalWrite(ZLUTA, HIGH);
      Serial.print("OK_VSE_ON"); 
      Serial.print(NOVY_RADEK);
      break;  
      
    case 'h': //VSE_OFF    
      digitalWrite(CERVENA, LOW);
      digitalWrite(ZELENA, LOW);
      digitalWrite(ZLUTA, LOW);
      Serial.print("OK_VSE_OFF"); 
      Serial.print(NOVY_RADEK);
      break;    

    case 'i': //PWM
      delay(1);  //pro 9600b
      //delayMicroseconds(200);  //pro 57600b
      if ( Serial.available() > 0 ) {
        int nactenoPWM = Serial.read();
        analogWrite(PWM_PIN, (nactenoPWM * 4));    
      }
      break;

    case 'j': //TEPLOMER      
      do {
        ;
      } while (zmerit());
      Serial.print("OK_VSE_ZMERENO");
      Serial.print(NOVY_RADEK);
      break;      
      
    default:
      Serial.print("NEZNAMY_PRIKAZ"); 
      Serial.print(NOVY_RADEK);
      }
    }
}
/* -------------------------------------------------------------- */ 
boolean zmerit(void) {
 int HighByte, LowByte, TReading, SignBit, Tc_100, Whole, Fract;
 byte i;
 byte present = 0;
 byte data[12];
 byte addr[8];
 
 if ( !ds.search(addr)) {
   Serial.print("Vsechna cidla zmerena.\n");
   ds.reset_search();
   return 0;
 }
 for( i = 0; i < 8; i++) {
   Serial.print(addr[i], HEX);
 }
 Serial.print("_");

 if ( OneWire::crc8( addr, 7) != addr[7]) {
   Serial.print("\nCRC is not valid!\n");
 }
 
 ds.reset();
 ds.select(addr);
 ds.write(0x44,1); // start conversion, with parasite power on at the end
 delay(1000);     // maybe 750ms is enough, maybe not
 // we might do a ds.depower() here, but the reset will take care of it.
 present = ds.reset();
 ds.select(addr);    
 ds.write(0xBE);         // Read Scratchpad

 for ( i = 0; i < 9; i++) {           // we need 9 bytes
   data[i] = ds.read();
 }


 LowByte = data[0];
 HighByte = data[1];
 TReading = (HighByte << 8) + LowByte;
 SignBit = TReading & 0x8000;  // test most sig bit

 if (!SignBit) {    // not? negative
   TReading = (TReading ^ 0xffff) + 1;    // 2's comp  
 }
 Tc_100 = (6 * TReading) + TReading / 4;    // multiply by (100 * 0.0625) or 6.25
 Whole = Tc_100 / 100 *-1;  // separate off the whole and fractional portions
 Fract = Tc_100 % 100 *-1;


 if (SignBit) {    // If its negative
   Serial.print("-");
 }
 else {
   Serial.print("+");
 }
 
 Serial.print(Whole);
 Serial.print(".");
 
 Serial.print(Fract);
 Serial.print("\n");
 Serial.print(NOVY_RADEK);
 delay(3000);
 return 1;
}  
/* -------------------------------------------------------------- */
