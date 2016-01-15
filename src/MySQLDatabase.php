<?php

namespace DoePdo;

class MySQLDatabase extends AbstractDatabase
{

    public function connect($array)
    {
        $options = array(

        );

        try {
            $this->_pdo = new \PDO(
                'mysql:host='.$array['host'].';dbname='.$array['dbname'].'',
                $array['username'],
                $array['password'],
                $options
            );
            $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); // Set Errorhandling to Exception
        }
        catch (\Exception $e) {
			$error = $e->getMessage();
			throw new ConnexionFailureException($error);
		}
    }

    protected function sendQuery($query)
    {
        try {
            return $this->_pdo->query($query);
        }
        catch (\Exception $e) {
			$error = $e->getMessage();
			throw new BadQueryException($error);
		}
    }

}
