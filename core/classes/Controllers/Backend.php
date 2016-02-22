<?php

namespace Naski\Controllers;

class Backend
{

    private function execScript($cmd) {
        $cmd = $cmd.' 2>&1';
        echo "Exec $cmd...\n\n";

        $output = array();
        exec($cmd, $output);
        foreach ($output as $line) {
            echo "$line\n";
        }

        die("\n");
    }

    public function cleanCache() {
        $this->execScript(NASKI_CORE_PATH.'scripts/clean_cache.sh go');
    }

    public function cleanLogs() {
        $this->execScript(NASKI_CORE_PATH.'scripts/clean_logs.sh go');
    }
}
