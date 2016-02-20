<?php

namespace Naski;


class Console
{

    private $_commands = array();

    private function __construct()
    {

    }

    public static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function recordCommand($cmd, $file)
    {
        $this->_commands[$cmd] = $file;
    }

    public function process($argv)
    {
        if (isset($argv[1])) {
            $command = $argv[1];
            if (isset($this->_commands[$command])) {
                $file = $this->_commands[$command];
                $cmd = "$file ".($argv[2]??'').' '.($argv[3]??'');
                echo "Process $cmd...\n";
                echo exec($cmd);
                echo "\n";
            } else {
                die("Command $command not found\n");
            }
        } else {
            die('No params\n');
        }

        die();
    }

}