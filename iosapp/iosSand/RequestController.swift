//
//  Request.swift
//  sandy
//
//  Created by Madison Gipson on 2/19/20.
//  Copyright © 2020 csci321. All rights reserved.
//

import Foundation

class RequestController: ObservableObject {
    @Published var reqList:[Request] = []
    @Published var classList:[Request] = []
    @Published var timeList:[Request] = []
    @Published var locationList:[Request] = []
    
    func buildRequestList() {
        AppDelegate.shared().requestList.queryOrdered(byChild: "studentGUID").queryEqual(toValue: AppDelegate.shared().getAuthId()).observe(.value, with: { snap in
            if snap == nil {return}
            if snap.value == nil {return}
            if !(snap.value is NSNull) {
            var reqs = snap.value as! Dictionary<String, Dictionary<String, Any>>
            print(reqs)
            //var req = Request()
            self.reqList = []
            for (key, val) in reqs {
                var req = Request()
                for (k, v) in val {
                print("HELLO")
//                var req = Request()
                switch k {
                case "class":
                    req.clas = v as? String
                    print("HELLO WORLD")
                case "group":
                    req.group = v as? Bool
                case "matched":
                    req.matched = v as? Bool
                case "studentGUID":
                    req.studentGUID = v as? String
                case "tutorGUID":
                    req.tutorGUID = v as? String
                case "time":
                    req.time = v as? String
                case "timesAvailable":
                    for t in (v as? [String])! {
                        req.timesAvailable.append(t)
                    }
                case "tutorLocation":
                    req.tutorLocation = v as? String
                default:
                    print("wtf?")
                    break;
                }
                }
                self.reqList.append(req)
                }
            }
            //print(req)
            //self.reqList.append(req)
        })
    }
    
    /*func retrieveAllData() {
        for r in reqList {
            retrieveFirebaseData(requestName: r.id, request: r)
        }
    }
    func retrieveFirebaseData(requestName: String, request: Request) {
        AppDelegate.shared().requestList.child(requestName).child("matched").observe(.value, with: { snapshot in
            request.matched = snapshot.value as! Bool
            })
        AppDelegate.shared().requestList.child(requestName).child("class").observe(.value, with: { snapshot in
            request.classRequest = snapshot.value as! String
        })
        AppDelegate.shared().requestList.child(requestName).child("time").observe(.value, with: { snapshot in
            request.time = snapshot.value as! String
        })
        AppDelegate.shared().requestList.child(requestName).child("tutorLocation").observe(.value, with: { snapshot in
            request.location = snapshot.value as! String
        })
    }*/
}

class Request: Identifiable, ObservableObject {
    //@Published var id: String
    @Published var clas:String!
    @Published var group:Bool!
    @Published var matched: Bool!
    @Published var studentGUID:String!
    @Published var tutorGUID:String!
    @Published var time: String!
    @Published var timesAvailable:[String] = []
    @Published var tutorLocation:String!
    
    /*init(request: String, matched: Bool, classRequest: String, time: String, location: String) {
        self.id = request
        self.matched = matched
        self.classRequest = classRequest
        self.time = time
        self.location = location
    }*/
}
