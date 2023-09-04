import datetime
import random
import mysql.connector
# Connect to the database
db = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="cpms"
)

# Create a cursor object to interact with the database
cursor = db.cursor()

# Define the SQL query to get the last id value in the table
sql = "SELECT id FROM `reserved-list` ORDER BY id DESC LIMIT 1"

# Execute the query and get the last id value
cursor.execute(sql)
last_id = cursor.fetchone()[0]

# Generate 20 rows of data
rows = []
for i in range(300, 321):
    # Increment the last id value to get a new unique id
    last_id += 1
    
    # Generate a random date within the next six months
    date = datetime.datetime.now() + datetime.timedelta(days=random.randint(0, 180), hours=random.randint(0, 23), minutes=random.randint(0, 59))
    
    # Generate a random slot (A1, A2, or A3)
    slot = f'A{random.randint(1, 3)}'
    
    # Generate a random license plate number
    plate = f'{chr(random.randint(65, 90))}{chr(random.randint(65, 90))}{chr(random.randint(65, 90))}{random.randint(100, 999)}'
    
    # Generate a random phone number
    phone = f'{random.randint(100, 999)}-{random.randint(1000, 9999)}'
    
    # Generate a random charge amount (between 10 and 50)
    charge = round(random.uniform(10, 50), 2)
    
    # Add the row to the list of rows
    rows.append((last_id, date, slot, plate, phone, charge))

# Define the SQL query to insert rows into the reserved-list table
sql = "INSERT INTO `reserved-list` (id, restime, slot, plate, phone, charge) VALUES (%s, %s, %s, %s, %s, %s)"

# Execute the query to insert the rows
cursor.executemany(sql, rows)

# Commit the changes to the database
db.commit()
