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

    public function recordCommand($cmd, $handler)
    {
        $this->_commands[$cmd] = $handler;
    }

    public function recordFileExec($cmdname, $filename) {

        $f = function ($filename) {
            return function($p1="", $p2="", $p3="") use($filename) {
                $cmd = "$filename $p1 $p2 $p3";
                echo "exec in shell : $cmd\n";
                echo exec($cmd);
                echo "\n";
            };
        };

        $this->recordCommand($cmdname, $f($filename));
    }

    public function process($argv)
    {
        if (isset($argv[1])) {
            $command = $argv[1];
            if (isset($this->_commands[$command])) {
                call_user_func_array($this->_commands[$command], array_slice($argv, 2));
            } else {
                die("Command $command not found\n");
            }
        } else {
            echo "Aucune commande entrée. Commandes disponibles :\n";
            var_dump(array_keys($this->_commands));
            exit();
        }

        die();
    }

}
