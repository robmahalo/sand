//
//  Login2.swift
//  iosSand
//
//  Created by Marshall Thompson on 3/25/20.
//  Copyright © 2020 Madison Gipson. All rights reserved.
//

import SwiftUI
import Firebase

struct LoginView: View {
    // MARK: - Propertiers
    @ObservedObject var reqController:RequestController
    let classesListController:ClassesListController
    @State private var email = ""
    @State private var password = ""
    @State private var signUpModal:Bool = false
    @ObservedObject var loginPageController = LoginPageController()
    @Binding var user:Bool
    
    // MARK: - View
    var body: some View {
        VStack() {
            Text("Login")
                .font(.largeTitle).foregroundColor(Color.black)
                .padding([.top, .bottom], 40)
                .shadow(radius: 10.0, x: 20, y: 10)
            
            VStack(alignment: .leading, spacing: 15) {
                UsernameTextField(email: $email)
                PasswordTextField(password: $password)
            }.padding([.leading, .trailing], 27.5)
            
            Button(action:{self.Login()}){
                LoginButtonContent()
            }.padding(.top, 50)
            
            Spacer()
            HStack(spacing: 0) {
                Text("Don't have an account? ")
                Button(action: {
                    self.signUpModal.toggle()
                }) {
                    Text("Sign Up")
                        .foregroundColor(.black)
                }.sheet(isPresented: $signUpModal) {
                    SignUpView(signUpModal: self.$signUpModal)
                }
            }
        }
    
        .background(
            LinearGradient(gradient: Gradient(colors: [.white, .orange]), startPoint: .top, endPoint: .bottom)
                .edgesIgnoringSafeArea(.all))
        
    }
    func Login() {
        loginPageController.signIn(email:  self.email, password: self.password)
        { (result, error) in
            if error != nil
            {
                print("Error when signing in: \(error)")
            }
            else
            {
                self.user.toggle()
                self.reqController.buildRequestList()
                self.classesListController.retrieveAllData(studentGUID: "")
                print("login successful")
                
            }
            
        }
    }
}

struct SignUpView : View {
    // MARK: - Propertiers
    @Binding var signUpModal:Bool
    @State var email = ""
    @State var password = ""
    @State var confPassword = ""
    @State var firstName = ""
    @State var lastName = ""
    @ObservedObject var loginPageController = LoginPageController()
    private var validated: Bool {
        if(password == confPassword) {
            return true
        }
        else {
            return false
        }
    }
    var body: some View {
        VStack() {
            Text("Sign Up")
            .font(.largeTitle).foregroundColor(Color.black)
            .padding([.top, .bottom], 40)
            .shadow(radius: 10.0, x: 20, y: 10)
            
            
            VStack(alignment: .leading, spacing: 15) {
                FirstNameTextField(firstName: $firstName)
                LastNameTextField(lastName: $lastName)
                UsernameTextField(email: $email)
                PasswordTextField(password: $password)
                ConfPasswordTextField(confPassword: $confPassword)
                Button(action:{
                    if self.validated {
                        self.signUp()
                    }
                }){
                    SignUpButtonContent()
                }
                
            }.padding([.leading, .trailing], 27.5)
        }
        .background(
        LinearGradient(gradient: Gradient(colors: [.white, .orange]), startPoint: .top, endPoint: .bottom)
            .edgesIgnoringSafeArea(.all))
    }
    func signUp() {
        loginPageController.signUp(email: self.email, password: self.password)
        {(result, error) in
            if error != nil
            {
                print("Error when signing up: \(error)")
            }
            else
            {
                self.signUpModal.toggle()
                print("sign up successful")
                var tempDic:Dictionary<String, Any> = [:]
                tempDic["classes"] = [""]
                tempDic["email"] = self.email
                tempDic["firstName"] = self.firstName
                tempDic["lastName"] = self.lastName
                var tempDic2:Dictionary<String, Any> = [:]
                tempDic2[self.getAuthId()] = tempDic
                AppDelegate.shared().studentList.child(self.getAuthId()).setValue(tempDic)
//                AppDelegate.shared().studentList.updateChildValues(tempDic2)
            }
        }
    }
    
    func getAuthId() -> String {
        return (Auth.auth().currentUser?.uid)!
    }
    
}



struct FirstNameTextField : View {
    @Binding var firstName: String
    var body: some View {
        TextField("First Name", text: $firstName)
            .padding()
            .background(Color.white)
            .cornerRadius(20.0)
            .shadow(radius: 10.0, x: 20, y: 10)
    }
}

struct LastNameTextField : View {
    @Binding var lastName: String
    var body: some View {
        TextField("First Name", text: $lastName)
            .padding()
            .background(Color.white)
            .cornerRadius(20.0)
            .shadow(radius: 10.0, x: 20, y: 10)
    }
}

struct UsernameTextField : View {
    @Binding var email: String
    var body: some View {
        TextField("Email", text: $email)
            .padding()
            .background(Color.white)
            .cornerRadius(20.0)
            .shadow(radius: 10.0, x: 20, y: 10)
            .autocapitalization(.none)
    }
}

struct PasswordTextField : View {
    @Binding var password: String
    var body: some View {
        SecureField("Password", text: $password)
            .padding()
            .background(Color.white)
            .cornerRadius(20.0)
            .shadow(radius: 10.0, x: 20, y: 10)
            .autocapitalization(.none)
    }
}

struct ConfPasswordTextField : View {
    @Binding var confPassword: String
    var body: some View {
        SecureField("Confirm password", text: $confPassword)
            .padding()
            .background(Color.white)
            .cornerRadius(20.0)
            .shadow(radius: 10.0, x: 20, y: 10)
            .autocapitalization(.none)
    }
}

struct LoginButtonContent : View {
    var body: some View {
        Text("Login")
            .font(.headline)
            .foregroundColor(.white)
            .padding()
            .frame(width: 300, height: 50)
            .background(Color.green)
            .cornerRadius(15.0)
            .shadow(radius: 10.0, x: 20, y: 10)
    }
}

struct SignUpButtonContent : View {
    var body: some View {
        Text("Sign Up")
            .font(.headline)
            .foregroundColor(.white)
            .padding()
            .frame(width: 300, height: 50)
            .background(Color.green)
            .cornerRadius(15.0)
            .shadow(radius: 10.0, x: 20, y: 10)
    }
}

//struct Login2_Previews: PreviewProvider {
//    static var previews: some View {
//        LoginView()
//    }
//}
