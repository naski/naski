<?php

class Backend
{
    public function cleanLogs() {
        echo exec(NASKI_CORE_PATH.'scripts/clean_cache.sh go');
        die();
    }
}
