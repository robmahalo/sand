    <div class="container-login100">
        <div class="wrap-login100">
            <form class="login100-form validate-form">
                <span class="login100-form-title p-b-26">
                    Edit Profile
                </span>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="username" class="input100 has-val" type="text" name="Username" value="{{ $tutor->getUserName() }}">
                    <span class="focus-input100" data-placeholder="Username"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="firstname" class="input100 has-val" type="text" name="FirstName" value="{{ $tutor->getFirstName() }}">
                    <span class="focus-input100" data-placeholder="First Name"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="lastname" class="input100 has-val" type="text" name="LastName" value="{{ $tutor->getLastName() }}">
                    <span class="focus-input100" data-placeholder="Last Name"></span>
                </div>

                <div  class="validate-input" data-validate = "">
                    <select class="form-control" id="classTimeBegin"  required="required" name="classTimeBegin">
                        <option value="">Class Time Begin:</option>
                        <option value="08:00" {{ $tutor->getClassTimeBegin() == "08:00" ? "selected='selected'" : "" }}>08:00</option>
                        <option value="08:30" {{ $tutor->getClassTimeBegin() == "08:30" ? "selected='selected'" : "" }}>08:30</option>
                        <option value="09:00" {{ $tutor->getClassTimeBegin() == "09:00" ? "selected='selected'" : "" }}>09:00</option>
                        <option value="09:30" {{ $tutor->getClassTimeBegin() == "09:30" ? "selected='selected'" : "" }}>09:30</option>
                        <option value="10:00" {{ $tutor->getClassTimeBegin() == "10:00" ? "selected='selected'" : "" }}>10:00</option>
                        <option value="10:30" {{ $tutor->getClassTimeBegin() == "10:30" ? "selected='selected'" : "" }}>10:30</option>
                        <option value="11:00" {{ $tutor->getClassTimeBegin() == "11:00" ? "selected='selected'" : "" }}>11:00</option>
                        <option value="11:30" {{ $tutor->getClassTimeBegin() == "11:30" ? "selected='selected'" : "" }}>11:30</option>
                        <option value="12:00" {{ $tutor->getClassTimeBegin() == "12:00" ? "selected='selected'" : "" }}>12:00</option>
                        <option value="12:30" {{ $tutor->getClassTimeBegin() == "12:30" ? "selected='selected'" : "" }}>12:30</option>
                        <option value="13:00" {{ $tutor->getClassTimeBegin() == "13:00" ? "selected='selected'" : "" }}>13:00</option>
                        <option value="13:30" {{ $tutor->getClassTimeBegin() == "13:30" ? "selected='selected'" : "" }}>13:30</option>
                        <option value="14:00" {{ $tutor->getClassTimeBegin() == "14:00" ? "selected='selected'" : "" }}>14:00</option>
                        <option value="14:30" {{ $tutor->getClassTimeBegin() == "14:30" ? "selected='selected'" : "" }}>14:30</option>
                        <option value="15:00" {{ $tutor->getClassTimeBegin() == "15:00" ? "selected='selected'" : "" }}>15:00</option>
                        <option value="15:30" {{ $tutor->getClassTimeBegin() == "15:30" ? "selected='selected'" : "" }}>15:30</option>
                        <option value="16:00" {{ $tutor->getClassTimeBegin() == "16:00" ? "selected='selected'" : "" }}>16:00</option>
                        <option value="16:30" {{ $tutor->getClassTimeBegin() == "16:30" ? "selected='selected'" : "" }}>16:30</option>
                        <option value="17:00" {{ $tutor->getClassTimeBegin() == "17:00" ? "selected='selected'" : "" }}>17:00</option>
                        <option value="17:30" {{ $tutor->getClassTimeBegin() == "17:30" ? "selected='selected'" : "" }}>17:30</option>
                        <option value="18:00" {{ $tutor->getClassTimeBegin() == "18:00" ? "selected='selected'" : "" }}>18:00</option>
                        <option value="18:30" {{ $tutor->getClassTimeBegin() == "18:30" ? "selected='selected'" : "" }}>18:30</option>
                    </select>
                </div>
                <br>
                <div  class="validate-input" data-validate = "">
                    <select class="form-control" id="classTimeEnd"  required="required" name="classTimeEnd">
                        <option value="">Class Time End:</option>
                        <option value="08:00" {{ $tutor->getClassTimeEnd() == "08:00" ? "selected='selected'" : "" }}>08:00</option>
                        <option value="08:30" {{ $tutor->getClassTimeEnd() == "08:30" ? "selected='selected'" : "" }}>08:30</option>
                        <option value="09:00" {{ $tutor->getClassTimeEnd() == "09:00" ? "selected='selected'" : "" }}>09:00</option>
                        <option value="09:30" {{ $tutor->getClassTimeEnd() == "09:30" ? "selected='selected'" : "" }}>09:30</option>
                        <option value="10:00" {{ $tutor->getClassTimeEnd() == "10:00" ? "selected='selected'" : "" }}>10:00</option>
                        <option value="10:30" {{ $tutor->getClassTimeEnd() == "10:30" ? "selected='selected'" : "" }}>10:30</option>
                        <option value="11:00" {{ $tutor->getClassTimeEnd() == "11:00" ? "selected='selected'" : "" }}>11:00</option>
                        <option value="11:30" {{ $tutor->getClassTimeEnd() == "11:30" ? "selected='selected'" : "" }}>11:30</option>
                        <option value="12:00" {{ $tutor->getClassTimeEnd() == "12:00" ? "selected='selected'" : "" }}>12:00</option>
                        <option value="12:30" {{ $tutor->getClassTimeEnd() == "12:30" ? "selected='selected'" : "" }}>12:30</option>
                        <option value="13:00" {{ $tutor->getClassTimeEnd() == "13:00" ? "selected='selected'" : "" }}>13:00</option>
                        <option value="13:30" {{ $tutor->getClassTimeEnd() == "13:30" ? "selected='selected'" : "" }}>13:30</option>
                        <option value="14:00" {{ $tutor->getClassTimeEnd() == "14:00" ? "selected='selected'" : "" }}>14:00</option>
                        <option value="14:30" {{ $tutor->getClassTimeEnd() == "14:30" ? "selected='selected'" : "" }}>14:30</option>
                        <option value="15:00" {{ $tutor->getClassTimeEnd() == "15:00" ? "selected='selected'" : "" }}>15:00</option>
                        <option value="15:30" {{ $tutor->getClassTimeEnd() == "15:30" ? "selected='selected'" : "" }}>15:30</option>
                        <option value="16:00" {{ $tutor->getClassTimeEnd() == "16:00" ? "selected='selected'" : "" }}>16:00</option>
                        <option value="16:30" {{ $tutor->getClassTimeEnd() == "16:30" ? "selected='selected'" : "" }}>16:30</option>
                        <option value="17:00" {{ $tutor->getClassTimeEnd() == "17:00" ? "selected='selected'" : "" }}>17:00</option>
                        <option value="17:30" {{ $tutor->getClassTimeEnd() == "17:30" ? "selected='selected'" : "" }}>17:30</option>
                        <option value="18:00" {{ $tutor->getClassTimeEnd() == "18:00" ? "selected='selected'" : "" }}>18:00</option>
                        <option value="18:30" {{ $tutor->getClassTimeEnd() == "18:30" ? "selected='selected'" : "" }}>18:30</option>
                    </select>
                </div>
                <br>
                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="streetAddress" class="input100 has-val" type="text" name="streetAddress" value="{{ $tutor->getLocation()->getStreetAddress() }}">
                    <span class="focus-input100" data-placeholder="Enter Street Address"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="city" class="input100 has-val" type="text" name="city" value="{{ $tutor->getLocation()->getCity() }}">
                    <span class="focus-input100" data-placeholder="Enter City"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="state" class="input100 has-val" type="text" name="state" value="{{ $tutor->getLocation()->getState() }}">
                    <span class="focus-input100" data-placeholder="Enter State"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="zipCode" class="input100 has-val" type="text" name="zipCode" value="{{ $tutor->getLocation()->getZipCode() }}">
                    <span class="focus-input100" data-placeholder="Enter ZipCode"></span>
                </div>
                <div class="validate-input" data-validate = "">
                    <select class="form-control" id="course"  required="required" name="course" onchange="onSelectCourseChanged()">
                        <option value="">Select Course:</option>
                        @for($i=0; $i<count($courses); $i++)
                            <option value="{{$courses[$i]->getCode()}}" {{ $tutor->getCourses()[0] == $courses[$i]->getCode() ? "selected='selected'" : "" }}>{{$courses[$i]->getTitle()}}</option>
                        @endfor
                        <option value="other">Other</option>
                    </select>
                </div>
                <br>
                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="courseCode" class="input100" type="text" name="courseCode" disabled=true>
                    <span class="focus-input100" data-placeholder="Enter Course"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "">
                    <input id="courseTitle" class="input100" type="text" name="courseTitle" disabled=true>
                    <span class="focus-input100" data-placeholder="Enter Course Title"></span>
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
            var classTimeBegin = document.querySelector('#classTimeBegin').value;
            var classTimeEnd = document.querySelector('#classTimeEnd').value;
            var location = {};
            location.streetAddress = document.querySelector('#streetAddress').value;
            location.city = document.querySelector('#city').value;
            location.state = document.querySelector('#state').value;
            location.zipCode = document.querySelector('#zipCode').value;

            var selectedCourse = document.querySelector("#course").value;
            var otherCourseCode = document.querySelector('#courseCode').value;
            var otherCourseTitle = document.querySelector('#courseTitle').value;

            $.post('/edit-tutor',
            {
                username: username,
                firstName: firstName,
                lastName: lastName,
                classTimeBegin: classTimeBegin,
                classTimeEnd: classTimeEnd,
                location: location,
                selectedCourse: selectedCourse,
                otherCourseCode: otherCourseCode,
                otherCourseTitle: otherCourseTitle
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
        function onSelectCourseChanged() {
            console.log("Select course changed");
            var courseVal = document.querySelector('#course').value;
            if(courseVal == "other") {
                //Enable to add new course
                document.querySelector('#courseCode').disabled = false;
                document.querySelector('#courseTitle').disabled = false;
            }
            else {
                //Disable to add new course
               document.querySelector('#courseCode').disabled = true;
                document.querySelector('#courseTitle').disabled = true;
            }
        }
    </script>
