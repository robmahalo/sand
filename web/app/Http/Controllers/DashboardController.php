<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Firebase\Auth\Token\Exception\InvalidToken;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/myapp.json');
        $database = $factory->createDatabase();
        $auth = $factory->createAuth();
        $idTokenString = request('idToken');
        try {
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        } catch (\InvalidArgumentException $e) {
            $error = [
                "Missing Token",
                "Some error occurred getting your id token, please refresh or login again"
            ];
            return view('error')->with("error",$error);
        } catch (InvalidToken $e) {
            $error = [
                "Access Denied",
                "You are not authorized to view this page"
            ];
            return view('error')->with("error",$error);
        }
        $uid = $verifiedIdToken->getClaim('sub');
        $user = $auth->getUser($uid);
        if($user == null) {
            $error = [
                "Invalid User",
                "This user is invalid, please login with different account"
            ];
            return view('error')->with("error",$error);
        }
        $ref = $database->getReference("roles/$uid");
        $userRoleSnap = $ref->getSnapshot();
        if($userRoleSnap->exists() == false) {
            $error = [
                "Access Denied",
                "You are not authorized to view this page"
            ];
            return view('error')->with("error",$error);
        }
        $userRole = $userRoleSnap->getChild("role")->getValue();
        session()->put("role",$userRole);//Save in session
        session()->put("id",$uid);
        if(Roles::isAdmin($userRole)) {
            return redirect('sand-students');
        }
        elseif (Roles::isStudent($userRole)) {
            return redirect('sand-schedule');
        }
        elseif (Roles::isTutor($userRole)) {
            return redirect('sand-requests');
        }
        else {
            return redirect('logout');
        }
    }
}
