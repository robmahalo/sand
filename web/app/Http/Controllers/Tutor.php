<?php


namespace App\Http\Controllers;


class Tutor
{
    public $firstName;
    public $lastName;
    public $userName;
    public $email;
    public $password;
    public $uid;
    public $courses;
    public $classTimeBegin;
    public $classTimeEnd;
    public $location;
    public $rating;

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getClassTimeBegin()
    {
        return $this->classTimeBegin;
    }

    /**
     * @param mixed $classTimeBegin
     */
    public function setClassTimeBegin($classTimeBegin): void
    {
        $this->classTimeBegin = $classTimeBegin;
    }

    /**
     * @return mixed
     */
    public function getClassTimeEnd()
    {
        return $this->classTimeEnd;
    }

    /**
     * @param mixed $classTimeEnd
     */
    public function setClassTimeEnd($classTimeEnd): void
    {
        $this->classTimeEnd= $classTimeEnd;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getCourses() {
        return $this->courses;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid): void
    {
        $this->uid = $uid;
    }

    public function setCourses($courses) {
        $this->courses = $courses;
    }

    /**
     * @return mixed availability
     */
    public function getAvailability()
    {
        return "";
    }

    /**
     * @return mixed classTime
     */
    public function getClassTime()
    {
        if($this->classTimeBegin != null && $this->classTimeEnd != null) {
            return "$this->classTimeBegin to $this->classTimeEnd";
        }

        if($this->classTimeBegin != null) {
            return $this->classTimeBegin;
        }

        if($this->classTimeEnd != null) {
            return $this->classTimeEnd;
        }

        return "";
    }

    public function toJSObject() {
        return json_encode([
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "username" => $this->userName,
            "uid" => $this->uid,
            "email" => $this->email,
            "courses" => $this->courses,
            "classTimeBegin" => $this->classTimeBegin,
            "classTimeEnd" => $this->classTimeEnd,
            "location" => $this->location,

        ]);
    }
}
