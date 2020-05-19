<div class="limiter container">
    <br /><br />
    <h1 class="text-center bg-info">Manage Courses</h1>
    <br />
    <div class="row container-row100">
        <!-- Insertion Column -->
        <div class="col-sm-4">
            <div class="wrap-col100">
                <form class="login100-form validate-form" method="post" action="/student_course">
                    {{ csrf_field() }}
                    <span class="col100-form-title p-b-26">
                        Assign Courses to Students
                    </span>
                    <div class="form-group">
                        <label for="stdCourse">Select Course:</label>
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
                                <option value="{{$students[$i]->getUid()}}">{{$students[$i]->getFirstName()}} {{$students[$i]->getLastName()}}</option>
                            @endfor
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
        <div class="col-sm-8">
            <h2>Students &amp; Courses</h2>
            <table class="table table-dark">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Courses</th>
                </tr>
                </thead>
                <tbody>
                @for($i=0; $i<count($students); $i++)
                    <tr>
                        <td>{{ $students[$i]->getUserName() }}</td>
                        <td>{{ $students[$i]->getFirstName() }}</td>
                        <td>{{ $students[$i]->getLastName() }}</td>
                        <td>
                            @foreach($students[$i]->getCourses() as $key => $course)
                                {{ $key}} <br />
                            @endforeach
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>

    <!-- Manage Courses for the Teachers -->
    <br />
    <hr />
    <br />
    <div class="row container-row100">
        <!-- Insertion Column -->
        <div class="col-sm-4">
            <div class="wrap-col100">
                <form class="login100-form validate-form" method="post" action="/tutor_course">
                    {{ csrf_field() }}
                    <span class="col100-form-title p-b-26">
                        Assign Courses To Tutors
                    </span>
                    <div class="form-group">
                        <label for="tutorCourse">Select Course:</label>
                        <select class="form-control" id="tutorCourse"  required="required" name="tutorCourse">
                            @for($i=0; $i<count($courses); $i++)
                                <option value="{{$courses[$i]->getCode()}}">{{$courses[$i]->getTitle()}}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tutorUserName">Select Tutor:</label>
                        <select class="form-control" id="tutorUserName"  required="required" name="tutorUserName">
                            @for($i=0; $i<count($tutors); $i++)
                                <option value="{{$tutors[$i]->getUid()}}">{{$tutors[$i]->getFirstName()}} {{$tutors[$i]->getLastName()}}</option>
                            @endfor
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
        <div class="col-sm-8">
            <h2>Tutors &amp; Courses</h2>
            <table class="table table-dark">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Courses</th>
                </tr>
                </thead>
                <tbody>
                @for($i=0; $i<count($tutors); $i++)
                    <tr>
                        <td>{{ $tutors[$i]->getUserName() }}</td>
                        <td>{{ $tutors[$i]->getFirstName() }}</td>
                        <td>{{ $tutors[$i]->getLastName() }}</td>
                        <td>
                            @foreach($tutors[$i]->getCourses() as $key => $course)
                                {{ $key}} <br />
                            @endforeach
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
