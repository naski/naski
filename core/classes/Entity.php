<?php

namespace Naski;

use Naski\Pdo\AbstractDatabase;

abstract class Entity
{

	/** @noinspection PhpAbstractStaticMethodInspection */
	public static abstract function table();
	private $_rows = array();
	private $_db;

	private function __construct($db)
	{
		$this->_db = $db;
	}

	private function hydrate(array $a)
	{
		foreach ($a as $key => $value) {
			if (!is_numeric($key)) {
				$this->_rows[$key] = $value;
				$this->$key = $value;
			}
		}
	}

	public static function get(AbstractDatabase $db, /** @noinspection PhpUnusedParameterInspection */
							   array $cond): array
	{
		$list = array();
		$query = $db->query("SELECT * FROM ".static::table());
		while ($l = $query->fetch()) {
			$i = new static($db);
			$i->hydrate($l);
			$list[] = $i;
		}
		return $list;
	}

	public static function construct(array $array)
	{
		$i = new static($array);
		return $i;
	}

	public function getAsArray()
	{
		return $this->_rows;
	}

	public function insert()
	{
		$this->_db->insert($this->table(), $this->_rows);
	}

	public function save()
	{
		$this->_db->update($this->table(), $this->_rows, "");
	}

	public function __set($key, $value) {
		$this->_rows[$key] = $value;
	}

	public function __get($key)
	{
		return $this->_rows[$key];
	}
}
