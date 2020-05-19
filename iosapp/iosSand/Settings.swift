//
//  Settings.swift
//  iosSand
//
//  Created by Robert Manalo on 3/25/20.
//  Copyright © 2020 Madison Gipson. All rights reserved.
//

import SwiftUI

struct Settings: View {
    init(){
        UITableView.appearance().backgroundColor = .clear
    }
    var body: some View {
        NavigationView {
            ZStack {
                    VStack(alignment: .leading, spacing: 45, content: {
                        Form {
                    NavigationLink(destination: ProfileView()) {
                        Image(systemName: Constants.settingsNavigation.profileButton).resizable()
                            .frame(width:30, height:30)
                            .padding()
                            .foregroundColor(.gray)
                        Text("Profile")
                            .font(.headline)
                            .foregroundColor(Color.black.opacity(0.5))
                            .padding()
                    }
                    NavigationLink(destination: PaymentView()) {
                        Image(systemName: Constants.settingsNavigation.paymentButton).resizable()
                            .frame(width:30, height:30)
                            .padding()
                            .foregroundColor(.gray)
                        Text("Payment")
                            .font(.headline)
                            .foregroundColor(Color.black.opacity(0.5))
                            .padding()
                    }
                    NavigationLink(destination: AboutView()) {
                        Image(systemName: Constants.settingsNavigation.aboutButton).resizable()
                            .frame(width:30, height:30)
                            .padding()
                            .foregroundColor(.gray)
                        Text("About")
                        .font(.headline)
                        .foregroundColor(Color.black.opacity(0.5))
                        .padding()
                    }
                        }
                        .background(Color(.white))
                        .foregroundColor(Color.black.opacity(0.5))
                })
                        .navigationBarItems(leading:
                        HStack {
                        Text("Settings")
                            .padding(200)
                            .font(.system(size: 40, weight: .thin, design: .default))
                            .foregroundColor(Color.yellow)
                        })
            }
            }
            
        }
    }

struct Settings_Previews: PreviewProvider {
    static var previews: some View {
        Settings()
    }
}

