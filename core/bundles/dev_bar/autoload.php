<?php

use Assetic\Asset\FileAsset;
use Naski\Displayer\Bundle\Bundle;
use Naski\Displayer\Bundle\BundleManager;

class DevBarBundle extends Bundle
{

    public function exec()
    {
        global $IM;
        $IM->dpl->addCssFile(new FileAsset($this->directory.'style.css'));
    }

    public function onEnable()
    {
        PHP_Timer::start();
    }

    public function getRequestsNumber(): int
    {
        global $IM;
        return \Naski\sumCalls($IM->getInstancesOfType('\\Naski\\Pdo\\AbstractDatabase'), 'getRequestsNumber');
    }

    public function getUsedBundle(): array
    {
        global $IM;
        return $IM->dpl->usedBundlesStack;
    }

    public function getRecordedBundle(): array
    {
        return BundleManager::getInstance()->recordedBundlesStack;
    }

    public function getTime(): string
    {
        $time = PHP_Timer::stop();
        return PHP_Timer::secondsToTimeString($time);
    }

}
