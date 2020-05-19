<?php

namespace App\Http\Controllers;

use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class StudentController extends Controller
{
    public function getAll() {
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
            return view('welcome')->with("students", $this->getAll())
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
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $uid = 0;
        $ref = $database->getReference("students");

        $key = $ref->push()->getKey();

        $ref->getChild($key)->set([
            "userName" => request('userName'),
            "firstName" => request('firstName'),
            "lastName" => request('lastName'),
            "password" => request('password'),
            "email" => request('email')
        ]);

        return $this->index();
    }

    public function create(Request $request)
    {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $auth = $factory->createAuth();
        $idTokenString = request('idToken');
        try {
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                "status" => 400,
                "message" => $e->getMessage()
            ], 400);
            // echo 'The token could not be parsed: '.$e->getMessage();
        } catch (InvalidToken $e) {
            return response()->json([
                "status" => 403,
                "message" => $e->getMessage()
            ], 403);
            // echo 'The token is invalid: '.$e->getMessage();
        }
        $uid = $verifiedIdToken->getClaim('sub');
        $user = $auth->getUser($uid);
        if($user == null) {
            echo 'Invalid User';
        }
        //Create student record
        $ref = $database->getReference("students");
        $ref->getChild($uid)->set([
            "userName" => request('username'),
            "firstName" => request('firstName'),
            "lastName" => request('lastName'),
            "password" => request('password'),
            "email" => request('email')
        ]);

        //Create role
        $ref = $database->getReference("roles");
        $ref->getChild($uid)->set([
            "role" => Roles::getStudentRole()
        ]);

        $data = [
            "status"=> "success"
        ];
        return response()->json($data, 200);
    }

    public function edit(Request $request)
    {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $auth = $factory->createAuth();
        $uid = session()->get("id");
        $user = $auth->getUser($uid);
        if($user == null) {
            echo 'Invalid User';
        }
        //Create student record
        $studentData = [
            "userName" => request('username'),
            "firstName" => request('firstName'),
            "lastName" => request('lastName')
        ];

        $ref = $database->getReference("students");
        $ref->getChild($uid)->update($studentData);

        $data = [
            "status"=> "success"
        ];
        return response()->json($data, 200);
    }
}
