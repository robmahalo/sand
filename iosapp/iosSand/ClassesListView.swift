//
//  ClassesListView.swift
//  sandy
//
//  Created by Madison Gipson on 2/19/20.
//  Copyright © 2020 csci321. All rights reserved.
//

import SwiftUI
import Firebase
import FirebaseDatabase

struct ClassRowView: View {
    var classes:String
    let screenSize = UIScreen.main.bounds
    var body: some View {
        HStack {
            Image("sampsonhall").resizable().foregroundColor(Color.gray).frame(width: self.screenSize.width*0.15, height: self.screenSize.width*0.15).clipShape(Circle()).padding([.horizontal, .vertical])
            Text(classes).font(.system(size: 20, weight: .thin, design: .default)).foregroundColor(Color.gray)
        }
    }
}

struct ClassesListView: View {
    @State private var showDetailForm = false
    @State private var showReqForm = false
    @ObservedObject var classesListController:ClassesListController
    //var classes:String
    //@State var currentClass:String = " "
    let screenSize = UIScreen.main.bounds
    // Remove Line separators from list
    var body: some View {
        VStack {
            HStack {
                EditButton().foregroundColor(Color.yellow)
                Text("My Classes").font(.system(size: 36, weight: .thin, design: .default)).foregroundColor(Color.yellow).padding(.horizontal, 40)//.background(Color.yellow)
                Button(action: {
                    self.showDetailForm.toggle()
                    self.classesListController.retrieveClassList()
                    // add class
                }) {
                    Image("Add Icon")
                    .resizable()
                    .foregroundColor(Color.yellow) // change color if it's clicked
                    .frame(width: screenSize.width/15, height: screenSize.width/15)
                    .padding(.horizontal)
                }.sheet(isPresented: self.$showDetailForm) {
                    AddClasses(classesListController: self.classesListController)
                }
            }.frame(width: screenSize.width, height: screenSize.width/6, alignment: .center)
            List {
                ForEach(ClassesListController.studentList, id: \.self) { studentClass in
                    //if studentClass != "" {
                    ClassRowView(classes: studentClass)
                    
                    //Text(studentClass).font(.system(size: 20, weight: .thin, design: .default)).foregroundColor(Color.gray)
                }.onDelete(perform: deleteItem).onLongPressGesture {
                    print("long press")
                    self.showReqForm.toggle()
                }.sheet(isPresented: self.$showReqForm) {
                    MakeRequestView(classesListController: self.classesListController, timeList: [" "], displayTimeList: [true])
                }
            }
        }
    }
    
    func deleteItem(at offsets: IndexSet) {
        print("before delete: ", ClassesListController.studentList)
        //remove the class from the ui/app list
        ClassesListController.studentList.remove(atOffsets: offsets)
        
        print("after delete: ", ClassesListController.studentList)
        
        //remove all from db list
        let ref:DatabaseReference = AppDelegate.shared().studentList.child(SceneDelegate.GUID)
        ref.child("classes").child("CSCI141").removeValue() { error, _ in print(error) }
        /*ref.child("classes").observeSingleEvent(of: .value, with: { snapshot in
            let removedClass = (snapshot.value as? Dictionary<String, Any>)!
            print("class: ", removedClass)
            ref.child("classes").removeValue()
        })*/
        
        //add all in ClassesListController.studentList back in
        /*ref.child("classes").observe(.value, with: { snapshot in
            //ClassesListController.studentList.removeAll()
            ClassesListController.studentList.remove(at: 0)
            for s in snapshot.value as! [String] {
                ClassesListController.studentList.append(s)
            }
        })*/
        self.classesListController.retrieveClassList()
        print("end: ", ClassesListController.studentList)
        //self.classesListController.retrieveClassList()
        
        //let ref:DatabaseReference = AppDelegate.shared().studentList.child(SceneDelegate.GUID)
        /*AppDelegate.shared().studentList.child(SceneDelegate.GUID).child("classes").observeSingleEvent(of: .value, with: { snapshot in
            for s in snapshot.value as! [String] {
                var refExist:Bool = false
                var toSetRef:[String] = []
                toSetRef.remove()
                ref.child("classes").setValue(toSetRef)
                for x in ClassesListController.studentList {
                    toSetRef.append(x)
                    if x == c {
                        refExist = true
                    }
                }
                if !refExist {
                    toSetRef.append(c)
                    ref.child("classes").setValue(toSetRef)
                }
            }
            })*/
        
    }
}

/*struct ClassesListView_Previews: PreviewProvider {
    static var previews: some View {
        ClassesListView()
    }
}*/
