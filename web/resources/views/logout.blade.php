@extends('layouts.app')
@section('content')

    <script>
        firebase.auth().onAuthStateChanged(function(user) {
            if(user) {
                 console.log('User is signed in');
                 onUserLoggedIn();
            }
            else {
                console.log('User is logged out');
                redirectToLogin();
            }
        });
    </script>
    <script>
        function onUserLoggedIn() {
            ///log user out
            firebase.auth().signOut().then(() => {
                // Sign-out successful.
            }).catch((error) => {
                // An error happened.
                var errorCode = error.code;
                var errorMessage = error.message;
                alert(errorMessage);
            });
        }
    </script>
@endsection
