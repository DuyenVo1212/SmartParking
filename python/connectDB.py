import mysql.connector
from mysql.connector import Error

db=mysql.connector.connect(
   host="localhost",
   user="admin",
   password="123",
   database="dant"
)

cursor = db.cursor()
cursor.execute("INSERT INTO bsxlist (bsx,trangthai) VALUES ('60B6-203.77','dadattruoc')")
cursor.execute("SELECT * FROM bsxlist")

myresult = cursor.fetchall()
db.commit()
print(cursor.rowcount, "record inserted.")
for x in myresult:
  print(x[2])