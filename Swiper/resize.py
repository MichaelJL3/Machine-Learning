
import numpy as np

from scipy import ndimage
from scipy import misc 
from glob import glob

def getImageFiles():
	files=glob('Women/*.jpg')
	size=len(files)

	for i in range(size):
		newface=misc.imread(files[i])
		print(newface.shape, files[i])

def processImageFiles():
	files=glob('Women/*.jpg')
	size=len(files)

	for i in range(size):
		newface=misc.imread(files[i])
		newface=misc.imresize(newface, (1244, 853, 3))
		misc.imsave(files[i], newface)

def main():
	processImageFiles()
	#getImageFiles()

main()
