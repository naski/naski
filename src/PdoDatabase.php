<?php

namespace DoePdo;

abstract class PdoDatabase extends AbstractDatabase
{

    protected $_pdo = null; // Objet PDO abstrait (Mysql...)

    public abstract function getPrefixe(): string;

    /**
     *   Envoi la requete au serveur et retourne le résultat
     */
    protected function sendQuery(string $query)
    {
        try {
            return $this->_pdo->query($query);
        }
        catch (\Exception $e) {
			$error = $e->getMessage();
			throw new BadQueryException($error);
		}
    }

    public function connect(array $array)
    {
        $options = array(
            \PDO::ATTR_TIMEOUT => "3", // Timeout en secondes
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->_pdo = new \PDO(
                $this->getPrefixe().':host='.$array['host'].';dbname='.$array['dbname'].'',
                $array['username'],
                $array['password'],
                $options
            );
        }
        catch (\Exception $e) {
			$error = $e->getMessage();
			throw new ConnexionFailureException($error);
		}
    }

}
