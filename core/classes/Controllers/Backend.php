<?php

namespace Naski\Controllers;

class Backend
{
    public function cleanCache() {
        echo exec(NASKI_CORE_PATH.'scripts/clean_cache.sh go 2>&1');
        die("\n");
    }
}
