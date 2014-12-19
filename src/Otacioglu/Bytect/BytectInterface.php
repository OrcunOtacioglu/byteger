<?php namespace Otacioglu\Bytect;

interface BytectInterface
{
	/**
	 * Create new dataabase
	 * @param  database name $dbName Desired database name
	 * @return void         Creates the database with given name
	 */
	public function create($dbName);

	/**
	 * Drop the given database
	 * @param  database name $dbName 
	 * @return void        
	 */
	public function drop($dbName);

	/**
	 * Selects the given database
	 * @param  database name $dbName 
	 * @return void         
	 */
	public function select($dbName);
}