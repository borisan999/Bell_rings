#!/usr/bin/python
# -*- coding: utf-8 -*-
import RPi.GPIO as GPIO      
import os, time
import sys
import datetime
import MySQLdb
import subprocess
import psutil
from subprocess import Popen

# Activa rele y da play a archivo de audio si las filas de agenda en la base de datos 
# cumplen las condiciones de hora, dia, fecha
# fecha edicion 171010
# Version 3
# Creado por Boris Urrea

global playProcess

PROCNAME = "omxplayer"
PROCNAMEBIN = "omxplayer.bin"

PIN_GPIO = 22
Duration = 10
Delay_ring = 10
time.sleep(30)
db=MySQLdb.connect(host="localhost",user="bellrings", passwd="900007657", db="ring_bells")
cur = db.cursor()
rows_count = cur.execute ("""SELECT * FROM Configuracion""")
row = cur.fetchone()
while row is not None: 
    PIN_GPIO = int(row[1])
    Duration = int(row[2])
    Delay_ring = int(row[3])
    break
db.commit()
db.close()

while True:
    time.sleep(1)
    now = datetime.datetime.now()
    midnight = now.replace(hour=0, minute=0,second=0)
    secondsnow = (now - midnight).seconds
    db=MySQLdb.connect(host="localhost",user="bellrings", passwd="900007657", db="ring_bells")
    cur = db.cursor() 
    rows_count = cur.execute ("""SELECT ID, Hora, Repeticiones, Repetido, Melodia FROM agenda WHERE DATE_FORMAT(Fecha,'%d%m') = DATE_FORMAT(cast(now() as date),'%d%m') AND Deshabilitada = 0""")
    # print ("""SELECT ID, Hora, Repeticiones, Repetido FROM agenda WHERE Fecha = cast(now() as date) AND Deshabilitada = 0""")
    if rows_count >0:
        row = cur.fetchone()
        while row is not None: 
            mysqlsec = row[1].seconds
            if mysqlsec< (secondsnow+1+Delay_ring):
                if mysqlsec> (secondsnow-1+Delay_ring):
                    if row[2]>0:
                        if row[2]>row[3]:
                            idquery = row[0]
                            cur.execute ("""UPDATE agenda SET Repetido = Repetido +1 WHERE ID = %s""",idquery)
                            GPIO.setmode(GPIO.BCM)
                            GPIO.setup(PIN_GPIO, GPIO.OUT)
                            GPIO.output(PIN_GPIO, 1)  # turn on pin 17
                            ruta=row[4]
                            playProcess=subprocess.Popen(['omxplayer','-o','local',ruta],stdin=subprocess.PIPE,stdout=subprocess.PIPE,stderr=subprocess.PIPE, close_fds=True, bufsize=1, universal_newlines=True)
                            time.sleep(Duration)
                            for process in psutil.process_iter():
                                if process.name() == 'omxplayer.bin':
                                    process.terminate()
                                if process.name() == 'omxplayer':
                                    process.terminate()
                            GPIO.output(PIN_GPIO, 0)  # turn on pin 18
                            GPIO.cleanup()
                    else:
                        GPIO.setmode(GPIO.BCM)
                        GPIO.setup(PIN_GPIO, GPIO.OUT)
                        GPIO.output(PIN_GPIO, 1)  # turn on pin 17
                        ruta=row[4]
                        playProcess=subprocess.Popen(['omxplayer','-o','local',ruta],stdin=subprocess.PIPE,stdout=subprocess.PIPE,stderr=subprocess.PIPE, close_fds=True, bufsize=1, universal_newlines=True)
                        time.sleep(Duration)
                        for process in psutil.process_iter():
                            if process.name() == 'omxplayer.bin':
                                process.terminate()
                            if process.name() == 'omxplayer':
                                process.terminate()
                        GPIO.output(PIN_GPIO, 0)  # turn on pin 18
                        GPIO.cleanup()
                    cur.execute ("""INSERT INTO log (Descripcion, ID_alarma) VALUES ('por fecha actual','%s')""",row[0])
                    print ("por fecha actual")
            row = cur.fetchone()
    rows_count = cur.execute ("""SELECT ID, Hora, Repeticiones, Repetido, Melodia FROM agenda WHERE DATE_FORMAT(Fecha,'%d') = DATE_FORMAT(cast(now() as date),'%d') AND Deshabilitada = 0 AND Mes = 1""")
    # print ("""SELECT ID, Hora, Repeticiones, Repetido FROM agenda WHERE DATE_FORMAT(Fecha,'%d') = DATE_FORMAT(cast(now() as date),'%d') AND Deshabilitada = 0 AND Mes = 1""")
    if rows_count >0:
        row = cur.fetchone()
        while row is not None: 
            mysqlsec = row[1].seconds
            if mysqlsec< (secondsnow+1+Delay_ring):
                if mysqlsec> (secondsnow-1+Delay_ring):
                    if row[2]>0:
                        if row[2]>row[3]:
                            idquery = row[0]
                            cur.execute ("""UPDATE agenda SET Repetido = Repetido +1 WHERE ID = %s""",idquery)
                            GPIO.setmode(GPIO.BCM)
                            GPIO.setup(PIN_GPIO, GPIO.OUT)
                            ruta=row[4]
                            playProcess=subprocess.Popen(['omxplayer','-o','local',ruta],stdin=subprocess.PIPE,stdout=subprocess.PIPE,stderr=subprocess.PIPE, close_fds=True, bufsize=1, universal_newlines=True)
                            time.sleep(Duration)
                            for process in psutil.process_iter():
                                if process.name() == 'omxplayer.bin':
                                    process.terminate()
                                if process.name() == 'omxplayer':
                                    process.terminate()
                            GPIO.output(PIN_GPIO, 0)  # turn on pin 18
                            GPIO.cleanup()
                    else:
                        GPIO.setmode(GPIO.BCM)
                        GPIO.setup(PIN_GPIO, GPIO.OUT)
                        GPIO.output(PIN_GPIO, 1)  # turn on pin 17
                        ruta=row[4]
                        playProcess=subprocess.Popen(['omxplayer','-o','local',ruta],stdin=subprocess.PIPE,stdout=subprocess.PIPE,stderr=subprocess.PIPE, close_fds=True, bufsize=1, universal_newlines=True)
                        time.sleep(Duration)
                        for process in psutil.process_iter():
                            if process.name() == 'omxplayer.bin':
                                process.terminate()
                            if process.name() == 'omxplayer':
                                process.terminate()
                        GPIO.output(PIN_GPIO, 0)  # turn on pin 18
                        GPIO.cleanup()
                    cur.execute ("""INSERT INTO log (Descripcion, ID_alarma) VALUES ('por mes','%s')""",row[0])
                    print ("por mes")
            row = cur.fetchone()
        
    rows_count = cur.execute ("""SELECT ID, Hora, Repeticiones, Repetido, Melodia from agenda where dia = DAYOFWEEK(now()) AND Deshabilitada = 0""")
    # print ("""SELECT ID, Hora, Repeticiones, Repetido from agenda where dia = DAYOFWEEK(now()) AND Deshabilitada = 0""")
    if rows_count >0:
        row = cur.fetchone()
        while row is not None:
            mysqlsec = row[1].seconds
            if mysqlsec< (secondsnow+1+Delay_ring):
                if mysqlsec> (secondsnow-1+Delay_ring):
                    if row[2]>0:
                        if row[2]>row[3]:
                            idquery = row[0]
                            cur.execute ("""UPDATE agenda SET Repetido = Repetido +1 WHERE ID = %s""",idquery)
                            GPIO.setmode(GPIO.BCM)
                            GPIO.setup(PIN_GPIO, GPIO.OUT)
                            GPIO.output(PIN_GPIO, 1)  # turn on pin 17
                            ruta=row[4]
                            playProcess=subprocess.Popen(['omxplayer','-o','local',ruta],stdin=subprocess.PIPE,stdout=subprocess.PIPE,stderr=subprocess.PIPE, close_fds=True, bufsize=1, universal_newlines=True)
                            time.sleep(Duration)
                            for process in psutil.process_iter():
                                if process.name() == 'omxplayer.bin':
                                    process.terminate()
                                if process.name() == 'omxplayer':
                                    process.terminate()
                            GPIO.output(PIN_GPIO, 0)  # turn on pin 18
                            GPIO.cleanup()
                    else:
                        GPIO.setmode(GPIO.BCM)
                        GPIO.setup(PIN_GPIO, GPIO.OUT)
                        GPIO.output(PIN_GPIO, 1)  # turn on pin 17
                        ruta=row[4]
                        playProcess=subprocess.Popen(['omxplayer','-o','local',ruta],stdin=subprocess.PIPE,stdout=subprocess.PIPE,stderr=subprocess.PIPE, close_fds=True, bufsize=1, universal_newlines=True)
                        time.sleep(Duration)
                        for process in psutil.process_iter():
                            if process.name() == 'omxplayer.bin':
                                process.terminate()
                            if process.name() == 'omxplayer':
                                process.terminate()
                        GPIO.output(PIN_GPIO, 0)  # turn on pin 18
                        GPIO.cleanup()
                    cur.execute ("""INSERT INTO log (Descripcion, ID_alarma) VALUES ('por dia de la semana','%s')""",row[0])
                    print ("por dia de la semana")
            row = cur.fetchone()
    db.commit()
    db.close()
    
    
