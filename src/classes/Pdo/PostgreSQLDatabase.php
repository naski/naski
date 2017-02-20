<?php

namespace Naski\Pdo;

class PostgreSQLDatabase extends PdoDatabase
{
    public function getPrefixe(): string
    {
        return 'pgsql';
    }

    protected function cleanQuotes(string $value): string
    {
        return str_replace("'", "''", $value);
    }

    public function lastInsertId(): int
    {
        $l = $this->query("SELECT lastval();")->fetch();
        return $l[0];
    }

    public function upsert(string $tablename, array $insertArray, array $condition)
    {
        $this->update($tablename, $insertArray, $condition);

        $values = '';
        $keys = '';

        foreach ($insertArray as $key => $value) {
            $value = $this->cleanValue($value);
            $values .= "$value,";
            $keys .= ''.$key.',';
        }

        $values = substr_replace($values, '', -1);
        $keys = substr_replace($keys, '', -1);

        $newCondition = [];
        foreach ($condition as $key => $value) {
            $newCondition["t.$key"] = $value;
        }
        $cond = $this->createWhereCondition($newCondition);
        $query = sprintf("INSERT INTO $tablename ($keys) SELECT $values WHERE NOT EXISTS (SELECT 1 FROM $tablename t $cond)");
        $this->query($query);
    }

    public function execFile($filename, $echoCmd = false)
    {
        $datas = $this->getConnexionDatas();
        putenv("PGPASSWORD=".$datas['password']);
        $cmd = "psql -h ".$datas['host']." -U ".(isset($datas['port']) ? ('-p '.$datas['port']) : '').$datas['username']." -d ".$datas['dbname']." -f ".$filename;
        if ($echoCmd) {
            echo "$cmd\n";
        }
		exec($cmd);
        return $cmd;
    }

}
