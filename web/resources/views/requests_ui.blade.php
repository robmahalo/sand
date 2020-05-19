<div class="limiter">
    <div class="col-md-10 offset-sm-1">
        <br/><br/>
        <h1 class="text-center bg-info">Place Requests</h1>
        <div class="row container-row100">
            <!-- Insertion Column -->
                <div class="col-md-4">
                    <div class="wrap-col100">
                        <form class="login100-form validate-form" method="post" action="/requests">
                            {{ csrf_field() }}
                            <span class="col100-form-title p-b-26">
                                Place new Request
                            </span>
                            <div class="form-group">
                                <label class="select-label" for="stdCourse">Select Course:</label>
                                <select class="form-control" id="stdCourse"  required="required" name="stdCourse">
                                    @for($i=0; $i<count($courses); $i++)
                                        <option value="{{$courses[$i]->getCode()}}">{{$courses[$i]->getTitle()}}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="stdUserName">Select Student:</label>
                                <select class="form-control" id="stdUserName"  required="required" name="stdUserName">
                                    @for($i=0; $i<count($students); $i++)
                                        <option value="{{$students[$i]->getUserName()}}">{{$students[$i]->getFirstName()}} {{$students[$i]->getLastName()}}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tutorUserName">Select Tutor:</label>
                                <select class="form-control" id="tutorUserName"  required="required" name="tutorUserName">
                                    @for($i=0; $i<count($tutors); $i++)
                                        <option value="{{$tutors[$i]->getUserName()}}">{{$tutors[$i]->getFirstName()}} {{$tutors[$i]->getLastName()}}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="block">Time Needed:</label>
                                <select class="form-control" id="block"  required="required" name="block">
                                    <option value="30 Minutes">30 Minutes</option>
                                    <option value="60 Minutes">60 Minutes</option>
                                    <option value="120 Minutes">120 Minutes</option>
                                    <option value="180 Minutes">180 Minutes</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="slot">Time Slot:</label>
                                <select class="form-control" id="slot"  required="required" name="slot">
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
                <h2>Existing Requests</h2>
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th>Student</th>
                        <th>Tutor</th>
                        <th>Time Needed</th>
                        <th>Course</th>
                        <th>Time Slot</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i=0; $i<count($requests); $i++)
                    <tr>
                        <td>{{ $requests[$i]->getStudentUserName() }}</td>
                        <td>{{ $requests[$i]->getTutorUserName() }}</td>
                        <td>{{ $requests[$i]->getBlock() }}</td>
                        <td>{{ $requests[$i]->getCourse() }}</td>
                        <td>{{ $requests[$i]->getSlot() }} <br/>
                        </td>
                    </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
