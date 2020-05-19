<div class="limiter" role="main">
    <div class="col-md-10 offset-sm-1">
        <br/><br/>
        <h1 class="text-center bg-info">Manage Tutors</h1>
        <div class="row container-row100">
            <!-- Insertion Column -->
            <div class="col-md-4">
                <div class="wrap-col100">
                    <form class="login100-form validate-form" method="post" action="/tutors">
                        {{ csrf_field() }}
                        <span class="col100-form-title p-b-26">
                            Create New Tutor
                        </span>
                        <div class="form-group">
                            <div class="wrap-input100 validate-input" data-validate = "">
                                <input id="userName" class="input100" type="text" name="userName" required="required">
                                <span class="focus-input100" data-placeholder="Username"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="wrap-input100 validate-input" data-validate = "">
                                <input id="firstName" class="input100" type="text" name="firstName" required="required">
                                <span class="focus-input100" data-placeholder="First Name"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="wrap-input100 validate-input" data-validate = "">
                                <input id="lastName" class="input100" type="text" name="lastName" required="required">
                                <span class="focus-input100" data-placeholder="Last Name"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="wrap-input100 validate-input" data-validate="Enter password">
                                <span class="btn-show-pass">
                                    <i class="zmdi zmdi-eye"></i>
                                </span>
                                <input id="pwd" class="input100" type="password" name="password" required="required">
                                <span class="focus-input100" data-placeholder="Password"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="wrap-input100 validate-input" data-validate = "">
                                <input id="email" class="input100" type="text" name="email" required="required">
                                <span class="focus-input100" data-placeholder="Email"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="classTimeBegin">Available From:</label>
                            <select class="form-control" id="classTimeBegin"  required="required" name="classTimeBegin">
                                <option value="08:00">08:00</option>
                                <option value="08:30">08:30</option>
                                <option value="09:00">09:00</option>
                                <option value="09:30">09:30</option>
                                <option value="10:00">10:00</option>
                                <option value="10:30">10:30</option>
                                <option value="11:00">11:00</option>
                                <option value="11:30">11:30</option>
                                <option value="12:00">12:00</option>
                                <option value="12:30">12:30</option>
                                <option value="13:00">13:00</option>
                                <option value="13:30">13:30</option>
                                <option value="14:00">14:00</option>
                                <option value="14:30">14:30</option>
                                <option value="15:00">15:00</option>
                                <option value="15:30">15:30</option>
                                <option value="16:00">16:00</option>
                                <option value="16:30">16:30</option>
                                <option value="17:00">17:00</option>
                                <option value="17:30">17:30</option>
                                <option value="18:00">18:00</option>
                                <option value="18:30">18:30</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="classTimeEnd">Class Time End:</label>
                            <select class="form-control" id="classTimeEnd"  required="required" name="classTimeEnd">
                                <option value="08:00">08:00</option>
                                <option value="08:30">08:30</option>
                                <option value="09:00">09:00</option>
                                <option value="09:30">09:30</option>
                                <option value="10:00">10:00</option>
                                <option value="10:30">10:30</option>
                                <option value="11:00">11:00</option>
                                <option value="11:30">11:30</option>
                                <option value="12:00">12:00</option>
                                <option value="12:30">12:30</option>
                                <option value="13:00">13:00</option>
                                <option value="13:30">13:30</option>
                                <option value="14:00">14:00</option>
                                <option value="14:30">14:30</option>
                                <option value="15:00">15:00</option>
                                <option value="15:30">15:30</option>
                                <option value="16:00">16:00</option>
                                <option value="16:30">16:30</option>
                                <option value="17:00">17:00</option>
                                <option value="17:30">17:30</option>
                                <option value="18:00">18:00</option>
                                <option value="18:30">18:30</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="wrap-input100 validate-input" data-validate = "">
                                <input id="streetAddress" class="input100" type="text" name="streetAddress" required="required">
                                <span class="focus-input100" data-placeholder="Enter Street Address"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="wrap-input100 validate-input" data-validate = "">
                                <input id="city" class="input100" type="text" name="city" required="required">
                                <span class="focus-input100" data-placeholder="Enter City"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="wrap-input100 validate-input" data-validate = "">
                                <input id="state" class="input100" type="text" name="state" required="required">
                                <span class="focus-input100" data-placeholder="Enter State"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="wrap-input100 validate-input" data-validate = "">
                                <input id="zipCode" class="input100" type="text" name="zipCode" required="required">
                                <span class="focus-input100" data-placeholder="Enter ZipCode"></span>
                            </div>
                        </div>

                        <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button type="submit" class="login100-form-btn">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Display Column -->
            <div class="col-md-8">
                <h2>Existing Tutors</h2>
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Availability</th>
                        <th>Courses</th>
                        <th>Location</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i=0; $i<count($tutors); $i++)
                        <tr>
                            <td>{{ $tutors[$i]->getUserName() }}</td>
                            <td>{{ $tutors[$i]->getFirstName() }}</td>
                            <td>{{ $tutors[$i]->getLastName() }}</td>
                            <td>{{ $tutors[$i]->getEmail() }}</td>
                            <td>{{ $tutors[$i]->getAvailability() }}</td>
                            <td>
                                @foreach($tutors[$i]->getCourses() as $key => $course)
                                    {{ $key}} <br/>
                                @endforeach
                            </td>
                            <td>
                                {{$tutors[$i]->getLocation()->getStreetAddress()}} <br/>
                                {{$tutors[$i]->getLocation()->getCity()}},
                                {{$tutors[$i]->getLocation()->getState()}} {{$tutors[$i]->getLocation()->getZipCode()}}
                                <br/><br/><br/>
                            </td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
