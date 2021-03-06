<?php namespace Otacioglu\Bytect;
/**
 * MySQL Database Class
 *
 * CRUD MySQL Databases
 * 
 * @package Bytect
 * @author Orcun Otacioglu <otacioglu.orcun@gmail.com>
 * @link http://twitter.com/ootacioglu
 */
use Otacioglu\Support\Config;
use PDO;
use PDOException;

class MySQL implements BytectInterface, QueryInterface
{

	private $_pdo,
			$_query,
			$_results,
			$_count = 0,
			$_error = false;

	/**
	 * Create the driver connection.
	 */
	public function __construct()
	{
		try{
			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';charset=' . Config::get('mysql/charset'), Config::get('mysql/username'), Config::get('mysql/password'));
		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}

	/**
	 * Create MySQL Database
	 * @param  string $dbName database name
	 * @return void         Creates the database with given name
	 */
	public function create($dbName = null) 
	{

		if(isset($dbName)) {
			
			$sql = "CREATE DATABASE {$dbName}";
	
			return $this->_pdo->query($sql);
		}
		return false;
	}

	/**
	 * Drop MySQL Database
	 * @param  string $dbName database name
	 * @return void         Drops the database
	 */
	public function drop($dbName = null) 
	{

		if(isset($dbName)) {
	
			$sql = "DROP DATABASE {$dbName}";

			return $this->_pdo->query($sql);
		}
		return false;
	}

	/**
	 * Select MySQL Database
	 * @param  string $dbName database name
	 * @return void         Selects the database
	 */
	public function select($dbName) 
	{
		return $this->_pdo->exec("USE {$dbName}");
	}

	/**
	 * Create a MySQL database table
	 * @param  string $tableName table name
	 * @return void            
	 */
	public function createTable($tableName)
	{
		$sql = "CREATE TABLE {$tableName}(
			ID INT(1) AUTO_INCREMENT PRIMARY KEY
		);";

		try{
			$this->_pdo->exec($sql);
		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}

	/**
	 * Drop an existing database table
	 * @param  string $tableName table name
	 * @return void            
	 */
	public function dropTable($tableName)
	{
		$sql = "DROP TABLE {$tableName}";
		try{
			$this->_pdo->exec($sql);
		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}

	/**
	 * Query MySQL commands
	 * @param  string $sql    actual sql query
	 * @param  array  $params query parameters
	 * @return MySQL         
	 */
	public function query($sql, $params = array())
	{
		$this->_error = false;

		if($this->_query = $this->_pdo->prepare($sql)) {
			if(count($params)) {
				$x = 1;
				foreach($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}

			if($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}
		}
		return $this;
	}

	/**
	 * Perform the selected SQL queries
	 * @param  string $action choose the query action
	 * @param  string $table  table name
	 * @param  array  $where  query parameters
	 * @return object         
	 */
	public function action($action, $table, $where = array())
	{
		if(count($where === 3)) {
			$operators = array('=', '>', '<', '>=', '<=');
			$field    = $where[0];
			$operator = $where[1];
			$value    = $where[2];

			if(in_array($operator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql, array($value))->error()) {

					return $this;
				}
			}
		}
		return false;
	}

	/**
	 * Get the selected rows
	 * @param  string $table table name
	 * @param  string $column
	 * @param  array $where query parameters
	 * @return void        
	 */
	public function get($column, $table, $where)
	{
		return $this->action("SELECT {$column}" , $table, $where);
	}

	/**
	 * Delete the selected rows
	 * @param  string $table table name
	 * @param  array $where query parameters
	 * @return void        
	 */
	public function delete($table, $where)
	{
		return $this->action('DELETE', $table, $where);
	}

	/**
	 * Insert objects to database
	 * @param  string $table  table name
	 * @param  array  $fields fields to insert into Database
	 * @return boolean        
	 */
	public function insert($table, $fields = array())
	{
		if(count($fields)) {
			$keys = array_keys($fields);
			$values = '';
			$x = 1;
			foreach($fields as $field){

				$values .= "?";

				if($x < count($fields)) {

					$values .= ', ';
				}

				$x++;
			}

			$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

			if(!$this->query($sql, $fields)->error()){

				return true;
			}
		}

		return false;
	}

	/**
	 * Update selected columns and rows
	 * @param  string $table  table name
	 * @param  integer $id     record id
	 * @param  array $fields fields to update
	 * @return boolean        
	 */
	public function update($table, $id, $fields)
	{
		$set = '';

		$x = 1;

		foreach($fields as $index => $value) {

			$set .= "{$index} = ?";

				if($x < count($fields)) {

					$set .= ', ';
				}

			$x++;
		}

		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

		if(!$this->query($sql, $fields)->error()) {

			return true;
		}

		return false;
	}

	/**
	 * Returns query results
	 * @return object 
	 */
	public function results()
	{
		return $this->_results;
	}

	/**
	 * Returns the first result
	 * @return object 
	 */
	public function first()
	{
		return $this->results()[0];
	}

	/**
	 * Returns the errors
	 * @return boolean 
	 */
	public function error()
	{
		return $this->_error;
	} 

	/**
	 * The amount of objects that are returned from database
	 * @return integer 
	 */
	public function count()
	{
		return $this->_count;
	}
}