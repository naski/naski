<?php

class Backend
{
    public function cleanLogs() {
        echo exec(ROOT_SYSTEM.'core/scripts/clean_cache.sh go');
        die();
    }
}
