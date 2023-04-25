#!/usr/bin/env python3
import serial
import time

ser = serial.Serial('/dev/ttyACM0', 9600, timeout=1)
ser.reset_input_buffer()
while True:
    ser.write(b"open\n")
    time.sleep(15)