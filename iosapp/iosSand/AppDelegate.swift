//
//  AppDelegate.swift
//  sandy
//
//  Created by Robert Manalo on 2/5/20.
//  Copyright © 2020 csci321. All rights reserved.
//

import UIKit
import FirebaseAnalytics
import Firebase
import FirebaseDatabase


@UIApplicationMain
class AppDelegate: UIResponder, UIApplicationDelegate {

    @Published var liveList: DatabaseReference! // references Firebase
    @Published var tutorList: DatabaseReference!
    @Published var requestList: DatabaseReference!
    @Published var studentList: DatabaseReference!
    @Published var classesOfferedList:DatabaseReference!
    //@Published var offeringsList: DatabaseReference!
    var window: UIWindow?
    @Published var liveRequest: Bool!
    @Published var tutorRequest: Bool!
    @Published var requestRequest: Bool!
    @Published var studentRequest: Bool!
    @Published var offeringsRequest: Bool!

    func application(_ application: UIApplication, didFinishLaunchingWithOptions launchOptions: [UIApplication.LaunchOptionsKey: Any]?) -> Bool {
        FirebaseApp.configure()
        tutorList = Database.database().reference(withPath: "Tutors/tutors")
        requestList = Database.database().reference(withPath: "Requests/requests")
        studentList = Database.database().reference(withPath: "Students/students")
        classesOfferedList = Database.database().reference(withPath: "Classes")
        //offeringsList = Database.database().reference(withPath: "Offerings")
        
            return true
        }

        static func shared() -> AppDelegate {
            return UIApplication.shared.delegate as! AppDelegate
        }
    
            func getAuthId() -> String {
                return (Auth.auth().currentUser?.uid)!
            }
    
    }

    // MARK: UISceneSession Lifecycle

    func application(_ application: UIApplication, configurationForConnecting connectingSceneSession: UISceneSession, options: UIScene.ConnectionOptions) -> UISceneConfiguration {
        // Called when a new scene session is being created.
        // Use this method to select a configuration to create the new scene with.
        return UISceneConfiguration(name: "Default Configuration", sessionRole: connectingSceneSession.role)
    }

    func application(_ application: UIApplication, didDiscardSceneSessions sceneSessions: Set<UISceneSession>) {
        // Called when the user discards a scene session.
        // If any sessions were discarded while the application was not running, this will be called shortly after application:didFinishLaunchingWithOptions.
        // Use this method to release any resources that were specific to the discarded scenes, as they will not return.
    }
