import cv2
import sys
import math
import numpy as np
from random import randint
from time import time

TEST_SIZE=51
faceCascade=cv2.CascadeClassifier("C:/Users/micha/Downloads/opencv/build/share/OpenCV/haarcascades/haarcascade_frontalface_default.xml")

def main():
	args=sys.argv
	size=len(args)

	if(size<3):
		print('ERR: location of dataset required')
		return

	t0 = time()
	print("Grabbing images")
	pos=grabImages(grabData(args[1]))
	neg=grabImages(grabData(args[2]))
	print('Finished: %0.3fs' % (time()-t0))

	posSize=len(pos)
	negSize=len(neg)

	negTestSize=math.ceil((negSize*.33))
	posTestSize=(TEST_SIZE-(negTestSize))

	posSplit=int(posSize-posTestSize)
	negSplit=int(negSize-negTestSize)

	testingSetImages=neg[negSplit:]
	testingSetImages.extend(pos[posSplit:])

	testingSetChoices=generateNum(0, int(negTestSize))
	testingSetChoices.extend(generateNum(1, int(posTestSize)))

	trainingSetImages=neg[:negSplit]
	trainingSetImages.extend(pos[:posSplit])

	trainingSetChoices=generateNum(0, negSplit)
	trainingSetChoices.extend(generateNum(1, posSplit))

	trainingSize=len(trainingSetImages)
	testingSize=len(testingSetImages)

	#shuffle the data 
	for i in range(trainingSize):
		rand=randint(0, trainingSize-1)
		
		temp=trainingSetImages[i]
		trainingSetImages[i]=trainingSetImages[rand]
		trainingSetImages[rand]=temp

		temp=trainingSetChoices[i]
		trainingSetChoices[i]=trainingSetChoices[rand]
		trainingSetChoices[rand]=temp

	print(trainingSetChoices)

	print('Num of right (good) swipes: %d' % posSize)
	print('Num of left (bad) swipes: %d' % negSize)
	print('Size of (bad) in training set %d' % (negSplit))
	print('Size of (good) in training set %d' % (posSplit))
	print('Size of (bad) in testing set %d' % negTestSize)
	print('Size of (good) in testing set %d' % posTestSize)
	print('Training Size: %d'% trainingSize)
	print('Testing Size: %d' % testingSize)

	train(cv2.face.createEigenFaceRecognizer(), trainingSetImages, trainingSetChoices, testingSetImages, testingSetChoices)
	train(cv2.face.createFisherFaceRecognizer(), trainingSetImages, trainingSetChoices, testingSetImages, testingSetChoices)
	train(cv2.face.createLBPHFaceRecognizer(), trainingSetImages, trainingSetChoices, testingSetImages, testingSetChoices)

def train(recognizer, trainSet, trainLabels, testSet, testLabels):
	t0 = time()
	print('Training Dataset')
	recognizer.train(trainSet, np.array(trainLabels))
	print('Finished: %0.3fs' % (time()-t0))

	i=0
	correct=0
	incorrect=0

	t0 = time()
	print('Testing Dataset')
	
	for face in testSet:
		predicted=recognizer.predict(face)
		actual=testLabels[i]

		print(predicted, actual)
		if(predicted==actual):
			correct+=1
		else:
			incorrect+=1
		i+=1

	print('Finished: %0.3fs' % (time()-t0))
	print("Correct: %d" % correct)
	print("Incorrect: %d" % incorrect)
	print("Accuracy: %0.3f" % (100*(correct/len(testSet))))

def generateNum(x, n):
	arr=[]

	for i in range(n):
		arr.append(x)

	return arr

def grabData(filename):
	with open(filename, 'r') as fd:
		content = fd.read().splitlines()

	return content[1:]

def grabImages(files):
	size=len(files)
	imArr=[]

	if(size):
		newface=getFaces(files[0])
		print(files[0])

		newfaces=faceCascade.detectMultiScale(newface, 1.1, 5)
		for(x, y, w, h) in newfaces:
			imArr=[cv2.resize(newface[y: y+h, x: x+w], (400, 400))]

	for i in range(1, size):
		newface=getFaces(files[i])
		print(files[i])

		newfaces=faceCascade.detectMultiScale(newface, 1.1, 5)
		for(x, y, w, h) in newfaces:
			imArr.append(cv2.resize(newface[y: y+h, x: x+w], (400, 400)))
	
	return imArr

def getFaces(file):
	newface=cv2.imread('Women/'+file, 0)
	#print(file)
	#newface=cv2.cvtColor(newface, cv2.COLOR_BGR2GRAY)
	return newface

main()
