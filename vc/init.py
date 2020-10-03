from PIL import Image, ImageDraw, ImageFont
import sys
#sys.path.append('/usr/local/lib/python2.7/site-packages')
image = Image.open('C:/wamp64/www/projectx/vc/images/background.png')
draw = ImageDraw.Draw(image)
font = ImageFont.truetype('C:/wamp64/www/projectx/vc/Times New Roman Gras 700.ttf', size = 100)
(x, y) = (150, 100)
#(x, y) = (50, 50)
color = 'rgb(0, 0, 0)'
#print("[+]Enter username:")
#message = input()
draw.text((x, y), sys.argv[1], fill = color, font = font)
image.save('C:/wamp64/www/projectx/vc/images/image.png')
