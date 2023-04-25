#include <Servo.h>

Servo myservo;  // create a servo object

void setup() {
  myservo.attach(9);  // attaches the servo on pin 9 to the servo object
}

void loop() {
  myservo.write(0);         // sets the servo to the minimum position (0 degrees)
  delay(1000);              // waits for 1 second
  myservo.write(90);        // sets the servo to the midpoint position (90 degrees)
  delay(1000);              // waits for 1 second
  myservo.write(180);       // sets the servo to the maximum position (180 degrees)
  delay(1000);              // waits for 1 second
}