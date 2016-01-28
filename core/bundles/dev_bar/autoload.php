<?php

use Naski\Bundle\Bundle;

class DevBarBundle extends Bundle
{
    public function getRequestsNumber()
    {
        global $IM;
        return \Naski\sumCalls($IM->getDatabaseInstances(), 'getRequestsNumber');
    }

    public function getTime(): string
    {
        $time = PHP_Timer::stop();
        return PHP_Timer::secondsToTimeString($time);
    }

    public function load()
    {
        global $CONFIG, $IM;
        $this->setVariable('twig_params', array(
            'IM' => $IM,
            'bundle' => $this
        ));
    }
}
