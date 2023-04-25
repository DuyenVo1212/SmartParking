# 1_CÀI ĐẶT CÁC THƯ VIỆN CẦN THIẾT
from tkinter import *
from PIL import ImageTk, Image
import cv2
import pytesseract
import re
import time
import serial
import mysql.connector
from mysql.connector import Error
#kết nối database
db=mysql.connector.connect(
   host="localhost",
   user="admin",
   password="123",
   database="dant"
)
# khởi tạo con trỏ
cursor = db.cursor()
# 2_TẠO GIAO DIỆN
# Khởi tạo tkinter
root = Tk()
root.geometry('700x468')
root.title("Nhan Dang Bien So Xe")
root.configure(bg='black')  # Nền đen


# Chèn video
app = Frame(root)
app.place(x=20, y=10)
# Tạo label cho khung ảnh
lmain = Label(app)
lmain.grid(column=0, row=0)

# 3_ĐỌC CAMERA VÀ TIẾN HÀNH NHẬN DẠNG
cap = cv2.VideoCapture(0)
# cap = cv2.VideoCapture('http://192.168.1.3:4747/video')


def webcam():
    ret, frames = cap.read()

    # Thuat toan---------------------------------
    vid1 = cv2.resize(frames, (600, 350))  # Kich thuoc video
    # Chuyển ảnh màu sang ảnh xám
    gray = cv2.cvtColor(vid1, cv2.COLOR_BGR2GRAY)
    thresh = cv2.adaptiveThreshold(
        gray, 255, cv2.ADAPTIVE_THRESH_MEAN_C, cv2.THRESH_BINARY, 11, 2)
   # thresh = cv2.thích nghi(src, giá trị tối đa, phương pháp thích nghi, Loại thích nghi, kích thước khối, C, dst=None)

    # Tìm đường viền biển số
    contours, h = cv2.findContours(thresh, 1, 2)
    # đường viền, h = cv2.tìm đường viền(Ảnh, chế độ, phương pháp, contours=None, hiearchy=None)
    largest_rectangle = [0, 0]
    for cnt in contours:
        lenght = 0.01 * cv2.arcLength(cnt, True)
        # -Tạo đường viền theo dõi biển số
        approx = cv2.approxPolyDP(cnt, lenght, True)  # Đường xấp xỉ
        if len(approx) == 4:
            # -Khu vực đường viền
            area = cv2.contourArea(cnt)
            if area > largest_rectangle[0]:
                largest_rectangle = [cv2.contourArea(cnt), cnt, approx]

    # Hàm tính toán giới hạn hình chữ nhật
    x, y, w, h = cv2.boundingRect(largest_rectangle[1])
    image = vid1[y:y + h, x:x + w]

    # Tô đường viền
    cv2.drawContours(vid1, [largest_rectangle[1]], 0, (0, 255, 0), 10)

# 4_ĐỌC KÝ TỰ BẰNG PHẦN MỀM OCR (Tesseract)
    # Thay đổi không gian màu
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    # Lọc hình ảnh, làm mịn
    blur = cv2.GaussianBlur(gray, (3, 3), 0)
    # Ngưỡng hình ảnh
    thresh = cv2.threshold(
        blur, 0, 255, cv2.THRESH_BINARY_INV + cv2.THRESH_OTSU)[1]
    # Hiển thị ảnh chỉ chứa biển số
    # cv2.imshow('Bien So La', thresh)
    # Lọc cấu trúc hình chữ nhật 3x3 tách số
    kernel = cv2.getStructuringElement(cv2.MORPH_RECT, (3, 3))
    # Cắt tỉa biến đổi trạng thái lọc ký tự
    opening = cv2.morphologyEx(thresh, cv2.MORPH_OPEN, kernel, iterations=1)
    invert = 255 - opening
    bsx = pytesseract.image_to_string(invert, config='--psm 11')
    bsx = bsx.strip()
    print("kỹ tự nhận dạng được: ", bsx)
    #khơi tạo regex cho biển số xe
    new_arr = []
    for char in bsx:
        if (char.isalnum() == True):
            new_arr.append(char)

    bsxend = ''.join(new_arr)
    print(len(bsxend))

    pattern = r'([0-9]{2}[A-Z]{1})([0-9]{5})'
    pattern1 = r'^([0-9]{2}[A-Z]{1}([0-9]{6}))$'

    rs = re.match(pattern, bsxend)
    rs1 = re.match(pattern1, bsxend)
    if (rs and len(bsxend) == 8) or (rs1 and len(bsxend) == 9):
        sql = "SELECT bsx FROM bsxlist WHERE bsx = %s"
        adr = (bsxend, )
        cursor.execute(sql, adr)
        isbsx = cursor.fetchall()
        if(isbsx):
            print("biển số đã tồn tại!")
        else :
            print("biển số xe là: ", bsxend)
            querry = "INSERT INTO bsxlist (bsx) VALUES (%s)"
            val = (bsxend,)
            cursor.execute(querry,val)
            myresult = cursor.fetchall()
            db.commit()
            for x in myresult:
              print(x)
            print("biển số xe đã đưc thêm vào thành công! ")
#         ser = serial.Serial('/dev/ttyACM0', 9600) # kết nối với cổng Serial của Arduino
#         ser.write('add succcessfully'.encode('utf-8')) # gửi chuỗi "xin chào"
#         ser.close() # đóng kết nối
#         time.sleep(10)
#     else :
#         print("không tìm thấy")
#         time.sleep(2)
    #data = pytesseract.image_to_string(invert, lang='eng', config='--psm 6')
    # Hiển thị kết quả đọc được

    cut_vid1 = vid1[20: 500, 0: 700]
    # Chuyển màu video trong giao diện thành RGB
    vid1 = cv2.cvtColor(cut_vid1, cv2.COLOR_BGR2RGB)
    # --------------------------------------------
    # Khởi tạo khung ảnh và delay
    imgs = Image.fromarray(vid1)
    imgtk = ImageTk.PhotoImage(image=imgs)
    lmain.imgtk = imgtk
    lmain.configure(image=imgtk)
    lmain.after(20, webcam)


webcam()
root.mainloop()
