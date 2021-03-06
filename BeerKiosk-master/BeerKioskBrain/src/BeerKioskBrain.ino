/*
 * Project BeerKioskParticle
 * Description:
 * Author:
 * Date:
 */
//int firstInput = D7;

int statusLed    = 4;
int indicatorLed = D7;
int pump = D2;
int sensorInterrupt = 1;  // 0 = digital pin 2
int sensorPin       = 1;

// The hall-effect flow sensor outputs approximately 4.5 pulses per second per
// litre/minute of flow.
float calibrationFactor = 4.5;

volatile byte pulseCount;  

float flowRate;
unsigned int flowMilliLitres;
unsigned long totalMilliLitres;
bool pouring;
unsigned long timeStart;
unsigned long oldTime;
int pourSize;
// setup() runs once, when the device is first turned on.
void setup() {
Serial.begin(38400);
Particle.function("pourDrink", pourDrink);

  // Put initialization like pinMode and begin functions here.
  //pinMode(firstInput,OUTPUT);

  pinMode(indicatorLed, OUTPUT);
  pinMode(statusLed, OUTPUT);
  pinMode(pump, OUTPUT);
  digitalWrite(pump,HIGH);
  digitalWrite(statusLed, HIGH);  // We have an active-low LED attached
  
  pinMode(sensorPin, INPUT);
  digitalWrite(sensorPin, HIGH);

  pulseCount        = 0;
  flowRate          = 0.0;
  flowMilliLitres   = 0;
  totalMilliLitres  = 0;
  oldTime           = 0;
  timeStart = 0;
  pouring = false;
  pourSize = 6265;

  Particle.subscribe("Change Pour", changePourSize);

  // The Hall-effect sensor is connected to pin 2 which uses interrupt 0.
  // Configured to trigger on a FALLING state change (transition from HIGH
  // state to LOW state)
  attachInterrupt(sensorInterrupt, pulseCounter, FALLING);
}

// loop() runs over and over again, as quickly as it can execute.
void loop() {
  // The core of your code will likely live here.
  //digitalWrite(firstInput, LOW);
  
  if(totalMilliLitres >= pourSize){
    pouring = false;
    Particle.publish("Dispensed", "true");
    digitalWrite(pump, HIGH);
    totalMilliLitres = 0;
  }
  
  if(pouring && ((unsigned long) millis() - timeStart) >25000){
    Particle.publish("Dispensed", "false");
    pouring = false;
    digitalWrite(pump, HIGH);
    totalMilliLitres = 0;
  }

  


   if((millis() - oldTime) > 1000)    // Only process counters once per second
  { 
    // Disable the interrupt while calculating flow rate and sending the value to
    // the host
    detachInterrupt(sensorInterrupt);
        
    // Because this loop may not complete in exactly 1 second intervals we calculate
    // the number of milliseconds that have passed since the last execution and use
    // that to scale the output. We also apply the calibrationFactor to scale the output
    // based on the number of pulses per second per units of measure (litres/minute in
    // this case) coming from the sensor.
    flowRate = ((1000.0 / (millis() - oldTime)) * pulseCount) / calibrationFactor;
    
    // Note the time this processing pass was executed. Note that because we've
    // disabled interrupts the millis() function won't actually be incrementing right
    // at this point, but it will still return the value it was set to just before
    // interrupts went away.
    oldTime = millis();
    
    // Divide the flow rate in litres/minute by 60 to determine how many litres have
    // passed through the sensor in this 1 second interval, then multiply by 1000 to
    // convert to millilitres.
    flowMilliLitres = (flowRate / 60) * 1000;
    
    // Add the millilitres passed in this second to the cumulative total
    totalMilliLitres += flowMilliLitres;
      
    unsigned int frac;
    
    // Print the flow rate for this second in litres / minute
    Serial.print("Flow rate: ");
    Serial.print(int(flowRate));  // Print the integer part of the variable
    Serial.print(".");             // Print the decimal point
    // Determine the fractional part. The 10 multiplier gives us 1 decimal place.
    frac = (flowRate - int(flowRate)) * 10;
    Serial.print(frac, DEC) ;      // Print the fractional part of the variable
    Serial.print("L/min");
    // Print the number of litres flowed in this second
    Serial.print("  Current Liquid Flowing: ");             // Output separator
    Serial.print(flowMilliLitres);
    Serial.print("mL/Sec");

    // Print the cumulative total of litres flowed since starting
    Serial.print("  Output Liquid Quantity: ");             // Output separator
    Serial.print(totalMilliLitres);
    Serial.println("mL"); 

    // Reset the pulse counter so we can start incrementing again
    pulseCount = 0;
    
    // Enable the interrupt again now that we've finished sending output
    attachInterrupt(sensorInterrupt, pulseCounter, FALLING);
  }
}

void pulseCounter()
{
  // Increment the pulse counter
  pulseCount++;
}

int pourDrink(String value){
  digitalWrite(indicatorLed, HIGH);
  digitalWrite(pump, LOW);
  Serial.println("Received Signal");
  timeStart = millis();
  pouring = true;
  return pourSize;
}

void changePourSize(const char* event, const char* data){
  pourSize = atoi(data);
}