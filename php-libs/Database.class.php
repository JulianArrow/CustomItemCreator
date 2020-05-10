<?php
/**
 * @author Julian Pfeil <julian.7.pfeil@gmail.com>
 * @version 1.1.2
 */
 
class Database
{
	private $connection;
	
	public function __construct($dbHost, $dbUser, $dbPassword, $dbName, $utf8 = true, $errorMode = true) 
	{
		try {
			$dbOptions = [];
			if ($utf8 === true)
				$dbOptions[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8';
			if ($errorMode === true)
				$dbOptions[PDO::ATTR_ERRMODE] = PDO::ERRMODE_WARNING;
			$this->connection = new PDO('mysql:host='.$dbHost.';dbname='.$dbName, $dbUser, $dbPassword, $dbOptions);
		} catch (\PDOException $error) {
			throw $error;
		}
	}
	
	public function c()
	{
		return $this->connection;
	}
	
	private function whereProcess(&$where, &$query)
	{
		if (count($where) > 0) {
			$query .= ' WHERE';
			$i = 0;
			foreach ($where AS $column => &$value) {
				if (is_array($value)) {
					$phrase = $value[0];
					$value = $value[1];
					if ($i++ > 0) 
						$query .= ' AND';
					$query .= ' `'.$column.'` '.$phrase.' :'.$column;
				} else {
					if ($i++ > 0) 
						$query .= ' AND';
					$query .= ' `'.$column.'` = :'.$column;
				}
			}
		}
	}
	
	public function select($table, $where = [], $limit = -1, $columns = '*', $orderBy = '', $desc = false)
	{
		$query = 'SELECT '.$columns.' FROM `'.$table.'`';
		$this->whereProcess($where, $query);
		if ($orderBy != '') {
			$query .= ' ORDER BY '.$orderBy;
			if ($desc === true)
				$query .= ' DESC';
		}
		if ($limit > 0)
			$query .= ' LIMIT '.$limit;
		$statement = $this->connection->prepare($query);
		$statement->execute($where);
		if ($limit == 1)
			$result = $statement->fetch();
		else
			$result = $statement->fetchAll();
		
		return $result;
	}
	
	public function exists($table, $where = [])
	{
		$query = 'SELECT EXISTS(SELECT 1 FROM `'.$table.'`';
		$this->whereProcess($where, $query);
		$query .= ' LIMIT 1)';
		$statement = $this->connection->prepare($query);
		$statement->execute($where);
		if ($statement->fetchColumn()) 
			return true;
		return false;
	}
	
	public function delete($table, $where = [], $limit = -1)
	{
		$query = 'DELETE FROM `'.$table.'`';
		$this->whereProcess($where, $query);
		if ($limit > 0)
			$query .= ' LIMIT '.$limit;
		$statement = $this->connection->prepare($query);
		$statement->execute($where);
	}
	
	public function insert($table, $values)
	{
		$columnsString = '`'.implode('`, `', array_keys($values)).'`';
		$valuesString = ':'.implode(', :', array_keys($values));
		$statement = $this->connection->prepare('INSERT INTO '.$table.' ('.$columnsString.') VALUES ('.$valuesString.')');
		$statement->execute($values);
	}
	
	public function update($table, $values, $where = [], $limit = -1)
	{
		$query = 'UPDATE `'.$table.'` SET ';
		$i = 0;
		foreach ($values AS $column => $value) {
			if ($i++ > 0) 
				$query .= ' AND';
			$query .= ' `'.$column.'` = :'.$column;
		}
		$this->whereProcess($where, $query);
		if ($limit > 0)
			$query .= ' LIMIT '.$limit;
		$statement = $this->connection->prepare($query);
		$statement->execute($values + $where);
	}
}
