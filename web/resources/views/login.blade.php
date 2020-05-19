@extends('layouts.app')
@section('content')
    <div class="container-login100">
        <div class="wrap-login100">
                <span class="login100-form-title p-b-26">
                    Login
                </span>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="email" class="input100" type="text" name="Email">
                    <span class="focus-input100" data-placeholder="Email"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Enter password">
                    <span class="btn-show-pass">
                        <i class="zmdi zmdi-eye"></i>
                    </span>
                    <input id="password" class="input100" type="password" name="pass">
                    <span class="focus-input100" data-placeholder="Password"></span>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button id="login" class="login100-form-btn">
                            Login
                        </button>
                    </div>
                </div>

                <div class="text-center p-t-115">
                    <span class="txt1">
                        Don’t have an account? Register as a
                    </span>

                    <button id="sign-up-student" class="txt2" onclick="window.location='{{ url("sand-signup-student") }}'">Student</button>
                    <span class="txt1">
                        or
                    </span>
                    <button id="sign-up-tutor" class="txt2" onclick="window.location='{{ url("sand-signup-tutor") }}'">Tutor</button>
                </div>
        </div>
    </div>

    <script>
        firebase.auth().onAuthStateChanged(function(user) {
            if(user) {
                 console.log('User is signed in');
                redirectToHome();
            }
            else {
                console.log('User is logged out');
            }
        });
    </script>
    <script>
        document.querySelector('#login').addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var email = document.querySelector('#email').value;
            var password = document.querySelector('#password').value
            firebase.auth().signInWithEmailAndPassword(email, password).catch((error) => {
                // Handle Errors here.
                var errorCode = error.code;
                var errorMessage = error.message;
                alert(errorMessage);
            });
        });
    </script>
@endsection
