<?php

namespace DoePdo;

// Test private

abstract class AbstractDatabase
{

    protected $_prefixe = '';
    protected $_nRequests = 0;

    protected $_lastQuery = "";
    protected $_result;

    /**
     *  throws ConnexionFailureException
     *  @param $array keys: host, dbname, username, password
     */
    abstract public function connect(array $array);

    /**
     *  Traite la query en l'envoyant au serveur ($this->sendQuery()), puis stocke le résultat
     */
    public function query($query)
    {
        $this->_nRequests++;
        $this->_lastQuery = $query;
        try {
            $this->_result = $this->sendQuery($query);
            return $this->_result;
        } catch (BadQueryException $e) {
            $message = $e->getMessage();
            $message .= "\nQuery : " . $query;
            throw new BadQueryException($message);
        }
    }

    public function insert($table, $insertArray, $addQuotes = true)
    {
        $quotedValues = '';
		$keys = '';

		foreach ($insertArray as $key => $value) {
			$quotedValues .= $addQuotes ? ("'$value',") : "$value,";
			$keys .= ''.$key.',';
		}

		$quotedValues = substr_replace($quotedValues, "", -1);
		$keys = substr_replace($keys, "", -1);
    	$query = sprintf("INSERT INTO %s (%s) VALUES (%s)", $table, $keys, $quotedValues);

		return $this->query($query);
    }

    public function update($table, $insertArray, $cond, $addQuotes = true)
    {
		$setter = '';

		foreach ($insertArray as $key => $value) {
			$setter .= "$key=";
			$setter .= $addQuotes ? ("'$value',") : "$value,";
		}

		$setter = substr_replace($setter, "", -1);
    	$query = sprintf("UPDATE %s SET %s %s", $table, $setter, $cond);

		return $this->query($query);
	}

}
