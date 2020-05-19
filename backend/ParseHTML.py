#!/usr/bin/env python

#Lannie Dalton Hough

import re
import json
import sys
import firebase
import firebase_admin
from firebase_admin import credentials, firestore, storage, db

html = sys.stdin.readlines()

cred = credentials.Certificate('sand-983a5-firebase-adminsdk-mmked-94f71ba225.json')
default_app = firebase_admin.initialize_app(cred, {'databaseURL': 'https://sand-983a5.firebaseio.com/'})

fullHtml = ""

for line in html:
    fullHtml += line

fullCourseHierarchy = {}
fullCourseDictionary = {}
fullCourseList = []
fullSubjectDictionary = {}

def parseHTML():
    #get blocks starting in <tr and ending in /tr> not greedy
    trBlockRegex = r'(<tr(.|\n)+?<\/tr>)'
    trBlockPattern = re.compile(trBlockRegex)
    trBlocksMatched = re.findall(trBlockPattern, fullHtml)
    trBlocksMatchedElementOne = ""
    for block in trBlocksMatched:
        #findall returns tuple in this case, we only care about first elements
        trBlocksMatchedElementOne += block[0]
    classesRegex = r'<td\sCLASS="dddefault">[A-Z]{4}<\/td>\n<td CLASS="dddefault">\d{3}\w{1}|<td\sCLASS="dddefault">[A-Z]{4}<\/td>\n<td CLASS="dddefault">\d{3}'
    classesPattern = re.compile(classesRegex)
    classesMatched = re.findall(classesPattern, trBlocksMatchedElementOne)
    for c in classesMatched:
        #regex for the subject in format CSCI, CSEC, CINF, etc.
        subjectRegex = r'>[A-Z]{4}'
        subjectPattern = re.compile(subjectRegex)
        #regex for the class code in format 142, 385, 211Q, etc.
        codeRegex = r'>\d{3}\w|>\d{3}'
        codePattern = re.compile(codeRegex)
        #only working with one course code per loop iteration
        subjectList = re.findall(subjectPattern, c)
        codeList = re.findall(codePattern, c)
        courseSubject = subjectList[0]
        courseSubject = courseSubject[1:] #strip leading >
        courseNumber = codeList[0]
        courseNumber = courseNumber[1:] #strip leading >
        fullCourseCode = courseSubject + courseNumber
        fullCourseDictionary[fullCourseCode] = True

def buildHierarchy():
    for k, v in fullCourseDictionary.items():
        fullCourseList.append(k)
        subject = k[0] + k[1] + k[2] + k[3] #format CSCI course subject
        fullSubjectDictionary[subject] = True #effectively a list of all subjects, dictionary used so we don't have to check if a subject is present in an array
    for k, v in fullSubjectDictionary.items(): #build empty hierarchy
        fullCourseHierarchy[k] = []
    for i in fullCourseList:
        sub = i[0] + i[1] + i[2] + i[3]
        fullCourseHierarchy[sub].append(i)


parseHTML()
buildHierarchy()

classesRef = db.reference('/Classes')
classesRef.set(fullCourseHierarchy)

#print(fullCourseHierarchy)