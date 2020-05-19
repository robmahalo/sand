    <div class="container-login100">
        <div class="wrap-login100">
            <form class="login100-form validate-form">
                <span class="login100-form-title p-b-26">
                    Edit Profile
                </span>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="username" class="input100 has-val" type="text" name="Username" value="{{ $student->getUserName() }}">
                    <span class="focus-input100" data-placeholder="Username"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="firstname" class="input100 has-val" type="text" name="FirstName" value="{{ $student->getFirstName() }}">
                    <span class="focus-input100" data-placeholder="First Name"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="lastname" class="input100 has-val" type="text" name="LastName" value="{{ $student->getLastName() }}">
                    <span class="focus-input100" data-placeholder="Last Name"></span>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button id="update" class="login100-form-btn">
                          Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.querySelector('#update').addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            ///Save user data
            var username = document.querySelector('#username').value;
            var firstName = document.querySelector('#firstname').value;
            var lastName = document.querySelector('#lastname').value;

            $.post('/edit-student',
            {
                username: username,
                firstName: firstName,
                lastName: lastName
            },
            (data, status) => {
                if (status == 'success' && data) {
                    // const json = JSON.parse(data);
                    // if (json && json.status == 'success') {
                    //     // Force token refresh. The token claims will contain the additional claims.
                    //     firebase.auth().currentUser.getIdToken(true);
                    // }
                    console.log("Profile updated successfully");
                }
                else {
                    console.log("Error updating profile");
                }
                redirectToProfile();
            });
        });

        function redirectToProfile() {
            window.location = "/sand-profile";
        }
    </script>
