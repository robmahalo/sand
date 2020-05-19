<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Firebase Auth</title>

	    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('fonts/iconic/css/material-design-iconic-font.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animsition/css/animsition.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/select2.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/menu.css') }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </head>
    <body>
        <form style="display: none" action="/dashboard" method="POST" id="form-token">
            @csrf
            <input type="hidden" id="id-token" name="idToken" value=""/>
        </form>
        <!-- The core Firebase JS SDK is always required and must be listed first -->
        <script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-auth.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-database.js"></script>

        <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyAPHf5qXXEv5O57-oZ1QB2BxsVuDgqhlVM",
            authDomain: "myapp-269a9.firebaseapp.com",
            databaseURL: "https://myapp-269a9.firebaseio.com",
            projectId: "myapp-269a9",
            storageBucket: "myapp-269a9.appspot.com",
            messagingSenderId: "54475671054",
            appId: "1:54475671054:web:61608052b0fc9cb1f35e5f"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        </script>
        <script>
            function isUserLoggedIn() {
                return firebase.auth().currentUser != null;
            }

            function redirectToHome() {
                // $.get('/dashboard',
                // {
                //     idToken: 123
                // },
                // (data, status) => {
                //     // This is not required. You could just wait until the token is expired
                //     // and it proactively refreshes.
                //     if (status == 'success' && data) {
                //         const json = JSON.parse(data);
                //         if (json && json.status == 'success') {
                //         // Force token refresh. The token claims will contain the additional claims.
                //         firebase.auth().currentUser.getIdToken(true);
                //         }
                //     }
                // }

                // );
                firebase.auth().currentUser.getIdToken().then((idToken) => {
                    // Pass the ID token to the server.
                    document.querySelector('#id-token').value = idToken;
                    document.querySelector('#form-token').submit();
                    //window.location = "dashboard/"+idToken;
                }).catch((error) => {
                    console.log(error);
                    firebase.auth().signOut();
                    window.location = "/";
                });
            }

            function redirectToLogin() {
                window.location = "/";
            }

            (function () {
                firebase.database().ref("courses").once("value",snapshot => {
                    if (snapshot.exists()){
                        console.log("courses already exist!");
                        return;
                    }
                    firebase.database().ref("courses").set({
                        "Math101": {
                            "title": "Math 101"
                        },
                        "CS101": {
                            "title": "Introduction to Computing"
                        },
                        "CS102": {
                            "title": "Introduction to Programming"
                        }
                    }, (error) => {

                        if(error) {
                            console.log("Error saving courses data:"+error.message);
                        }
                        else{
                            console.log("courses data saved successfully");
                        }
                    });
                });
            }());
        </script>
        <div class="limiter">
            @yield('content')
        </div>

        <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	    <script src="{{ asset('js/main.js') }}"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    </body>
</html>
