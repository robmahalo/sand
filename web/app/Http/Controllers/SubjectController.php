<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session()->has("role") == false) {
            return view('logout');
        }
        $role = session()->get("role");
        if(Roles::isAdmin($role)) {
            return view("subjects")->with("courses", $this->getAllCourses())
            ->with("students", $this->getAllStudents())
            ->with("tutors", $this->getAllTutors())
            ->with("role",$role);
        }
        $error = [
            "Access Denied",
            "You are not authorized to view this page"
        ];
        return view('error')->with("error",$error);
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
            $obj = $ref->getChild($key)->getValue();

            $tutor = new Tutor();
            $tutor->setUid($key);
            $tutor->setUserName($obj['userName']);
            $tutor->setFirstName($obj['firstName']);
            $tutor->setLastName($obj['lastName']);
            $tutor->setEmail($obj['email']);
            $tutor->setPassword($obj['password']);
            if($ref->getChild($key)->getSnapshot()->hasChild("rating")) {
                $tutor->setRating($obj['rating']);
            }
            if($ref->getChild($key)->getSnapshot()->hasChild("classTimeBegin")) {
                $tutor->setClassTimeBegin($obj['classTimeBegin']);
            }
            if($ref->getChild($key)->getSnapshot()->hasChild("classTimeEnd")) {
                $tutor->setClassTimeEnd($obj['classTimeEnd']);
            }

            $location = new Location();
            $loc = $obj['location'];
            $location->setStreetAddress($loc['streetAddress']);
            $location->setCity($loc['city']);
            $location->setState($loc['state']);
            $location->setZipCode($loc['zipCode']);
            $tutor->setLocation($location);


            if($ref->getChild($key)->getSnapshot()->hasChild("courses")) {
                $tutor->setCourses($obj['courses']);
            } else {
                $tutor->setCourses(array());
            }

            array_push($data, $tutor);
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeStudentCourse(Request $request)
    {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $userName = request("stdUserName");
        $ref = $database->getReference("students/{$userName}");

        if ($ref->getSnapshot()->hasChild("courses")) {
            $ref = $database->getReference("students//{$userName}/courses");
            $ref->update([
                request("stdCourse") => "true"
            ]);
        } else {
            $ref->update([
                "courses" => [
                    request("stdCourse") => "true"
                ]
            ]);
        }

        return $this->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTutorCourse(Request $request)
    {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $userName = request("tutorUserName");
        $ref = $database->getReference("tutors/{$userName}");

        if ($ref->getSnapshot()->hasChild("courses")) {
            $ref = $database->getReference("tutors//{$userName}/courses");
            $ref->update([
                request("tutorCourse") => "true"
               ]);
        } else {
            $ref->update([
                "courses" => [
                    request("tutorCourse") => "true"
                ]
            ]);
        }

        return $this->index();
    }
}
