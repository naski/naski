<?php

namespace Naski\Pdo;

class ConnexionFailureException extends \Exception
{
    public $connexionDatasArray; // Array de connexion
    public $connexionDatasString; // Informations de connexion, sans le mot de passe

    public function __construct(string $message, array $datas)
    {
        parent::__construct($message);
        $this->connexionDatasArray = $datas;
        $this->connexionDatasString = $datas['username'].'@'.$datas['host'].'/'.$datas['dbname'];
    }
}
