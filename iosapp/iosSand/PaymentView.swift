//
//  PaymentView.swift
//  iosSand
//
//  Created by Robert Manalo on 3/28/20.
//  Copyright © 2020 Madison Gipson. All rights reserved.
//

import SwiftUI

struct PaymentView: View {
    var body: some View {
        ZStack {
            Color.white
            Form {
                Spacer()
                Button(action: {
                    let link = "https://venmo.com/account/sign-in"
                    let formattedString = link
                    guard let url = URL(string: formattedString) else { return }
                    UIApplication.shared.open(url)
                }) {
                    Text("Venmo")
                    .font(.system(size: 40, weight: .thin, design: .default))
                    .foregroundColor(Color.yellow)
                }
                Button(action: {
                    let link = "https://www.paypal.com/us/signin"
                    let formattedString = link
                    guard let url = URL(string: formattedString) else { return }
                    UIApplication.shared.open(url)
                }) {
                    Text("Paypal")
                    .font(.system(size: 40, weight: .thin, design: .default))
                    .foregroundColor(Color.yellow)
                }
            }.navigationBarTitle("Payments", displayMode:.inline)
                .navigationBarItems(trailing:
                    HStack(spacing:15) {
                        Image(systemName: "creditcard.fill")
                    }
            )
            
        }.edgesIgnoringSafeArea(.all)
    }
}

//    func showDropIn(clientTokenOrTokenizationKey: String) {
//        let request =  BTDropInRequest()
//        let dropIn = BTDropInController(authorization: clientTokenOrTokenizationKey, request: request)
//        { (controller, result, error) in
//            if (error != nil) {
//                print("ERROR")
//            } else if (result?.isCancelled == true) {
//                print("CANCELLED")
//            } else if let result = result {
//                // Use the BTDropInResult properties to update your UI
//                let selectedPaymentOptionType = result.paymentOptionType
//                let selectedPaymentMethod = result.paymentMethod
//                let selectedPaymentMethodIcon = result.paymentIcon
//                let selectedPaymentMethodDescription = result.paymentDescription
//            }
//            controller.dismiss(animated: true, completion: nil)
//        }
//        .present(dropIn!, animated: true, completion: nil)
//    }

struct PaymentView_Previews: PreviewProvider {
    static var previews: some View {
        PaymentView()
    }
}
