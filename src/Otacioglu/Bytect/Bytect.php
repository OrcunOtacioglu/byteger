<?php namespace Otacioglu\Bytect;
/**
 * Bytect Class
 *
 * @package  Bytect
 * @author Orcun Otacioglu <otacioglu.orcun@gmail.com>
 * @link http://twitter.com/ootacioglu
 */
class Bytect
{
	private $driver;

	/**
	 * Sets the default database driver.
	 * @param Config $type Get the specified driver type from init file.
	 */
	public function __construct($type)
	{
		if(!isset($type)) {
			return false;
		}

		strtolower($type);

		switch ($type) {
				case 'mysql':
					$this->driver = new MySQL();
					break;
				
				default:
					$this->driver = new MySQL();
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
		$this->driver->create($dbName);
	}

	/**
	 * Drop the given database
	 * @param  database name $dbName 
	 * @return void         
	 */
	public function drop($dbName)
	{
		$this->driver->drop($dbName);
	}

	/**
	 * Selects the given database
	 * @param  database name $dbName 
	 * @return void         
	 */
	public function select($dbName)
	{
		$this->driver->select($dbName);
	}
}