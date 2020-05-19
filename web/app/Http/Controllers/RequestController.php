<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Database\Snapshot;
use Kreait\Firebase\Factory;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session()->has("role") == false || session()->has("id") == false) {
            return view('logout');
        }
        $role = session()->get("role");
        $id = session()->get("id");
        if(Roles::isAdmin($role)) {
            return view("requests")->with("students", $this->getAllStudents())
            ->with("courses", $this->getAllCourses())
            ->with("tutors", $this->getAllTutors())
            ->with("requests", $this->getAllRequests())
            ->with("role",$role);
        }
        else if(Roles::isStudent($role)) {
            $allCourses = $this->getAllCourses();
            $tutors = $this->getAllTutors();
            return view("requests_student")
            ->with("courses", $allCourses)
            ->with("tutors", $tutors)
            ->with("tutorsData",$this->getTutorsDataUsingCourses($allCourses, $tutors))
            ->with("role",$role);
        }
        else if(Roles::isTutor($role)) {
            return view("requests_tutor")
            ->with("requests", $this->getRequestsForTutor($id))
            ->with("role",$role);
        }
        $error = [
            "Access Denied",
            "You are not authorized to view this page"
        ];
        return view('error')->with("error",$error);
    }

    public function getSchedule() {
        if(session()->has("role") == false || session()->has("id") == false) {
            return view('logout');
        }
        $role = session()->get("role");
        $id = session()->get("id");
        if(Roles::isStudent($role)) {
            return view("schedule")
            ->with("requests", $this->getRequestsForStudent($id))
            ->with("role",$role);
        }
        $error = [
            "Access Denied",
            "You are not authorized to view this page"
        ];
        return view('error')->with("error",$error);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(session()->has("role") == false || session()->has("id") == false) {
            return view('logout');
        }
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $requestData = [
            "course" => request('stdCourse'),
            "classBeginTime" => request('beginTime'),
            "tutor" => request('tutorUserName')
        ];
        $role = session()->get("role");
        if(Roles::isStudent($role)) {
            $id = session()->get("id");
            $student = $this->getStudentProfile($id);
            $requestData["student"] = $student->getUserName();
        }
        else {
            $requestData["student"] = request('stdUserName');
        }

        $ref = $database->getReference("requests");

        $key = $ref->push()->getKey();

        $ref->getChild($key)->set($requestData);

        return $this->index();
    }

    public function getAllRequests() {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $uid = 0;
        $ref = $database->getReference("requests");
        $keys = $ref->getChildKeys();

        $data = array();

        foreach($keys as $key) {
            $obj = $ref->getChild($key)->getValue();

            $req = new TutoringRequest();
            $req->setCode($key);
            $req->setCourse($obj['course']);
            $req->setStudentUserName($obj['student']);
            $req->setTutorUserName($obj['tutor']);
            $req->setSlot($obj['slot']);
            $req->setBlock($obj['block']);
            array_push($data, $req);
        }

        return $data;
    }

    public function getAllCourses() {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $uid = 0;
        $ref = $database->getReference("courses");
        $keys = $ref->getChildKeys();

        $data = array();

        foreach($keys as $key) {
            $obj = $ref->getChild($key)->getValue();

            $course = new Course();
            $course->setCode($key);
            $course->setTitle($obj['title']);
            array_push($data, $course);
        }

        return $data;
    }

    public function getAllStudents() {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $uid = 0;
        $ref = $database->getReference("students");
        $keys = $ref->getChildKeys();

        $data = array();

        foreach($keys as $key) {
            $obj = $ref->getChild($key)->getValue();

            $std = new Student();
            $std->setUid($key);
            $std->setUserName($obj['userName']);
            $std->setFirstName($obj['firstName']);
            $std->setLastName($obj['lastName']);
            $std->setEmail($obj['email']);
            $std->setPassword($obj['password']);

            if($ref->getChild($key)->getSnapshot()->hasChild("courses")) {
                $std->setCourses($obj['courses']);
            } else {
                $std->setCourses(array());
            }

            array_push($data, $std);
        }

        return $data;
    }

    public function getAllTutors() {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $uid = 0;
        $ref = $database->getReference("tutors");
        $keys = $ref->getChildKeys();

        $data = array();

        foreach($keys as $key) {
            $tutorSnap = $ref->getChild($key)->getSnapshot();
            $tutor = $this->getTutorFromSnapshot($tutorSnap);
            array_push($data, $tutor);
        }

        return $data;
    }

    private function getTutorFromSnapshot(Snapshot $tutorSnap): Tutor {
            $id = $tutorSnap->getkey();
            $obj = $tutorSnap->getValue();
            $tutor = new Tutor();
            $tutor->setUid($id);
            $tutor->setUserName($obj['userName']);
            $tutor->setFirstName($obj['firstName']);
            $tutor->setLastName($obj['lastName']);
            $tutor->setEmail($obj['email']);
            $tutor->setPassword($obj['password']);
            if($tutorSnap->hasChild("rating")) {
                $tutor->setRating($obj['rating']);
            }
            if($tutorSnap->hasChild("classTimeBegin")) {
                $tutor->setClassTimeBegin($obj['classTimeBegin']);
            }
            if($tutorSnap->hasChild("classTimeEnd")) {
                $tutor->setClassTimeEnd($obj['classTimeEnd']);
            }

            $location = new Location();
            $loc = $obj['location'];
            $location->setStreetAddress($loc['streetAddress']);
            $location->setCity($loc['city']);
            $location->setState($loc['state']);
            $location->setZipCode($loc['zipCode']);
            $tutor->setLocation($location);


            if($tutorSnap->hasChild("courses")) {
                $tutor->setCourses($obj['courses']);
            } else {
                $tutor->setCourses(array());
            }
        return $tutor;
    }

    public function getTutorProfile($id): Tutor {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $ref = $database->getReference("tutors/$id");
        $profileSnap = $ref->getSnapshot();
        if($profileSnap->exists() == false) {
            $error = [
                "Access Denied",
                "You are not authorized to view this page"
            ];
            return view('error')->with("error",$error);
        }
        return $this->getTutorFromSnapshot($profileSnap);
    }

    public function getRequestsForTutor($id) {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $tutor = $this->getTutorProfile($id);
        $ref = $database->getReference("requests")
                        ->orderByChild("tutor")
                        ->equalTo($tutor->getUserName());
        $requests = $ref->getSnapshot()->getValue();

        $data = array();

        foreach($requests as $request) {
            $obj = $request;
            $req = new TutoringRequest();
            $req->setCourse($obj['course']);
            $req->setStudentUserName($obj['student']);
            $req->setTutorUserName($obj['tutor']);
            $req->setClassTimeBegin($obj['classBeginTime']);
            array_push($data, $req);
        }

        return $data;
    }

    public function getRequestsForStudent($id) {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $student = $this->getStudentProfile($id);
        $ref = $database->getReference("requests")
                        ->orderByChild("student")
                        ->equalTo($student->getUserName());
        $requests = $ref->getSnapshot()->getValue();

        $data = array();

        foreach($requests as $request) {
            $obj = $request;
            $req = new TutoringRequest();
            $req->setCourse($obj['course']);
            $req->setStudentUserName($obj['student']);
            $req->setTutorUserName($obj['tutor']);
            $req->setClassTimeBegin($obj['classBeginTime']);
            array_push($data, $req);
        }

        return $data;
    }

    public function getStudentProfile($id): Student {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $ref = $database->getReference("students/$id");
        $profileSnap = $ref->getSnapshot();
        if($profileSnap->exists() == false) {
            $error = [
                "Access Denied",
                "You are not authorized to view this page"
            ];
            return view('error')->with("error",$error);
        }
        return $this->getStudentFromSnapshot($profileSnap);
    }

    private function getStudentFromSnapshot(Snapshot $studentSnap): Student {
        $id = $studentSnap->getkey();
        $obj = $studentSnap->getValue();
        $student = new Student();
        $student->setUid($id);
        $student->setUserName($obj['userName']);
        $student->setFirstName($obj['firstName']);
        $student->setLastName($obj['lastName']);
        $student->setEmail($obj['email']);
        $student->setPassword($obj['password']);

        if($studentSnap->hasChild("courses")) {
            $student->setCourses($obj['courses']);
        } else {
            $student->setCourses(array());
        }
        return $student;
    }

    public function getTutorsDataUsingCourses($allCourses, $tutors) {
        // $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        // $database = $factory->createDatabase();
        // $ref = $database->getReference("tutors");
        // $keys = $ref->getChildKeys();

        $data = array();

        foreach($tutors as $key => $tutor) {

            $tutorData = [
                "uid" => $tutor->getUid(),
                "firstName" => $tutor->getFirstName(),
                "lastName" => $tutor->getLastName(),
                "username" => $tutor->getUserName(),
                "classTimeBegin" => $tutor->getClassTimeBegin() ?
                    $tutor->getClassTimeBegin() : ""
            ];
            $courses = [];
            if($tutor->getCourses()) {
                // $allCourses = $this->getAllCourses();
                foreach($tutor->getCourses() as $key => $value) {
                    foreach ($allCourses as $key => $course) {
                        if($course->getCode() == $value) {
                            $courses[$value] = $course->getTitle();
                            break;
                        }
                    }
                }
            }

            $tutorData["courses"] = $courses;
            array_push($data, $tutorData);
        }
        return $data;
        // return response()->json($data, 200);
    }
}
