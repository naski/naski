<?php

namespace DoePdo;

abstract class DatabaseAbstract {

    protected $_prefixe = '';
    protected $_pdo = null;
    protected $_nRequests = 0;

    protected $_lastQuery = "";
    protected $_result;

    public function connect($array) {

    }

    public function disconnect() {

    }

    protected function query($query) {
        $this->querycount++;
        $this->lastQuery = $query;
        try {
            $this->result = $this->sendQuery($query);
        } catch (BadQueryException $e) {
            $message = $e->getMessage();
            // TODO gérer les messages d'erreurs
        }
    }

    abstract protected function sendQuery($query);

}
