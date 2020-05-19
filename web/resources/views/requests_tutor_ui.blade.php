<div class="limiter">
    <div class="col-md-10 offset-sm-1">
        <br/><br/>
        <h1 class="text-center bg-info">View Requests</h1>
        <div class="row">
            <!-- Display Column -->
            <div class="col-md-12">
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Class Begin Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i=0; $i<count($requests); $i++)
                    <tr>
                        <td>{{ $requests[$i]->getStudentUserName() }}</td>
                        <td>{{ $requests[$i]->getCourse() }}</td>
                        <td>{{ $requests[$i]->getClassTimeBegin() }} <br/>
                        </td>
                    </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
