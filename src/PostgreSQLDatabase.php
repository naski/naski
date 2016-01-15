<?php

namespace DoePdo;

class PostgreSQLDatabase extends AbstractDatabase
{

    protected function sendQuery($query)
    {
        $result = pg_query($this->pdo, $query);
		if ($this->result === false) {
            $error = pg_last_error($this->pdo);
			throw new BadQueryException($error);
		}
        return $result;
    }

}
