<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Database\Snapshot;
use Kreait\Firebase\Factory;


class ProfileController extends Controller
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
        if(Roles::isTutor($role)) {
            return view("profile")
            ->with("tutor", $this->getTutorProfile($id))
            ->with("role",$role);
        }
        if(Roles::isStudent($role)) {
            return view("profile")
            ->with("student", $this->getStudentProfile($id))
            ->with("role",$role);
        }
        $error = [
            "Access Denied",
            "You are not authorized to view this page"
        ];
        return view('error')->with("error",$error);
    }

    public function edit()
    {
        if(session()->has("role") == false || session()->has("id") == false) {
            return view('logout');
        }
        $role = session()->get("role");
        $id = session()->get("id");
        if(Roles::isTutor($role)) {
            return view("edit_tutor")
            ->with("tutor", $this->getTutorProfile($id))
            ->with("courses", (new RequestController())->getAllCourses())
            ->with("role",$role);
        }

        if(Roles::isStudent($role)) {
            return view("edit_student")
            ->with("student", $this->getStudentProfile($id))
            ->with("role",$role);
        }

        $error = [
            "Access Denied",
            "You are not authorized to view this page"
        ];
        return view('error')->with("error",$error);
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
}
