//
//  SceneDelegate.swift
//  sandy
//
//  Created by Robert Manalo on 2/5/20.
//  Copyright © 2020 csci321. All rights reserved.
//

import UIKit
import SwiftUI
import Firebase

class SceneDelegate: UIResponder, UIWindowSceneDelegate {
    
    public static let GUID:String = "QLBZL3CdweWYFrlbwEaSc5wnEK12"

    var reqController:RequestController!
    var classesListController:ClassesListController!
    var loginPageController:LoginPageController!
    var window: UIWindow?


    func scene(_ scene: UIScene, willConnectTo session: UISceneSession, options connectionOptions: UIScene.ConnectionOptions) {
        // Use this method to optionally configure and attach the UIWindow `window` to the provided UIWindowScene `scene`.
        // If using a storyboard, the `window` property will automatically be initialized and attached to the scene.
        // This delegate does not imply the connecting scene or session are new (see `application:configurationForConnectingSceneSession` instead).
        //guard let _ = (scene as? UIWindowScene) else { return }
        
//        var request1: Request = Request(request: "req1", matched: false, classRequest: "", time: "", location: "")
//        var request2: Request = Request(request: "req2", matched: false, classRequest: "", time: "", location: "")
        
        self.reqController = RequestController()
        if Auth.auth().currentUser != nil {
            self.reqController.buildRequestList()
        }
        self.classesListController = ClassesListController()
        self.loginPageController = LoginPageController()
        if Auth.auth().currentUser != nil {
            self.classesListController.retrieveAllData(studentGUID: "QLBZL3CdweWYFrlbwEaSc5wnEK12")
        }
        
//        let classesListController: ClassesListController = ClassesListController()
//        // Pass in studentGUID dynamically later on
//        classesListController.retrieveAllData(studentGUID: "d076fafd-9da8-4db9-86e4-b21a128d80be")
        
        let contentView = ViewController(reqController: self.reqController, classesListController: self.classesListController, user: doHaveUser())//UpcomingSessionsView(reqController: self.reqController)
//        if let windowScene = scene as? UIWindowScene {
//            let window = UIWindow(windowScene: windowScene)
//            window.rootViewController = UIHostingController(rootView: contentView)
//            self.window = window
//            window.makeKeyAndVisible()
//        }
        if let windowScene = scene as? UIWindowScene {
            let window = UIWindow(windowScene: windowScene)
            window.rootViewController = UIHostingController(rootView: contentView)
            self.window = window
            window.makeKeyAndVisible()
        }
    }
    
    func doHaveUser() -> Bool {
        if Auth.auth().currentUser != nil {
            //user = true
            return true
        }
        //user = false
        return false
    }

    func sceneDidDisconnect(_ scene: UIScene) {
        // Called as the scene is being released by the system.
        // This occurs shortly after the scene enters the background, or when its session is discarded.
        // Release any resources associated with this scene that can be re-created the next time the scene connects.
        // The scene may re-connect later, as its session was not neccessarily discarded (see `application:didDiscardSceneSessions` instead).
    }

    func sceneDidBecomeActive(_ scene: UIScene) {
        // Called when the scene has moved from an inactive state to an active state.
        // Use this method to restart any tasks that were paused (or not yet started) when the scene was inactive.
    }

    func sceneWillResignActive(_ scene: UIScene) {
        // Called when the scene will move from an active state to an inactive state.
        // This may occur due to temporary interruptions (ex. an incoming phone call).
    }

    func sceneWillEnterForeground(_ scene: UIScene) {
        // Called as the scene transitions from the background to the foreground.
        // Use this method to undo the changes made on entering the background.
    }

    func sceneDidEnterBackground(_ scene: UIScene) {
        // Called as the scene transitions from the foreground to the background.
        // Use this method to save data, release shared resources, and store enough scene-specific state information
        // to restore the scene back to its current state.
    }


}

