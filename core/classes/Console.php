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

    /**
     * Enregistre une nouvelle commande à la console, associée à une fonction
     *
     * @param $cmd Le nom de la commande à enregistrer. Exemple: cleanCache
     * @param $handler  L'handler qui sera exécuté avec call_user_func_array
     */
    public function recordCommand($cmd, $handler)
    {
        $this->_commands[$cmd] = $handler;
    }

    /**
     * Enregistre une nouvelle commande à la console, qui exécutera un fichier
     *
     * @param $cmdname Le nom de la commande à enregistrer
     * @param $filename Le chemin complet vers le fichier qui sera exécuté
     */
    public function recordFileExec($cmdname, $filename) {

        $f = function ($filename) {
            return function($p1="", $p2="", $p3="") use($filename) {
                $cmd = "$filename $p1 $p2 $p3 2>&1";
                echo "exec in shell : $cmd\n";

                $out = array();
                exec($cmd, $out);

                foreach ($out as $l) {
                    echo "$l\n";
                }
                echo "\n";
            };
        };

        $this->recordCommand($cmdname, $f($filename));
    }

    /**
     * Exécute la commande qu'il faut en fonction des urguments
     *
     * @param $argv La liste des arguments entrés par l'utilisateur
     */
    public function process(array $argv)
    {
        if (isset($argv[1])) {
            $command = $argv[1];
            if (isset($this->_commands[$command])) {
                call_user_func_array($this->_commands[$command], array_slice($argv, 2));
            } else {
                echo "Commande $command introuvable. ";
                $this->showAvailableCommands();
            }
        } else {
            echo "Aucune commande entrée. ";
            $this->showAvailableCommands();
        }
        echo "\n";
    }

    /**
     * Affiche à l'écran la liste des commandes enregistrées
     */
    private function showAvailableCommands()
    {
        echo "Commandes disponiables:\n";
        foreach ($this->_commands as $c => $v) {
            echo "- $c\n";
        }
    }

}
