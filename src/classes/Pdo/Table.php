<?php

namespace Naski\Pdo;

class Table {

    protected $db;
    protected $tablename;

    public function __construct(AbstractDatabase $db, string $tablename)
    {
        $this->db = $db;
        $this->tablename = $tablename;
    }

    public function insert(array $array)
    {
        $this->db->insert($this->tablename, $array);
    }

    public function update(array $array, array $condition)
    {
        $this->db->update($this->tablename, $array, $condition);
    }

    public function delete(array $condition)
    {
        $this->db->delete($this->tablename, $condition);
    }

    public function clearTable()
    {
        $this->db->query("TRUNCATE TABLE ".$this->tablename);
    }

    public function dropTable()
    {
        $this->db->query("DROP TABLE IF EXISTS {$this->tablename} cascade");
    }

    public function select(array $filters): array
    {
        $cond = $this->db->createWhereCondition($filters);
        $q = $this->db->query("select * from {$this->tablename} $cond");
        $list = $q->fetchAll(\PDO::FETCH_ASSOC);
        return $list;
    }

    public function cloneTable(string $newname, bool $keepOriginal, bool $keepContent)
    {
        $new = new self($this->db, $newname);
        $new->dropTable();

        if (!$keepOriginal) {
            $this->db->query("ALTER TABLE {$this->tablename} RENAME TO $newname");
        } else {
            $this->db->query("create table {$newname} (
                like {$this->tablename}
                including defaults
                including constraints
                including indexes
            );");
            if ($keepContent) {
                $this->db->query("INSERT INTO {$newname} (SELECT * FROM {$this->tablename} where 1=2)");
            }
        }
        return $new;
    }

    public function archiveTable(bool $keepOriginal=true)
    {
        return $this->cloneTable($this->tablename."_archive_".\date('Ymd_His'), $keepOriginal, true);
    }

    public function dropArchivesTables(int $days=30)
    {
        // TODO
    }

    public function createTempTable(bool $keepOriginal=true, bool $keepContent=false)
    {
        return $this->cloneTable($this->tablename."_tmp", $keepOriginal, $keepContent);
    }

    public function moveTempAsOriginal()
    {
        if (substr($this->tablename, -4) != '_tmp') {
            throw new \Exception("Cette table ({$this->tablename}) ne porte pas le suffixe '_tmp'");
        }

        $name_original = substr($this->tablename, 0, -4);
        $new = new self($this->db, $name_original);
        $new->dropTable();
        $this->cloneTable($name_original, false, true);
        return $new;
    }

    public function check() {
        try {
            $this->db->getFirstColumn("SELECT COUNT(*) FROM ".$this->tablename);
        } catch (\Exception $e) {
            throw new \Exception("La table '".$this->tablename."' n'existe pas");
        }

    }



}
