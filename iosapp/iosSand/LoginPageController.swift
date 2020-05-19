//
//  LoginPageViewController.swift
//  sandy
//
//  Created by Marshall Thompson on 2/15/20.
//  Copyright © 2020 csci321. All rights reserved.
//

import UIKit
import Firebase
import Combine

class LoginPageController: ObservableObject
{
    var didChange = PassthroughSubject<LoginPageController, Never>()
    @Published var session: User? {didSet {self.didChange.send(self)}}
    @Published var handle: AuthStateDidChangeListenerHandle?
    
    func listen()
    {
        handle = Auth.auth().addStateDidChangeListener({(auth, user) in
            if let user = user
            {
                self.session = User(uid: user.uid, email: user.email)
            }
            else
            {
                self.session = nil
            }
        })
    }
    
    func signIn(email: String, password: String, handler: @escaping AuthDataResultCallback)
    {
        Auth.auth().signIn(withEmail: email, password: password, completion: handler)
    }
    
    func signUp(email: String, password: String, handler: @escaping AuthDataResultCallback)
    {
        Auth.auth().createUser(withEmail: email, password: password, completion: handler)
    }

}
struct User
{
    var uid: String
    var email: String?
    
    init(uid: String, email: String?)
    {
        self.uid = uid
        self.email = email
    }
}


