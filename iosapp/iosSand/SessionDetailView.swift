//
//  SessionDetailView.swift
//  sandy
//
//  Created by Madison Gipson on 3/16/20.
//  Copyright © 2020 csci321. All rights reserved.
//

import SwiftUI

struct SessionDetailView: View {
    @ObservedObject var request:Request
    let screenSize = UIScreen.main.bounds
    var body: some View {
        VStack {
            if request.matched {
                Text(request.clas).frame(width: screenSize.width, height: screenSize.width/6, alignment: .center).font(.system(size: 36, weight: .thin, design: .default)).foregroundColor(Color.yellow)
                Text(" at " + request.time).font(.system(size: 18, weight: .thin, design: .default)).foregroundColor(Color.yellow)
                Text(" in " + request.tutorLocation).font(.system(size: 18, weight: .thin, design: .default)).foregroundColor(Color.yellow)
            } else {
                Text(request.clas).frame(width: screenSize.width, height: screenSize.width/6, alignment: .center).font(.system(size: 36, weight: .thin, design: .default)).foregroundColor(Color.gray)
                Text("Request not yet matched.").font(.system(size: 18, weight: .thin, design: .default)).foregroundColor(Color.gray)
            }
            /*VStack {
                if request.matched {
                    Text(" at " + request.time).font(.system(size: 18, weight: .thin, design: .default)).foregroundColor(Color.yellow)
                    Text(" in " + request.location).font(.system(size: 18, weight: .thin, design: .default)).foregroundColor(Color.yellow)
                } else {
                    Text("Request not yet matched.").font(.system(size: 18, weight: .thin, design: .default)).foregroundColor(Color.gray)
                    Text(" in " + request.location).font(.system(size: 18, weight: .thin, design: .default)).foregroundColor(Color.gray)
                }*/
            }
        }
    }
