<?php

namespace DoePdo;

abstract class DatabaseAbstract {

    protected $_prefixe = '';
    protected $_pdo = null; // Objet PDO abstrait (Mysql...)
    protected $_nRequests = 0;

    protected $_lastQuery = "";
    protected $_result;

    public function connect($array) {

    }

    public function disconnect() {

    }

    /**
     * Traite la query en l'envoyant au serveur ($this->sendQuery()), puis stocke le résultat
     */
    public function query($query) {
        $this->_nRequests++;
        $this->_lastQuery = $query;
        try {
            $this->_result = $this->sendQuery($query);
            return $this->_result;
        } catch (BadQueryException $e) {
            $message = $e->getMessage();
            // TODO gérer les messages d'erreurs
        }
    }

    /**
     *   Envoi la requete au serveur et retourne le résultat
     */
    abstract protected function sendQuery($query);

}
