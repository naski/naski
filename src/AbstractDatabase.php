<?php

namespace DoePdo;

abstract class AbstractDatabase
{

    protected $_nRequests = 0; // Nombre de requêtes exécutes depuis le début de l'instance
    protected $_lastQuery = ""; // Dernière requête SQL exécutée
    protected $_result; // Rsultat de la dernière requête SQL exécutée

    /**
     *  throws ConnexionFailureException
     *  @param $array keys: host, dbname, username, password
     */
    abstract public function connect(array $array);

    /**
     *  Traite la $query en l'envoyant au serveur ($this->sendQuery()), puis stocke le résultat
     */
    public function query(string $query)
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

    /**
     *  Insert un tableau clé/valeur dans la base de donnée
     *  Une ligne à la fois
     *  @param $tablename   Nom de la table
     *  @param $insertArray Clés : noms des colonnes. Valeurs : valeurs du tuple
     *  @param $addQuotes   Permet d'ajouter des quotes simples ' autour des valeurs
     */
    public function insert(string $tablename, array $insertArray, bool $addQuotes = true)
    {
        $quotedValues = '';
		$keys = '';

		foreach ($insertArray as $key => $value) {
			$quotedValues .= $addQuotes ? ("'$value',") : "$value,";
			$keys .= ''.$key.',';
		}

		$quotedValues = substr_replace($quotedValues, "", -1);
		$keys = substr_replace($keys, "", -1);
    	$query = sprintf("INSERT INTO %s (%s) VALUES (%s)", $tablename, $keys, $quotedValues);

		return $this->query($query);
    }

    /**
     *  Met à jour les tuples d'une table, selon une condition
     *  @param $tablename       Nom de la table
     *  @param $insertArray     Clés : noms des colonnes. Valeurs : valeurs du tuple
     *  @param $cond            Condition SQL à concatener à la requête
     *  @param $addQuotes       Permet d'ajouter des quotes simples ' autour des valeurs
     */
    public function update(string $tablename, array $insertArray, string $cond, bool $addQuotes = true)
    {
		$setter = '';

		foreach ($insertArray as $key => $value) {
			$setter .= "$key=";
			$setter .= $addQuotes ? ("'$value',") : "$value,";
		}

		$setter = substr_replace($setter, "", -1);
    	$query = sprintf("UPDATE %s SET %s %s", $tablename, $setter, $cond);

		return $this->query($query);
	}

}
