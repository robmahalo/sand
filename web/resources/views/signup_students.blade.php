@extends('layouts.app')
@section('content')
    <div class="container-login100">
        <div class="wrap-login100">
            <form class="login100-form validate-form">
                <span class="login100-form-title p-b-26">
                    Register
                </span>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="username" class="input100" type="text" name="Username">
                    <span class="focus-input100" data-placeholder="Username"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Enter password">
                    <span class="btn-show-pass">
                        <i class="zmdi zmdi-eye"></i>
                    </span>
                    <input id="password" class="input100" type="password" name="pass">
                    <span class="focus-input100" data-placeholder="Password"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="firstname" class="input100" type="text" name="FirstName">
                    <span class="focus-input100" data-placeholder="First Name"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="lastname" class="input100" type="text" name="LastName">
                    <span class="focus-input100" data-placeholder="Last Name"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="email" class="input100" type="text" name="Email">
                    <span class="focus-input100" data-placeholder="Email"></span>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button id="sign-up" class="login100-form-btn">
                          Register
                        </button>
                    </div>
                </div>

                <div class="text-center p-t-115">
                    <span class="txt1">
                        Already have an account?
                    </span>

                    <button id="login" class="txt2" onclick="window.location='{{ url("/") }}'">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var isSignUpInProgress = false;
        firebase.auth().onAuthStateChanged(function(user) {
            if(user) {
                 console.log('User is signed in');
                if(!isSignUpInProgress) {
                    redirectToHome();
                }
            }
            else {
                console.log('User is logged out');
            }
        });
    </script>
    <script>
        document.querySelector('#sign-up').addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var email = document.querySelector('#email').value;
            var password = document.querySelector('#password').value;
            isSignUpInProgress = true;
            firebase.auth().createUserWithEmailAndPassword(email, password)
            .then(() => {
                console.log('Account created successfully');
                onSignUp();
            })
            .catch((error) => {
                isSignUpInProgress = false;
                // Handle Errors here.
                var errorCode = error.code;
                var errorMessage = error.message;
                alert(errorMessage);
                // ...
            });
        });
    </script>
    <script>
        function onSignUp() {
            ///Save user data
            var username = document.querySelector('#username').value;
            var password = document.querySelector('#password').value;
            var firstName = document.querySelector('#firstname').value;
            var lastName = document.querySelector('#lastname').value;
            var email = document.querySelector('#email').value;

            firebase.auth().currentUser.getIdToken().then((idToken) => {
                // Pass the ID token to the server along with data
                $.post(
                    '/create-student',
                    {
                        idToken: idToken,
                        username: username,
                        password: password,
                        firstName: firstName,
                        lastName: lastName,
                        email: email
                    },
                    (data, status) => {
                        if (status == 'success' && data) {
                            // const json = JSON.parse(data);
                            // if (json && json.status == 'success') {
                            //     // Force token refresh. The token claims will contain the additional claims.
                            //     firebase.auth().currentUser.getIdToken(true);
                            // }
                            console.log("Students saved successfully");
                        }
                        else {
                            console.log("Error saving student");
                        }
                        redirectToHome();
                    });

            }).catch((error) => {
                console.log(error);
                firebase.auth().signOut();
                window.location = "/";
            });
        }
    </script>
@endsection
