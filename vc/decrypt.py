from cv2 import cv2
import sys
from PIL import Image
import PIL.ImageOps
import pytesseract
import numpy as np

pytesseract.pytesseract.tesseract_cmd = 'C:/Program Files/Tesseract-OCR/tesseract.exe'

#img1 = cv2.imread('C:/wamp64/www/projectx/vc/share_1.png', 1)
img1 = cv2.imread(sys.argv[1], 1)  
img2 = cv2.imread(sys.argv[2], 1)

#img2 = cv2.imread('C:/wamp64/www/projectx/vc/share_2.png', 1)
img = cv2.add(img1, img2)

#convert to grayscale
img = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
#cv2.imwrite('results/grayscale.png', img)

#apply dilation and erosion
kernel = np.ones((1, 1), np.uint8)
img = cv2.dilate(img, kernel, iterations=1)
img = cv2.erode(img, kernel, iterations=1)
#cv2.imwrite('results/dilandero.png', img)

#apply blur
img = cv2.threshold(cv2.GaussianBlur(img, (5, 5), 0), 0, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)[1]
#cv2.imwrite('results/gussblur.png', img)

#invert image
img=~img
#cv2.imwrite('results/inv.png', img)

final=pytesseract.image_to_string(img)

print (final)
