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

class MySQL implements BytectInterface
{

	private $_pdo;

	/**
	 * Create the server connection 
	 */
	public function __construct()
	{
		try{
			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';charset=' . Config::get('mysql/charset'), Config::get('mysql/username'), Config::get('mysql/password'));
			echo 'Connection successfull';
		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}

	/**
	 * Create MySQL Database
	 * @param  string $dbName database name
	 * @return void         Creates the database with given name
	 */
	public function create($dbName) {

		if(!isset($dbName)) {
			return false;
		}

		$sql = "CREATE DATABASE {$dbName}";
	
		return $this->_pdo->query($sql);
	}

	/**
	 * Drop MySQL Database
	 * @param  string $dbName database name
	 * @return void         Drops the database
	 */
	public function drop($dbName) {

		if(!isset($dbName)) {
			return false;
		}

		$sql = "DROP DATABASE {$dbName}";

		return $this->_pdo->query($sql);
	}

	/**
	 * Select MySQL Database
	 * @param  string $dbName database name
	 * @return void         Selects the database
	 */
	public function select($dbName) {

		if(!isset($dbName)) {
			return false;
		}

		$this->_pdo = null;

		try{
			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . $dbName . ';charset=' . Config::get('mysql/charset'), Config::get('mysql/username'), Config::get('mysql/password'));
			return "Selecting database: {$dbName} is successfull.";
		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}
}