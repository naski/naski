<?php

use Naski\Bundle\DisplayBundle;

class DevBarBundle extends DisplayBundle
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

    public function getTwigParamsOveride(): array
    {
        return array(
            'bundle' => $this
        );
    }
}
