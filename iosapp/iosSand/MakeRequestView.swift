//
//  MakeRequestView.swift
//  iosSand
//
//  Created by Lannie Hough on 3/30/20.
//  Copyright © 2020 Madison Gipson. All rights reserved.
//

import SwiftUI

struct MakeRequestView: View {
    @ObservedObject var classesListController:ClassesListController
    @State private var group = false
    @State var timeList:[String]
    @State var displayTimeList:[Bool]
    @State var lastIndex:Int = -5
    @State var clas:String = ""
    @State private var showingAlert = false
    var body: some View {
        VStack {
            VStack {
            HStack {
                Text("Make Request").font(.title).foregroundColor(Color.yellow)
            }
            Divider().background(Color.yellow)
            HStack {
                Toggle(isOn: $group) {
                    Text("Group meeting?").foregroundColor(Color.yellow)
                }.padding()
            }
            Divider().background(Color.yellow)
            HStack {
                Text("Times available:").padding().foregroundColor(Color.yellow)
                Spacer()
            }
            List {
                ForEach(timeList, id: \.self) { time in
                    Button(action: {
                        let indexS:Int = self.timeList.firstIndex(of: time)!
                        if self.displayTimeList[indexS] {
                            self.displayTimeList[indexS] = false
                        }
                        if !self.displayTimeList[indexS] {
                            self.displayTimeList[indexS] = true
                        }
                        //print(self.classesListController.displayStudentList[indexS])
                    }) {
                        ZStack {
                            HStack {
                                Text(time)
                                Spacer()
                                if self.displayTimeList[self.timeList.firstIndex(of: time)!] {
                                    Image(systemName: "checkmark")
                                }
                            }
                        }
                    }
                }
            }
            }
            VStack {
            Divider().background(Color.yellow)
            HStack {
                Text("Class:").padding().foregroundColor(Color.yellow)
                Spacer()
            }
            List {
                ForEach(ClassesListController.studentList, id: \.self) { clas in
                    Button(action: {
                        let indexS:Int = ClassesListController.studentList.firstIndex(of: clas)!
                        if self.lastIndex != indexS && self.lastIndex >= 0 {
                            self.classesListController.displayStudentList[self.lastIndex].toggle()
                        }
                        self.classesListController.displayStudentList[indexS].toggle()
                        if self.clas != clas {
                            self.clas = clas
                        } else {
                            self.clas = ""
                        }
                        print(self.classesListController.displayStudentList[indexS])
                        self.lastIndex = indexS
                    }) {
                        ZStack {
                            HStack {
                                Text(clas)
                                Spacer()
                                if self.classesListController.displayStudentList[ClassesListController.studentList.firstIndex(of: clas)!] == true {
                                    Image(systemName: "checkmark")
                                }
                            }
                        }
                    }
                }
            }
            Divider().background(Color.yellow)
            Button(action: {
                self.buildRequest()
            }) {
                ZStack {
                    RoundedRectangle(cornerRadius: CGFloat(5)).foregroundColor(Color.yellow).frame(width: UIScreen.main.bounds.width/3, height: UIScreen.main.bounds.height/12, alignment: .center)
                    Text("Make Request")
                }
            }.alert(isPresented: $showingAlert) {
                Alert(title: Text("ERROR"), message: Text("Please select a time and class!"), dismissButton: .default(Text("Ok")))
                }
            }
        }
    }
    
    func buildRequest() {
        var request:Dictionary<String, Dictionary<String, Any>> = [:]
        let uuid = UUID().uuidString
        request[uuid] = [:]
        if self.clas != "" {
            request[uuid]!["class"] = self.clas
        } else {
            self.showingAlert = true
            return
        }
        request[uuid]!["group"] = self.group
        request[uuid]!["matched"] = false
        request[uuid]!["studentGUID"] = AppDelegate.shared().getAuthId()
        request[uuid]!["tutorGUID"] = ""
        request[uuid]!["time"] = ""
        var tempTimeList:[String] = []
        var isTimeAvailable:Bool = false
        for i in 0...47 {
            if self.displayTimeList[i] == true {
                tempTimeList.append(self.timeList[i])
                isTimeAvailable = true
                //return
            }
        }
        if isTimeAvailable {
            request[uuid]!["timesAvailable"] = tempTimeList
        } else {
            self.showingAlert = true
            return
        }
        request[uuid]!["tutorLocation"] = ""
        
        let ref = AppDelegate.shared().requestList
        let childRef = ref?.childByAutoId()
        childRef?.setValue(request[uuid])
        
    }
    
}
