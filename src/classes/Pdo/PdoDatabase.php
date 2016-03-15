<?php

namespace Naski\Pdo;

abstract class PdoDatabase extends AbstractDatabase
{
    /**
     * @var \PDO
     */
    protected $_pdo = null; // Objet PDO abstrait (Mysql...)

    abstract public function getPrefixe(): string;

    /**
     *   Envoi la requete au serveur et retourne le résultat.
     * @param string $query
     * @return \PDOStatement
     * @throws BadQueryException
     */
    protected function sendQuery(string $query)
    {
        try {
            return $this->_pdo->query($query);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            throw new BadQueryException($error);
        }
    }

    public function getPdoInstance()
    {
        if (!$this->_isConnected) {
            $this->connect();
        }
        
        return $this->_pdo;
    }

    /**
     *  @override
     */
    public function connectAbstract()
    {
        $array = $this->_connexionDatas;

        $options = array(
            \PDO::ATTR_TIMEOUT => '3', // Timeout en secondes
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        );

        $dsn = $this->getPrefixe().':host='.$array['host'].';dbname='.$array['dbname'].'';
        if (isset($array['port'])) {
            $dsn .= ";port=".$array['port'];
        }

        $this->_pdo = new \PDO(
            $dsn,
            $array['username'],
            $array['password'],
            $options
        );
    }

    public function lastInsertId(): int
    {
        return $this->_pdo->lastInsertId();
    }
}
