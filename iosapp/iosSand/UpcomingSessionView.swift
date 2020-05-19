//
//  UpcomingSessionsView.swift
//  sandy
//
//  Created by Madison Gipson on 2/19/20.
//  Copyright © 2020 csci321. All rights reserved.
//

import SwiftUI

struct SessionRow: View {
    @ObservedObject var request:Request
    @State private var showDetailForm = false
    var body: some View {
        VStack {
            Image("elizabethhall").resizable().foregroundColor(Color.gray).aspectRatio(contentMode: .fit)
        Button(action: {
            print("action")
            self.showDetailForm.toggle()
        }) { HStack {
            // Only difference is color of text
            if request.matched {
                Text(request.clas).font(.system(size: 30, weight: .light, design: .default)).foregroundColor(Color.yellow).padding(.horizontal)
            } else {
                Text(request.clas).font(.system(size: 30, weight: .light, design: .default)).foregroundColor(Color.gray).padding(.horizontal)
            }
            VStack {
                if request.matched {
                    Text(" at " + request.time == "" ? "Not matched" : request.time).font(.system(size: 18, weight: .thin, design: .default)).foregroundColor(Color.yellow)
                    Text(" in " + request.tutorLocation == "" ? "Not matched" : request.tutorLocation).font(.system(size: 18, weight: .thin, design: .default)).foregroundColor(Color.yellow)
                } else {
                    Text("Not matched").font(.system(size: 18, weight: .thin, design: .default)).foregroundColor(Color.gray)
                    Text("Not matched").font(.system(size: 18, weight: .thin, design: .default)).foregroundColor(Color.gray)
                }
            }
        }}.sheet(isPresented: self.$showDetailForm) {
            SessionDetailView(request: self.request)}
        }.cornerRadius(20).shadow(color: Color.gray, radius: 12)
        .overlay(RoundedRectangle (cornerRadius: 20).stroke(Color(.sRGB, red: 150/255, green: 150/255, blue: 150/255, opacity: 0.2), lineWidth: 1)).padding([.top, .horizontal])
    }
}

struct Calendar: View {
   static let taskDateFormat: DateFormatter = {
       let formatter = DateFormatter()
       formatter.locale = Locale(identifier: "en-US")
       formatter.setLocalizedDateFormatFromTemplate("EEE MMM d yyyy")
       formatter.dateStyle = .full
       return formatter
   }()
    var dueDate = Date()
    var body: some View {
        VStack {
            Image("palmcourt").resizable().foregroundColor(Color.gray).aspectRatio(contentMode: .fit)
        HStack {
            VStack (alignment: .leading ) {
                Text("\(dueDate, formatter: Self.taskDateFormat)").font(.system(size: 20, weight: .thin, design: .default)).foregroundColor(Color.gray)
            }.layoutPriority(100)
         Spacer()
        }.padding()
        }.cornerRadius(20).shadow(color: Color.gray, radius: 12)
         .overlay(
        RoundedRectangle (cornerRadius: 20).stroke(Color(.sRGB, red: 150/255, green: 150/255, blue: 150/255, opacity: 0.2), lineWidth: 1))
            .padding([.top, .horizontal])
   }
}

struct UpcomingSessionsView: View {
    @State private var showDetailForm = false
    @ObservedObject var reqController:RequestController
    @ObservedObject var classesListController:ClassesListController
    @State var timeList:[String] = []
    @State var displayTimeList:[Bool] = []
    let screenSize = UIScreen.main.bounds
    //@ObservedObject var request:Request
    
    func generateTimeList() {
        timeList.append("12:00 AM")
        timeList.append("12:30 AM")
        for i in 1...11 {
            timeList.append(String(i) + ":00 AM")
            timeList.append(String(i) + ":30 AM")
        }
        timeList.append("12:00 PM")
        timeList.append("12:30 PM")
        for i in 1...11 {
            timeList.append(String(i) + ":00 PM")
            timeList.append(String(i) + ":30 PM")
        }
        for _ in 0...47 {
            displayTimeList.append(false)
        }
    }
    
    var body: some View {
        VStack {
            ScrollView(.vertical, showsIndicators: false) {
            HStack(spacing: 218){
                Text("sand").font(.system(size:25,design:.default)).foregroundColor(Color.yellow).frame(width: screenSize.width/6, height: screenSize.width/8)
                Button(action: {
                    self.showDetailForm.toggle()
                    self.generateTimeList()
                }) {
                    Image("Find Tutor")
                    .resizable()
                    .foregroundColor(Color.yellow) // change color if it's clicked
                    .frame(width: screenSize.width/15, height: screenSize.width/15)
                    .padding(.horizontal)
                    }.sheet(isPresented: self.$showDetailForm) {
                    MakeRequestView(classesListController: self.classesListController, timeList: self.timeList, displayTimeList: self.displayTimeList)
                }
            }
            // Display Calendar
            Calendar()
                HStack(spacing: 110) {
                    Text("Upcoming Sessions")/*.frame(width: screenSize.width, height: screenSize.width/6, alignment: .center)*/.font(.system(size: 25, weight: .thin, design: .default)).foregroundColor(Color.gray)
                    // Blank image used for spacing
                    Image("")
                }
                //=====
                //=====
                //.background(Color.yellow)
            //Divider().padding(.bottom, 8).foregroundColor(Color.white).background(Color.yellow)
            // Use Horizontal Scroll View instead of List
            ScrollView(.horizontal, showsIndicators: false) {
                HStack(spacing: 1) {
                ForEach(reqController.reqList) { req in SessionRow(request: req)}.frame(width: 320, height: 320, alignment: .leading)
                    }
                }
            }
        }
    }
}
