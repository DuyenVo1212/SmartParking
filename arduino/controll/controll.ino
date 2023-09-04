#include <LiquidCrystal.h>
LiquidCrystal lcd(12, 11, 5, 4, 3, 2);
#include <Servo.h>
Servo myservo1;
int pos = 0;

int IR1 = 6;
int IR2 = 7;
int IR3 = 8;

int S1 = 0, S2 = 0, S3 = 0;

int Slot = 3;
int total = 0;

int flag1 = 0;
int flag2 = 0;

void setup()
{
  // Initialize LCD screen and serial communication
  lcd.begin(16, 2);
  Serial.begin(9600);
//  lcd.backlight();
  
  // Set up pins for IR sensors and servo motor
  pinMode(IR1, INPUT);
  pinMode(IR2, INPUT);
  pinMode(IR3, INPUT);
  
  myservo1.attach(9);
  myservo1.write(100);
  
  // Display startup message on LCD screen
//  lcd.setCursor(0, 0);
//  lcd.print(" Parking slot ");
//  lcd.setCursor(0, 1);
//  lcd.print(Slot);
//  delay(5000);
//  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print(" WELCOME ");
  lcd.setCursor(0, 1);
  lcd.print(" PARKING SYSTEM ");
  delay(5000);
  lcd.clear();
}

void open()
{
  lcd.noDisplay();
  // Open the servo motor to allow a car to enter the parking spot
  for (pos = 0; pos < 90; pos += 1)
  {
    myservo1.write(pos);
    delay(15);
  }
  lcd.display();
}

void close()
{
  lcd.noDisplay();
  // Close the servo motor after a car has entered the parking spot
  for (pos = 90; pos >= 1; pos -= 1)
  {
    myservo1.write(pos);
    delay(15);
  }
  lcd.display();
}

void loop()
{
  Read_Sensor();
   // Display number of available parking spots on LCD screen
  lcd.setCursor(0, 0);
  lcd.print(" EMPTY SLOT ");
  lcd.print(Slot);
  lcd.print("/3");

  lcd.setCursor (0, 1);
  if (S1 == 1) {
    lcd.print("S1:F");
  }
  else {
    lcd.print("S1:E");
  }
  lcd.setCursor (6, 1);
  if (S2 == 1) {
    lcd.print("S2:F");
  }
  else {
    lcd.print("S2:E");
  }
  lcd.setCursor (11, 1);
  if (S3 == 1) {
    lcd.print("S3:F");
  }
  else {
    lcd.print("S3:E");
  }
  delay(5000);
  lcd.clear();
  
  // Check for input from serial monitor
  if (Serial.available() > 0)
  {
    // Read input from serial monitor
    String data = "";
    data = Serial.readStringUntil('\n');
    Serial.println(data);
    
    // If input is "open", open and close servo motor
    if (data == "open")
    {
      open();
      delay(3000);
      close();
      
      // Update number of available parking spots
    }
  }
  if (Slot == 0)
      {
        // If no more parking spots are available, display message on LCD screen
        lcd.setCursor(0, 0);
        lcd.print(" SORRY :( ");
        lcd.setCursor(0, 1);
        lcd.print(" Parking Full ");
        delay(3000);
        lcd.clear();
      }
}

void Read_Sensor() {
  Slot = 3;
  S1 = 0, S2 = 0, S3 = 0;

  if (digitalRead(IR1) == 0) {
    S1 = 1;
  }
  if (digitalRead(IR2) == 0) {
    S2 = 1;
  }
  if (digitalRead(IR3) == 0) {
    S3 = 1;
  }
  total = S1+S2+S3;
  Slot = Slot - total;
  String s1 = String(S1);
  String s2 = String(S2);
  String s3 = String(S3);
  String send = s1+s2+s3;
  
  Serial.println(send);
  //Serial.print(",");
  //Serial.print(S2);
  //Serial.print(",");
  //Serial.println(S3);
 
}



