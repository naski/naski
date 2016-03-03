<?php

namespace Naski\Pdo;

use Monolog\Logger;

abstract class AbstractDatabase
{
    protected $_logger = null; // Logger pour les erreurs
    protected $_loggerRequest = null; // Logger pour toutes les requêtes exécutées
    protected $_connexionDatas = array();

    protected $_isConnected = false;

    protected $_nRequests = 0; // Nombre de requêtes exécutes depuis le début de l'instance
    protected $_lastQuery = ''; // Dernière requête SQL exécutée
    protected $_result = null; // Rsultat de la dernière requête SQL exécutée


    /**
     *  @param $array keys: host, dbname, username, password
     */
    public function __construct(array $connexionDatas, Logger $logger = null)
    {
        if ($logger == null) {
            $logger = new Logger('unused_logger');
        }
        $this->_logger = $logger;

        $this->_connexionDatas = $connexionDatas;
    }

    abstract protected function connectAbstract();
    abstract protected function sendQuery(string $query);
    abstract protected function lastInsertId(): int;

    /**
     *  throws ConnexionFailureException.
     */
    private function connect()
    {
        try {
            $this->connectAbstract();
            $this->_isConnected = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $e = new ConnexionFailureException($message, $this->_connexionDatas);
            $this->_logger->critical($message.' '.$e->connexionDatasString);
            throw $e;
        }
    }

    /**
     *  throws ConnexionFailureException.
     */
    public function forceConnect()
    {
        if (!$this->_isConnected) {
            $this->connect();
        }
    }

    /**
     *  Traite la $query en l'envoyant au serveur ($this->sendQuery()), puis stocke le résultat
     *  throws ConnexionFailureException, BadQueryException.
     */
    public function query(string $query)
    {
        if (!$this->_isConnected) {
            $this->connect();
        }

        $this->_nRequests++;
        $this->_lastQuery = $query;

        if ($this->_loggerRequest != null) {
            $this->_loggerRequest->info($query);
        }

        try {
            $this->_result = $this->sendQuery($query);

            return $this->_result;
        } catch (BadQueryException $e) {
            $message = $e->getMessage();
            $message .= "\nQuery : ".$query;
            $this->_logger->error($message);
            throw new BadQueryException($message);
        }
    }

    private function cleanValue($value): string
    {
        switch ($value) {
            case null:
                $value = 'NULL';
                break;
            case 'NOW()':
                break;
            default:
                $value = $this->cleanQuotes($value);
                $value = "'$value'";
        }
        return $value;
    }

    abstract protected function cleanQuotes(string $value): string;

    /**
     *  Insert un tableau clé/valeur dans la base de donnée
     *  Une ligne à la fois.
     *
     *  @param $tablename   Nom de la table
     *  @param $insertArray Clés : noms des colonnes. Valeurs : valeurs du tuple
     */
    public function insert(string $tablename, array $insertArray)
    {
        $values = '';
        $keys = '';

        foreach ($insertArray as $key => $value) {
            $value = $this->cleanValue($value);
            $values .= "$value,";
            $keys .= ''.$key.',';
        }

        $values = substr_replace($values, '', -1);
        $keys = substr_replace($keys, '', -1);
        $query = sprintf('INSERT INTO %s (%s) VALUES (%s)', $tablename, $keys, $values);

        return $this->query($query);
    }

    /**
     *  Met à jour les tuples d'une table, selon une condition.
     *
     *  @param $tablename       Nom de la table
     *  @param $insertArray     Clés : noms des colonnes. Valeurs : valeurs du tuple
     *  @param $conditon        Liste des champs à respecter
     */
    public function update(string $tablename, array $insertArray, array $conditon)
    {
        $setter = '';
        foreach ($insertArray as $key => $value) {
            $setter .= "$key=";
            $value = $this->cleanValue($value);
            $setter .= "$value,";
        }
        $setter = substr_replace($setter, '', -1);

        $cond = self::createWhereCondition($conditon);

        $query = sprintf('UPDATE %s SET %s %s', $tablename, $setter, $cond);

        return $this->query($query);
    }

    private static function createWhereCondition(array $array): string
    {
        $addQuotes = false;
        $cond = '';
        if (!empty($array)) {
            $cond = "WHERE ";
            foreach ($array as $key => $value) {
                $value = addslashes($value);
                $cond .= "$key=";
                $cond .= ($value != 'NOW()') ? "'$value'" : "$value";
                $cond .= " AND ";
            }
            $cond = substr($cond, 0, -strlen(" AND "));
        }
        return $cond;
    }

    public function getRequestsNumber() :int
    {
        return $this->_nRequests;
    }

    public function getLastQuery(): string
    {
        return $this->_lastQuery;
    }

    public function startLogRequest(Logger $logger)
    {
        $this->_loggerRequest = $logger;
    }

    public function stopLogRequest()
    {
        $this->_loggerRequest = null;
    }
}
