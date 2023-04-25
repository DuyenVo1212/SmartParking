import serial

# Open the serial port
ser = serial.Serial('/dev/ttyACM0', 9600)

while True:
    # Read the data from the serial port
    if ser.in_waiting > 0 :
        data = ser.readline().decode().split()
        
        if len(data) == 3 :
            S1,S2,S3 = data
        else :
            print('ko nhận được')
        
        # Do something with the data
            print("S1:", S1)
            print("S2:", S2)
            print("S3:", S3)
