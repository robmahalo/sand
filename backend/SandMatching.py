import json
import firebase
import firebase_admin
from firebase_admin import credentials, firestore, storage, db
from datetime import datetime

print("script starting")

#allMatchedThisSession = []
#numMatchedThisSession = 0
#numRemainingUnmatched = 0

cred = credentials.Certificate('sand-983a5-firebase-adminsdk-mmked-94f71ba225.json')
default_app = firebase_admin.initialize_app(cred, {'databaseURL': 'https://sand-983a5.firebaseio.com/'})

tutorsDictionary = {"tutors": {"fe0ec75b-204a-47b7-8caf-84b1cfc8a418": {"rating": 5, "classes": ["CSCI142", "CSCI141", "CINF304"], "offerings": { "9:00 AM": {"booked": False,"group": False,"location": "Elizabeth 205"}}}, "ef2100f8-d95d-4c2f-bff3-bcedca31dcec": {"rating": 4, "classes": ["CSCI142", "CSCI141"], "offerings": {"9:00 AM": {"group": False, "location": "Elizabeth 210", "booked": False}}}}}
requestsDictionary = {"requests": {"req1": {"matched": False, "studentGUID": "d076fafd-9da8-4db9-86e4-b21a128d80be", "tutorLocation": "", "time": "", "timesAvailable": ["9:00 AM", "9:30 AM"], "class": "CSCI141", "group": False}, "req2": {"matched": False, "studentGUID": "d076fafd-9da8-4db9-86e4-b21a128d80be", "tutorLocation": "", "time": "", "timesAvailable": ["9:00 AM", "9:30 AM"], "class": "CSCI142", "group": False}}}
studentsDictionary = {"students": {"d076fafd-9da8-4db9-86e4-b21a128d80be": {"classes": ["CSCI142", "CSCI141"]}}}
#offeredCoursesDic = {"CSCI141": True, "CSCI142": True}

tutorsRef = db.reference('/Tutors')
requestsRef = db.reference('/Requests')
studentsRef = db.reference('/Students')
#offeredRef = db.reference('/Offerings')

#tutorsRef.set(tutorsDictionary)
#requestsRef.set(requestsDictionary)
#studentsRef.set(studentsDictionary)

usableTutors = tutorsRef.get()
usableRequests = requestsRef.get()
usableStudents = studentsRef.get()
print(usableRequests)
#usableOffered = offeredRef.get()

#match method
#numMatchedThisSession = 0
#numRemainingUnmatched = 0
def match():
    numMatchedThisSession = 0
    numRemainingUnmatched = 0
    requestsMatched = []
    for k, req in usableRequests['requests'].items():
        numRemainingUnmatched += 1
        if req['matched'] == False: #if not matched, try to match
            #print(req)
            #print("============")
            tutorArrayOne = filterClasses(req) #array of tutors filtered by classes
            #print(tutorArrayOne)
            #print("============")
            tutorArrayTwo = filterByTime(tutorArrayOne, req) #array of tutors filtered by class type and time
            #print(tutorArrayTwo)
            #print("============")
            if len(tutorArrayTwo) > 1:
                actualTutor = filterByRatingAndLastMatched(tutorArrayTwo, req)
                actualTutorDic = actualTutor[0]
                #print(actualTutorDic)
                #print("-------")
                actualTutorGUID = actualTutor[1]
                #print(actualTutorGUID)
                #print("-------")
                #match by time again
                timeMatched = ""
                hasTimeMatched = False
                for time in req['timesAvailable']:
                    for t in actualTutorDic[actualTutorGUID]['offerings']:
                        if t == time:
                            if hasTimeMatched == False: #match with first matching time
                                timeMatched = t
                                hasTimeMatched = True
                req['time'] = timeMatched
                req['tutorLocation'] = actualTutorDic[actualTutorGUID]['offerings'][timeMatched]['location']
                req['matched'] = True

                actualTutorDic[actualTutorGUID]['offerings'][timeMatched]['booked'] = True #book tutor

                #update in program
                usableTutors[actualTutorGUID] = actualTutorDic
                usableRequests[k] = req

                #update in FB
                refToRequest = db.reference('Requests/requests').child(k)
                refToRequest.set(req)
                refToTutor = db.reference('Tutors/tutors').child(actualTutorGUID)
                refToTutor.set(actualTutorDic[actualTutorGUID])
                numMatchedThisSession += 1
                numRemainingUnmatched -= 1
                requestsMatched.append(k)
                #need to update tutor time to booked, need to update request to have correct time, matched = True, && location <- all steps
            else:
                actualTutorDic = {}
                actualTutorGUID = ""
                for keys, v in tutorArrayTwo.items():
                    actualTutorDic[keys] = v
                    actualTutorGUID = keys
                
                    #=====
                timeMatched = ""
                hasTimeMatched = False
                for time in req['timesAvailable']:
                    for t in actualTutorDic[actualTutorGUID]['offerings']:
                        if t == time:
                            if hasTimeMatched == False: #match with first matching time
                                timeMatched = t
                                hasTimeMatched = True
                req['time'] = timeMatched
                req['tutorLocation'] = actualTutorDic[actualTutorGUID]['offerings'][timeMatched]['location']
                req['matched'] = True

                actualTutorDic[actualTutorGUID]['offerings'][timeMatched]['booked'] = True #book tutor

                #update in program
                usableTutors[actualTutorGUID] = actualTutorDic
                usableRequests[k] = req

                #update in FB
                refToRequest = db.reference('Requests/requests').child(k)
                print(k)
                refToRequest.set(req)
                refToTutor = db.reference('Tutors/tutors').child(actualTutorGUID)
                refToTutor.set(actualTutorDic[actualTutorGUID])
                numMatchedThisSession += 1
                numRemainingUnmatched -= 1
                requestsMatched.append(k)
                #=====
            #actualTutor = tutorArrayTwo[0]
        else:
            numRemainingUnmatched -= 1
    return (numMatchedThisSession, numRemainingUnmatched, requestsMatched)

