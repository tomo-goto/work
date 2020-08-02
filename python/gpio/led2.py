import RPi.GPIO as GPIO
from time import sleep

led = 3

GPIO.setmode(GPIO.BOARD)
GPIO.setup(led, GPIO.OUT)

while True:
  GPIO.output(led, GPIO.HIGH)
  sleep(1)
  GPIO.output(led, GPIO.LOW)
  sleep(1)

GPIO.cleanup()
