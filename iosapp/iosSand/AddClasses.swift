//
//  AddClasses.swift
//  iosSand
//
//  Created by Madison Gipson on 3/30/20.
//  Copyright © 2020 Madison Gipson. All rights reserved.
//

import SwiftUI
import Firebase
import FirebaseDatabase

struct AddClasses: View {
    @ObservedObject var classesListController:ClassesListController
    let screenSize = UIScreen.main.bounds
    var body: some View {
        VStack {
            RoundedRectangle(cornerRadius: 10).background(Color.gray).opacity(0.1).frame(width: UIScreen.main.bounds.width/4, height: 5).padding([.vertical])
            Text("Add Classes").font(.system(size: 32, weight: .thin, design: .default)).foregroundColor(Color.yellow)
            NavigationView {
                List {
                    ForEach(self.classesListController.classTypeList, id: \.self) { cl in
                    NavigationLink(destination: AddClassesSub(classList: self.classesListController.classDic[cl]!)) {
                        Text(cl).font(.system(size: 18, weight: .thin, design: .default)).foregroundColor(Color.gray)
                        }
                    }
                }
            }
        }
    }
}

struct AddClassesSub: View {
    var classList:[String]
    @State private var showingAlert = false
    
    var body: some View {
        List {
            ForEach(classList, id: \.self) { c in
                Button(action : {
                    let ref:DatabaseReference = AppDelegate.shared().studentList.child(AppDelegate.shared().getAuthId())
                    AppDelegate.shared().studentList.child(AppDelegate.shared().getAuthId()).child("classes").observeSingleEvent(of: .value, with: { snapshot in
                        for s in snapshot.value as! [String] {
                            var refExist:Bool = false
                            var toSetRef:[String] = []
                            for x in ClassesListController.studentList {
                                toSetRef.append(x)
                                if x == c {
                                    refExist = true
                                }
                            }
                            if !refExist {
                                toSetRef.append(c)
                                //ClassesListController.studentList.append(c)
                                ref.child("classes").setValue(toSetRef)
                            }
                            //ClassesListController.studentList.append(s)
                        }
                        })
                    self.showingAlert = true
                }) {
                    Text(c).font(.system(size: 18, weight: .thin, design: .default)).foregroundColor(Color.gray)
                }.alert(isPresented: self.$showingAlert) {
                    Alert(title: Text("Class Added"), dismissButton: .default(Text("OK")))
                }
            }
        }
    }
    
}
