<?php

class MySQLDatabase extends DatabaseAbstract {

    protected function sendQuery($query) {
        try {
            return $this->_pdo->query($query);
        }
        catch (Exception $e) {
			$error = $e->getMessage();
			throw new BadQueryException($error);
		}
    }


}
