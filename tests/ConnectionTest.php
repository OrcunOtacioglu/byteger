<?php
include __DIR__ . '/../config/init.php';
include __DIR__ . '/../src/Otacioglu/Support/Config.php';

use Otacioglu\Support\Config;

class ConnectionTest extends PHPUnit_Framework_TestCase
{
	public $driver;

	public function testDefaultDriver()
	{
		$this->driver = Config::get('defaultDriver');
		$this->assertEquals('mysql', $this->driver);
	}
}