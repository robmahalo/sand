<?php

namespace App\Http\Controllers;


class AvailableTime
{
    private $slotCode;
    private $slotTime;

    /**
     * @return mixed
     */
    public function getSlotCode()
    {
        return $this->slotCode;
    }

    /**
     * @param mixed $slotCode
     */
    public function setSlotCode($slotCode): void
    {
        $this->slotCode = $slotCode;
    }

    /**
     * @return mixed
     */
    public function getSlotTime()
    {
        return $this->slotTime;
    }

    /**
     * @param mixed $slotTime
     */
    public function setSlotTime($slotTime): void
    {
        $this->slotTime = $slotTime;
    }


}
