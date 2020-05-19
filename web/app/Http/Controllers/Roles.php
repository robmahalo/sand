<?php


namespace App\Http\Controllers;


class Roles
{
    private static  $roles = [
        'admin' => 1,
        'student' => 2,
        'tutor' => 3
    ];

    public static function getAdminRole() {
        return self::$roles['admin'];
    }

    public static function getStudentRole() {
        return self::$roles['student'];
    }

    public static function getTutorRole() {
        return self::$roles['tutor'];
    }

    public static function isAdmin($role) {
        return self::$roles['admin'] == $role;
    }

    public static function isStudent($role) {
        return self::$roles['student'] == $role;
    }

    public static function isTutor($role) {
        return self::$roles['tutor'] == $role;
    }
}
