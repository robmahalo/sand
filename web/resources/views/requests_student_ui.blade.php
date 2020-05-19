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
                                <label for="tutorUserName">Select Tutor:</label>
                                <select class="form-control" id="tutorUserName"  required="required" name="tutorUserName"  onchange="ontutorChanged()">
                                    {{-- @for($i=0; $i<count($tutors); $i++)
                                        <option value="{{$tutors[$i]->getUserName()}}">{{$tutors[$i]->getFirstName()}} {{$tutors[$i]->getLastName()}}</option>
                                    @endfor --}}
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="select-label" for="stdCourse">Select Course:</label>
                                <select class="form-control" id="stdCourse"  required="required" name="stdCourse">
                                    {{-- @if ($tutors[0]->getCourses() && $tutors[0]->getCourses()->count > 0)
                                        @for($i=0; $i<count($courses); $i++)
                                            @if ($courses[$i]->getCode() == ($tutors[0]->getCourses())[0])
                                                <option value="{{$courses[$i]->getCode()}}">{{$courses[$i]->getTitle()}}</option>
                                            @endif
                                        @endfor
                                    @endif --}}

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="beginTime">Class Beginning Time:</label>
                                <select class="form-control" id="beginTime"  required="required" name="beginTime">
                                    {{-- <option value="{{ $tutors[0]->getClassTimeBegin() }}">{{ $tutors[0]->getClassTimeBegin() }}</option> --}}
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
                <h2>Classes</h2>
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Class Time</th>
                        <th>Course</th>
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
                            <td>{{ $tutors[$i]->getClassTime() }}</td>
                            <td>
                                @foreach($tutors[$i]->getCourses() as $key => $course)
                                    {{ $course }} <br/>
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
    <input id="tutorsData" type="hidden" value="{{ json_encode($tutorsData) }}">
</div>

<script>
    var tutorsData = JSON.parse(document.querySelector("#tutorsData").value);
    onTutorsFetched();

    function onTutorsFetched() {
        var tutorsEl = document.querySelector('#tutorUserName');
        tutorsData.forEach(tutor => {
            var option = document.createElement('option');
            option.value = tutor.username;
            option.innerHTML = tutor.firstName + " " + tutor.lastName;
            tutorsEl.appendChild(option);
        });

        var tutor = tutorsData[0];
        updateCourseForTutor(tutor);
        UpdateClassBeginTimeForTutor(tutor);
    }

    function getTutorByUsername(username) {
        for (let index = 0; index < tutorsData.length; index++) {
            const tutor = tutorsData[index];
            if(tutor.username == username) return tutor;
        }
    }

    function removeOptionsFromSelect(selectEl) {
        var optionsCount = selectEl.options.length;
        for(var index = 0; index < optionsCount; index++) {
            selectEl.remove(index);
        }
    }

    function updateCourseForTutor(tutor) {
        var coursesEl = document.querySelector('#stdCourse');
        removeOptionsFromSelect(coursesEl);
        var courses = tutor.courses;
        for (const code in courses) {
            if (courses.hasOwnProperty(code)) {
                const title = courses[code];
                var option = document.createElement('option');
                option.value = code;
                option.innerHTML = title;
                coursesEl.appendChild(option);
            }
        }
    }

    function UpdateClassBeginTimeForTutor(tutor) {
        var beginTimeEl = document.querySelector('#beginTime');
        removeOptionsFromSelect(beginTimeEl);
        var option = document.createElement('option');
        option.value = tutor.classTimeBegin;
        option.innerHTML = tutor.classTimeBegin;
        beginTimeEl.appendChild(option);
    }

    function ontutorChanged() {
        var username = document.querySelector('#tutorUserName').value;
        var tutor = getTutorByUsername(username);
        updateCourseForTutor(tutor);
        UpdateClassBeginTimeForTutor(tutor);
    }
</script>
