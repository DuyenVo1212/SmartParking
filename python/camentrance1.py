# 1_CÀI ĐẶT CÁC THƯ VIỆN CẦN THIẾT
from tkinter import *
from PIL import ImageTk, Image
import cv2
import pytesseract
import re
import time
import datetime
import serial
import mysql.connector
from mysql.connector import Error
#kết nối database
db=mysql.connector.connect(
   host="localhost",
   user="admin",
   password="123",
   database="cpms"
)
# khởi tạo con trỏ
cursor = db.cursor()
# 2_TẠO GIAO DIỆN
# Khởi tạo tkinter
root = Tk()
root.geometry('730x490')
root.title("Nhan Dang Bien So Xe")
root.configure(bg='black')  # Nền đen


ser = serial.Serial('/dev/ttyACM0', 9600,timeout = 1) # kết nối với cổng Serial của Arduino
ser.reset_input_buffer()

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
    vid1 = cv2.resize(frames, (720, 480))  # Kich thuoc video
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
    #tạo regex kiểm tra kĩ tự lấy được từ ảnh
    pattern = r'([0-9]{2}[A-Z]{1})([0-9]{5})'
    pattern1 = r'^([0-9]{2}[A-Z]{1}([0-9]{6}))$'
    rs = re.match(pattern, bsxend)
    rs1 = re.match(pattern1, bsxend)
    if (rs and len(bsxend) == 8) or (rs1 and len(bsxend) == 9):
        print("kỹ tự nhận dạng được: ", bsxend)
        now = datetime.datetime.now()
        #lấy thời điểm xe vào
        timein = now.strftime("%Y-%m-%d %H:%M:%S")
        #kiểm tra biển số đã đặt trước chưa
        sql = "SELECT * FROM zones WHERE plateno = %s and status = 'RESERVED' and timebegin <= %s"
        adr = (bsxend,timein )
        cursor.execute(sql, adr)
        isbsx = cursor.fetchall()
        for x in isbsx:
            #lấy biển số
            plateno = x[2]
        row = cursor.rowcount
        print("số hàng dữ liệu lấy được là ",row)
        if(row > 0):
            print("biển số xe là: ", plateno)
            #update lại trạng thái và thêm thời gian vào
            sql = "UPDATE zones SET status = 'INUSE',timein = %s  where plateno = %s"
            val = (timein,plateno,)
            cursor.execute(sql,val)
            db.commit()
            if cursor.rowcount > 0:
                print('update thành công! '+ plateno)
                print('mời xe vào!')
                #gửi yêu cầu mở cổng
                ser.write(b"open\n")
                print('đã gửi thành công')
        else :
            #lấy thời gian vào
            now = datetime.datetime.now()
            timein = now.strftime("%Y-%m-%d %H:%M:%S")
            #tạo thời gian ra ảo
            future = now + datetime.timedelta(hours=5)
            timeout = future.strftime("%Y-%m-%d %H:%M:%S")
            #lấy số slot còn trống ở hiện tại
            query =  "SELECT slot FROM zones WHERE (status='RESERVED' or status = 'INUSE') AND (timebegin <= NOW() or timein <= NOW())"
            cursor.execute(query)
            getslot = cursor.fetchall()
            rows = cursor.rowcount
            emptyslotcount = 3-rows
            print("so slot còn trống là: ", emptyslotcount)
            if emptyslotcount > 0 :
                dtbslots = [r[0] for r in getslot]
                slots = ['A1','A2','A3']
                # Lấy các phần tử không trùng nhau giữa hai mảng
                emptyslot = list(set(slots).difference(set(dtbslots)))
                print('slot danh cho ban la: ',emptyslot[0])
                #kiểm tra biển số đã được đã tồn tại và có trạng thái là inuse chưa
                sql = "SELECT * FROM zones WHERE plateno = %s and status = 'INUSE' and (timebegin <= NOW() or timein <= NOW())"
                adr = (bsxend,)
                cursor.execute(sql, adr)
                inusebsx = cursor.fetchall()
                if(inusebsx):
                    print('biển số xe '+bsxend+' đã có nên không thêm nữa!')
                else :   
                    querry = "INSERT INTO zones (slot,status,plateno,paynum, charge, phone, timein) VALUES (%s,%s,%s,%s,%s,%s,%s)"
                    val = (emptyslot[0],"INUSE",bsxend,'','','',timein,)
                    cursor.execute(querry,val)
                    myresult = cursor.fetchall()
                    inserted = db.commit()
                    rs1 = cursor.rowcount > 0 
                    restime = timein[:10]
                    sql = "INSERT INTO `reserved-list` ( restime, slot, plate, phone,charge) VALUES (%s,%s,%s,%s,%s)"
                    val = (restime,emptyslot[0],bsxend,'','',)
                    cursor.execute(sql,val)
                    myresult = cursor.fetchall()
                    db.commit()
                    rs2 = cursor.rowcount > 0 
                    if rs1 and rs2:
                        print("biển số xe "+bsxend+" đã được thêm vào thành công! ")
                        ser.write(b"open\n")
                        print('đã gửi thành công')
                    else :
                        print("lỗi thêm vào database!")
            else :
                print('Hết chỗ trống!')

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
