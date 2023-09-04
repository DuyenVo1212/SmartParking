# 1_CÀI ĐẶT CÁC THƯ VIỆN CẦN THIẾT
from tkinter import *
from PIL import ImageTk, Image
import cv2
import pytesseract
import re
import time
from datetime import datetime
import math
import serial
import mysql.connector
from mysql.connector import Error
# from sqlalchemy import create_engine, event
# from sqlalchemy.orm import sessionmaker
# from sqlalchemy.ext.declarative import declarative_base
# import importlib
# import mymodule


# kết nối database
db = mysql.connector.connect(
    host="localhost",
    user="admin",
    password="123",
    database="cpms"
)

# Base = declarative_base()

# # Tạo engine kết nối tới cơ sở dữ liệu
# engine = create_engine('mysql+pymysql://admin:123@localhost/cpms', echo=False)

# # Tạo một session kết nối đến cơ sở dữ liệu
# Session = sessionmaker(bind=engine)
# session = Session()

# khởi tạo con trỏ
cursor = db.cursor()
# kết nối với cổng Serial của Arduino
ser = serial.Serial('/dev/ttyACM0', 9600, timeout=1)
ser.reset_input_buffer()

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


def webcam():
    ret, frames = cap.read()

    # Thuat toan---------------------------------
    vid1 = cv2.resize(frames, (700, 468))  # Kich thuoc video
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
    text = pytesseract.image_to_string(invert, config='--psm 11')
    text = text.strip()
    new_arr = []
    for char in text:
        if (char.isalnum() == True):
            new_arr.append(char)

    text = ''.join(new_arr)
    print(len(text))
    print("kỹ tự nhận dạng được: ", text)
    pattern = r'([0-9]{2}[A-Z]{1})([0-9]{5})'
    pattern1 = r'^([0-9]{2}[A-Z]{1}([0-9]{6}))$'
    rsregex = re.match(pattern, text)
    rsregex1 = re.match(pattern1, text)
    if (rsregex and len(text) == 8) or (rsregex1 and len(text) == 9):
        bsx = text
        print("biển số xe: ", bsx)
        now = datetime.now()
        timeout = now
        timein = None
        sel = "SELECT timein,pays FROM zones WHERE plateno = %s and status = 'INUSE' AND timein <= NOW()"
        val = (bsx,)
        cursor.execute(sel, val)
        rs = cursor.fetchall()
        for x in rs:
            timein = x[0]
            pays = x[1]
#         now = datetime.datetime.now()# thời gian hiện tại
        if timein is not None:  # check if timein is not None
            # thời gian sử dụng tính bằng giây
            timeused = (timeout - timein).total_seconds()
            price = timeused * 100  # số tiền cần thanh toán
            # định dạng kết quả theo chuỗi '1000 VND'
            charge = '{:,.0f} VND'.format(price)

        # timein = timein.strftime("%Y-%m-%d %H:%M:%S")
        # lấy thời điểm xe ra
        # timeout = now.strftime("%Y-%m-%d %H:%M:%S")
        if rs:
            if (pays == 'paid'):
                sql = "DELETE FROM zones WHERE plateno = %s"
                val = (bsx,)
                cursor.execute(sql, val)
                db.commit()
                sql = "UPDATE `reserved-list` SET charge = %s, stats = %s, timeout = %s WHERE plate = %s and stats = %s"
                val = (charge, 0, timeout, bsx, 1)
                cursor.execute(sql, val)
                rs = cursor.fetchall()
                db.commit()
                print("xóa thành công "+bsx+" khỏi bảng zones")
                print("update thành công bảng reserved-list")
                ser.write(b"open\n")
                print('đã gửi thành công')
            else:
                # Lắng nghe sự kiện thay đổi trên bảng zones
                # @event.listens_for(Zones, 'after_update')
                sel = "SELECT id FROM zones WHERE plateno = %s and status = 'INUSE' and pays = 'paid'"
                val = (bsx,)
                cursor.execute(sel, val)
                rs = cursor.fetchall()
                if rs:
                    print("vui lòng ra khỏi bãi đỗ xe!")
                else:
                    print(bsx + " chưa thanh toán thanh toán")
                # db.reconnect()
                # cap.release()
                # cap2 = cv2.VideoCapture(0)
        else:
            print("Không tìm thấy biển số " + bsx)

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
#     importlib.reload(mymodule)


webcam()
# @event.listens_for(zones, 'after_insert')
# @event.listens_for(zones, 'after_update')
# @event.listens_for(zones, 'after_delete')
# def receive_change(mapper, connection, target):
#     webcam()
root.mainloop()
