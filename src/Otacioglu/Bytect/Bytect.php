<?php namespace Otacioglu\Bytect;
/**
 * Bytect Class
 *
 * @package  Bytect
 * @author Orcun Otacioglu <otacioglu.orcun@gmail.com>
 * @link http://twitter.com/ootacioglu
 */
class Bytect implements BytectInterface, QueryInterface
{
	private $_driver,
			$_results,
			$_count = 0,
			$_error = false;

	/**
	 * Sets the dafault driver
	 * @param string $type 
	 */
	public function __construct($type)
	{
		if(!isset($type)) {
			return false;
		}

		strtolower($type);

		switch ($type) {
				case 'mysql':
					return $this->_driver = new MySQL();
					break;
				
				case 'mongodb':
					return true;
					break;
					
				default:
					return $this->_driver = new MySQL();
					break;
		}	
	}

	/**
	 * Create database
	 * @param  database name $dbName 
	 * @return void         
	 */
	public function create($dbName)
	{
		return $this->_driver->create($dbName);
	}

	/**
	 * Drop the given database
	 * @param  database name $dbName 
	 * @return void         
	 */
	public function drop($dbName)
	{
		return $this->_driver->drop($dbName);
	}

	/**
	 * Selects the given database
	 * @param  database name $dbName 
	 * @return void         
	 */
	public function select($dbName)
	{
		return $this->_driver->select($dbName);
	}

	/**
	 * The actual query to run
	 * @param  string $sql    SQL query
	 * @param  array  $params query parameters
	 * @return SQL        
	 */
	public function query($sql, $params = array())
	{
		return $this->_driver->query($sql, $params);
	}

	/**
	 * Insert objects to the database
	 * @param  string $table  table name
	 * @param  array  $fields fields to insert
	 * @return boolean         
	 */
	public function insert($table, $fields = array())
	{
		return $this->_driver->insert($table, $fields);
	}

	/**
	 * Retrieve fields from database
	 * @param  string $column column name
	 * @param  string $table  table name
	 * @param  array $where   query parameters
	 * @return object         
	 */
	public function get($column, $table, $where)
	{
		return $this->_driver->get($column, $table, $where);
	}

	/**
	 * Delete fields from database
	 * @param  string $table table name
	 * @param  array $where  query parameters
	 * @return void        
	 */
	public function delete($table, $where)
	{
		return $this->_driver->delete($table, $where);
	}

	/**
	 * Update table fields
	 * @param  string $table   table name
	 * @param  integer $id     object id
	 * @param  array $fields   fields to update
	 * @return boolean
	 */
	public function update($table, $id, $fields)
	{
		return $this->_driver->update($table, $id, $fields);
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