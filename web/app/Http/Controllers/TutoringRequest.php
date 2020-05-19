<?php


namespace App\Http\Controllers;


class TutoringRequest
{
    private $code;
    private $course;
    private $slot;
    private $block;
    private $studentUserName;
    private $tutorUserName;
    private $classTimeBegin;

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param mixed $course
     */
    public function setCourse($course): void
    {
        $this->course = $course;
    }

    /**
     * @return mixed
     */
    public function getSlot()
    {
        return $this->slot;
    }

    /**
     * @param mixed $slot
     */
    public function setSlot($slot): void
    {
        $this->slot = $slot;
    }

    /**
     * @return mixed
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param mixed $block
     */
    public function setBlock($block): void
    {
        $this->block = $block;
    }

    /**
     * @return mixed
     */
    public function getClassTimeBegin()
    {
        return $this->classTimeBegin;
    }

    /**
     * @param mixed $slot
     */
    public function setClassTimeBegin($classTimeBegin): void
    {
        $this->classTimeBegin = $classTimeBegin;
    }

    /**
     * @return mixed
     */
    public function getStudentUserName()
    {
        return $this->studentUserName;
    }

    /**
     * @param mixed $studentUserName
     */
    public function setStudentUserName($studentUserName): void
    {
        $this->studentUserName = $studentUserName;
    }

    /**
     * @return mixed
     */
    public function getTutorUserName()
    {
        return $this->tutorUserName;
    }

    /**
     * @param mixed $tutorUserName
     */
    public function setTutorUserName($tutorUserName): void
    {
        $this->tutorUserName = $tutorUserName;
    }
}
