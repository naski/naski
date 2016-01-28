<?php

use Naski\Bundle\Bundle;

class DevBarBundle extends Bundle
{
    public function getRequestsNumber(): int
    {
        global $IM;
        return \Naski\sumCalls($IM->getInstancesOfType('\\Naski\\Pdo\\AbstarctDatabase'), 'getRequestsNumber');
    }

    public function getTime(): string
    {
        $time = PHP_Timer::stop();
        return PHP_Timer::secondsToTimeString($time);
    }

    public function load()
    {
        $this->setVariable('twig_params', array(
            'bundle' => $this
        ));
    }
}
