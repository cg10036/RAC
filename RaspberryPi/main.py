from urllib.request import urlopen
from time import sleep
import shutil
import os
import hashlib
import RPi.GPIO as GPIO
import Adafruit_DHT
serial = "aaaa"
ips = "*"
#DoNotChange
#https://passwordsgenerator.net/kr/?length=256&symbols=0&numbers=1&lowercase=1&uppercase=1&similar=0&ambiguous=0&client=1&autoselect=0
Serial = "WA8fcne3dDAgk3FZt9uI42UIKYGOTRZDWO9JI4caspCddqVSgmPoM4ZuUcGERkB59RgL0JQtzbYbkjkT64rZO3JiIwSnWmBM1UeLiXwMb8AILjfdSwgauick8QepVVqzQUV94lr1ZSRR3vcRkGZACeYopsyVoxsm1wbTYg67xjyikvnQBbqOsR2DLBJlkilDNsFZSwtmd3f8jYqDm2tnkL5cGrUJQOVR9rhQmcBD61ZhgexTJUkX3Z3vwM3AsJ0R" #length=256
#DoNotChange
shutil.copyfile("/etc/wpa_supplicant/wpa_supplicant.conf", "/boot/wpa_supplicant.conf")
if os.path.isfile("/boot/ip_whitelist.txt"):
    f = open("/boot/ip_whitelist.txt", "r")
    ips = f.readline().replace("\n", "")
if os.path.isfile("/boot/serial.txt"):
    f = open("/boot/serial.txt", "r")
    serial = f.readline().replace("\n", "")
BOOL = True
while True:
    try:
        randomkey = urlopen("http://sunrin.duckdns.org/randomkey.php").read().decode('utf-8')
    except:
        sleep(5)
        continue
    break
h = ""
for i in range(256):
    h = h + randomkey[i] + Serial[i]
h = hashlib.md5(h.encode('utf-8')).hexdigest()
while True:
    try:
        data = urlopen("http://sunrin.duckdns.org/api.php?mode=check&serial=" + serial + "&Serial=" + h).read().decode('utf-8')
    except:
        sleep(5)
        continue
    if data == "KO" and BOOL:
        sleep(10)
        BOOL = False
        continue
    elif data == "KO":
        while True:
            sleep(1000)
    break
BOOL = True
if data == "register":
    while True:
        try:
            data = urlopen("http://sunrin.duckdns.org/api.php?mode=check&serial=" + serial + "&Serial=" + Serial).read().decode('utf-8')
        except:
            sleep(5)
            continue
        if data == "KO" and BOOL:
            sleep(10)
            BOOL = False
            continue
        elif data == "KO":
            while True:
                sleep(1000)
        break
while True:
    try:
        randomkey = urlopen("http://sunrin.duckdns.org/randomkey.php").read().decode('utf-8')
    except:
        sleep(5)
        continue
    break
h = ""
for i in range(256):
    h = h + randomkey[i] + Serial[i]
h = hashlib.md5(h.encode('utf-8')).hexdigest()
while True:
    try:
        data = urlopen("http://sunrin.duckdns.org/api.php?mode=ip&serial=" + serial + "&ips=" + ips + "&hash=" + h).read().decode('utf-8')
    except:
        sleep(5)
        continue
    if data == "KO":
        sleep(10)
        continue
    break
DHT_SENSOR = Adafruit_DHT.DHT22
DHT_1 = 4
DHT_2 = 5
GPIO.setmode(GPIO.BCM)
GPIO.setup(26, GPIO.OUT)
GPIO.setup(20, GPIO.OUT)
GPIO.setup(16, GPIO.OUT)
GPIO.setup(13, GPIO.OUT)
GPIO.output(26, False)
GPIO.output(20, False)
GPIO.output(16, False)
GPIO.output(13, False)
while(True):
    while True:
        try:
            randomkey = urlopen("http://sunrin.duckdns.org/randomkey.php").read().decode('utf-8')
        except:
            sleep(5)
            continue
        break
    h = ""
    for i in range(256):
        h = h + randomkey[i] + Serial[i]
    h = hashlib.md5(h.encode('utf-8')).hexdigest()
    while True:
        try:
            data = urlopen("http://sunrin.duckdns.org/api.php?mode=get&serial=" + serial + "&hash=" + h).read().decode('utf-8').split(',')
        except:
            sleep(5)
            continue
        break
    if len(data) != 4:
        sleep(5)
        continue
    set_t_1 = float(data[0])
    set_t_2 = float(data[1])
    set_h_1 = float(data[2])
    set_h_2 = float(data[3])
    #print("now_t_1 : ", end="")
    #now_t_1 = float(input())
    #print("now_t_2 : ", end="")
    #now_t_2 = float(input())
    #print("now_h_1 : ", end="")
    #now_h_1 = float(input())
    #print("now_h_2 : ", end="")
    #now_h_2 = float(input())
    now_h_1, now_t_1 = Adafruit_DHT.read_retry(DHT_SENSOR, DHT_1)
    now_h_2, now_t_2 = Adafruit_DHT.read_retry(DHT_SENSOR, DHT_2)
    now_h_1 = round(now_h_1, 1)
    now_h_2 = round(now_h_2, 1)
    now_t_1 = round(now_t_1, 1)
    now_t_2 = round(now_t_2, 1)
    #print("debug : set_t_1 = " + str(set_t_1) + ", set_t_2 = " + str(set_t_2) + ", set_h_1 = " + str(set_h_1) + ", set_h_2 = " + str(set_h_2))
    if set_t_1 < now_t_1:
        #print("t_1 off")
        GPIO.output(26, True)
    else:
        #print("t_1 on")
        GPIO.output(26, False)
    if set_t_2 < now_t_2:
        #print("t_2 off")
        GPIO.output(13, True)
    else:
        #print("t_2 on")
        GPIO.output(13, False)
    if set_h_1 < now_h_1:
        #print("h_1 off")
        GPIO.output(20, True)
    else:
        #print("h_1 on")
        GPIO.output(20, False)
    if set_h_2 < now_h_2:
        #print("h_2 off")
        GPIO.output(16, True)
    else:
        #print("h_2 on")
        GPIO.output(16, False)
    while True:
        try:
            randomkey = urlopen("http://sunrin.duckdns.org/randomkey.php").read().decode('utf-8')
        except:
            sleep(5)
            continue
        break
    h = ""
    for i in range(256):
        h = h + randomkey[i] + Serial[i]
    h = hashlib.md5(h.encode('utf-8')).hexdigest()
    while True:
        try:
            urlopen("http://sunrin.duckdns.org/api.php?mode=set&serial=" + serial + "&now_t_1=" + str(now_t_1) + "&now_t_2=" + str(now_t_2) + "&now_h_1=" + str(now_h_1) + "&now_h_2=" + str(now_h_2) + "&hash=" + h).read()
            #print("http://sunrin.duckdns.org/api.php?mode=set&serial=" + serial + "&now_t_1=" + str(now_t_1) + "&now_t_2=" + str(now_t_2) + "&now_h_1=" + str(now_h_1) + "&now_h_2=" + str(now_h_2) + "&hash=" + h)
        except:
            sleep(5)
            continue
        break
    sleep(5)
