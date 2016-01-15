<?php

namespace DoePdo;

abstract class AbstractDatabase
{

    protected $_prefixe = '';
    protected $_pdo = null; // Objet PDO abstrait (Mysql...)
    protected $_nRequests = 0;

    protected $_lastQuery = "";
    protected $_result;

    /**
     *  throws ConnexionFailureException
     *  @param $array keys: host, dbname, username, password
     */
    abstract public function connect($array);

    public function disconnect()
    {

    }

    /**
     * Traite la query en l'envoyant au serveur ($this->sendQuery()), puis stocke le résultat
     */
    public function query($query)
    {
        $this->_nRequests++;
        $this->_lastQuery = $query;
        try {
            $this->_result = $this->sendQuery($query);
            return $this->_result;
        } catch (BadQueryException $e) {
            throw $e;
        }
    }

    /**
     *   Envoi la requete au serveur et retourne le résultat
     */
    abstract protected function sendQuery($query);

}