#filter by classes
def filterClasses(req):
    tutorList = {} #[]
    requestIsForClass = req['class'] #student's request class
    #print(usableTutors)
    #print("==============")
    for k, tutorInfo in usableTutors['tutors'].items(): #for each tutor
        for element in tutorInfo['classes']:
            if element == requestIsForClass:
                tutorList[k] = tutorInfo
                #tutorList.append(usableTutors['tutors'][k]) #append valid tutor info
    return tutorList

def filterByTime(filteredArray, req):
    tutorList = {} #[]
    requestIsForTime = req['timesAvailable'] #array of times available
    for time in requestIsForTime:
        for k, tutorInfo in filteredArray.items():
            for timeKey, timeData in tutorInfo['offerings'].items(): #timeKey is one of tutor's times
                if timeData['group'] == req['group'] and timeData['booked'] == False:
                    if timeKey == time: #if request and tutor have a matching time
                        tutorList[k] = tutorInfo
                        #tutorList.append(filteredArray[k]) #note to self
    return tutorList

def filterByRatingAndLastMatched(filteredArray, req):
    currentBestTutor = {}
    currentBestTutorGUID = ""
    i = 0
    lastKey = ""
    for k, tutorInfo in filteredArray.items():
        if i == 0:
            currentBestTutor[k] = filteredArray[k]
            currentBestTutorGUID = k
            i = 1
            lastKey = k
        else:
            if currentBestTutor[lastKey]['rating'] < tutorInfo['rating']:#k['rating']:
                currentBestTutor = {}
                currentBestTutor[k] = filteredArray[k]#tutorInfo['rating']#k['rating']
                currentBestTutorGUID = k
                lastKey = k
    #print(currentBestTutor)
    tupleX = (currentBestTutor, currentBestTutorGUID)
    return tupleX#(currentBestTutor, currentBestTutorGUID)
    #MUST REMOVE OLD KEY
printOutput = match()

with open("log.txt", "a+") as file_object:
    file_object.seek(0)
    data = file_object.read(100)
    if len(data) > 0:
        file_object.write("\n")
    dateTimeObj = datetime.now()
    file_object.write("Ran the script at ")
    file_object.write(str(dateTimeObj))
    file_object.write("\n")
    file_object.write("Number matched: ")
    file_object.write(str(printOutput[0]))
    file_object.write("\n")
    file_object.write("Number remaining unmatched: ")
    file_object.write(str(printOutput[1]))
    file_object.write("\n")
    file_object.write("Requests matched: ")
    if len(printOutput[2]) > 0:
        for i in printOutput[2]:
            file_object.write(str(i))
    file_object.write("\n")

"""for k, req in usableRequests['requests'].items():
    groupYN = req["group"] #does student want a group session
    if req['matched'] == False:
        for time in req['timesAvailable']:
            checkTime = time
            for key, tutorInfo in usableTutors['tutors'].items():
                for timeKey, info in tutorInfo['offerings'].items():
                    if timeKey == checkTime and tutorInfo['offerings'][timeKey]['booked'] == False: #is a match                 
                        req['matched'] = True
                        tutorInfo['offerings'][timeKey]['booked'] == True
                        ref = db.reference('/Requests/requests').child(k).child('matched') #reference the request that got matched
                        ref.set(True)
                        refTLocation = db.reference('/Requests/requests').child(k).child('tutorLocation')
                        refTLocation.set(tutorInfo['offerings'][timeKey]['location'])
                        refT = db.reference('Tutors/tutors').child(key).child('offerings').child(timeKey).child('booked')
                        refT.set(True)"""
