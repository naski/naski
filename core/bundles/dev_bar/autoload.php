<?php

use Naski\Displayer\Bundle\Bundle;

class DevBarBundle extends Bundle
{

    public function getRequestsNumber(): int
    {
        global $IM;
        return \Naski\sumCalls($IM->getInstancesOfType('\\Naski\\Pdo\\AbstractDatabase'), 'getRequestsNumber');
    }

    public function getTime(): string
    {
        $time = PHP_Timer::stop();
        return PHP_Timer::secondsToTimeString($time);
    }

}
