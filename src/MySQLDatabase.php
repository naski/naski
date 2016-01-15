<?php

namespace DoePdo;

class MySQLDatabase extends AbstractDatabase
{

    protected function sendQuery($query)
    {
        try {
            return $this->_pdo->query($query);
        }
        catch (Exception $e) {
			$error = $e->getMessage();
			throw new BadQueryException($error);
		}
    }

    public function connect($array)
    {
        $options = array(

        );

        try {
            $this->pdo = new \PDO(
                'mysql:host='.$array['host'].';dbname='.$array['dbname'].'',
                $array['username'],
                $array['password'],
                $options
            );
        }
        catch (\PDOException $e) {
			$error = $e->getMessage();
			throw new ConnexionFailureException($error);
		}
    }

}
