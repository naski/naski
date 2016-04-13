<?php

namespace Naski\Pdo;

use Monolog\Logger;
use Psr\Log\LoggerInterface;

abstract class AbstractDatabase
{
    /**
     * @var LoggerInterface
     */
    protected $_logger = null; // Logger pour les erreurs

    /**
     * @var LoggerInterface
     */
    protected $_loggerRequest = null; // Logger pour toutes les requêtes exécutées
    protected $_connexionDatas = array();

    protected $_isConnected = false;

    protected $_nRequests = 0; // Nombre de requêtes exécutes depuis le début de l'instance
    protected $_lastQuery = ''; // Dernière requête SQL exécutée
    protected $_result = null; // Résultat de la dernière requête SQL exécutée


    /**
     * @param array $connexionDatas
     * @param Logger $logger
     * @internal param array $keys : host, dbname, username, password
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
    abstract public function lastInsertId(): int;

    /**
     *  throws ConnexionFailureException.
     */
    protected function connect()
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
     * @param string $query
     * @return mixed
     * @throws BadQueryException
     * @throws ConnexionFailureException
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
        if ($value === true) {
            return 'TRUE';
        }

        if ($value === false) {
            return 'FALSE';
        }

        if ($value === null) {
            return "NULL";
        }

        if ($value == 'NOW()') {
            return $value;
        }

        $value = $this->cleanQuotes($value);
        $value = "'$value'";

        return $value;
    }

    abstract protected function cleanQuotes(string $value): string;

    /**
     *  Insert un tableau clé/valeur dans la base de donnée
     *  Une ligne à la fois.
     *
     *  @param string $tablename   Nom de la table
     *  @param array $insertArray  Clés : noms des colonnes. Valeurs : valeurs du tuple
     *  @return string
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
     *  @param string $tablename       Nom de la table
     *  @param array $insertArray     Clés : noms des colonnes. Valeurs : valeurs du tuple
     *  @param array $conditon        Liste des champs à respecter
     *  @return mixed Le résultat de la query
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

        $cond = $this->createWhereCondition($conditon);

        $query = sprintf('UPDATE %s SET %s %s', $tablename, $setter, $cond);

        return $this->query($query);
    }

    public function upsert(string $tablename, array $insertArray, array $condition)
    {
        $this->update($tablename, $insertArray, $condition);

        $values = '';
        $keys = '';

        foreach ($insertArray as $key => $value) {
            $value = $this->cleanValue($value);
            $values .= "$value,";
            $keys .= ''.$key.',';
        }

        $values = substr_replace($values, '', -1);
        $keys = substr_replace($keys, '', -1);
        $cond = $this->createWhereCondition($condition);
        $query = sprintf("INSERT INTO $tablename ($keys) SELECT $values WHERE NOT EXISTS (SELECT 1 FROM $tablename $cond)");

    }

    private function createWhereCondition(array $array): string
    {
        $cond = '';
        if (!empty($array)) {
            $cond = "WHERE ";
            foreach ($array as $key => $value) {
                $value = $this->cleanValue($value);
                $cond .= "$key=$value";
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

    /**
     * @param $query
     * @return string La première colonne de la première ligne de la colonne
     * @throws BadQueryException
     */
    public function getFirstColumn($query)
    {
        $q = $this->query($query);
        $l = $q->fetch();
        return $l[0] ?? null;
    }
}
