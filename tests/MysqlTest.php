<?php
include __DIR__ . '/../src/start.php';

use Otacioglu\Bytect\MySQL;
use Otacioglu\Support\Config;

class MysqlTest extends PHPUnit_Framework_TestCase
{
	public $pdo,
		   $e;
	
	public function setUp()
	{
		$this->pdo = new MySQL();
		$this->e = new PDO('mysql:host=' . Config::get('mysql/host') . ';charset=' . Config::get('mysql/charset'), Config::get('mysql/username'), Config::get('mysql/password'));
	}

	public function testCreateDatabaseFailure()
	{
		$db = $this->pdo->create();
		$this->assertEquals(false, $db);
	}

	public function testCreateDatabase()
	{
		$db = $this->pdo->create('test');
		$expected = $this->e->query("CREATE DATABASE test");
		$this->assertEquals($db, $expected);
	}

	public function testDropDatabaseFailure()
	{
		$db = $this->pdo->drop();
		$this->assertEquals(false, $db);
	}

	public function testDropDatabase()
	{
		$db = $this->pdo->drop('test');
		$expected = $this->e->query("DROP DATABASE test");
		$this->assertEquals($db, $expected);
	}

	public function testSelectDatabaseFailure()
	{
		$db = $this->pdo->select();
		$this->assertEquals(false, $db);
	}
}