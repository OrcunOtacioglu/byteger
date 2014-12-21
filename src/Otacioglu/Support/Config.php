<?php namespace Otacioglu\Support;
/**
 * Config Class
 *
 * @package  Bytect
 * @author Orcun Otacioglu <otacioglu.orcun@gmail.com>
 * @link http://twitter.com/ootacioglu
 */
class Config
{
	/**
	 * Returns the value of a given path
	 * @param  string $path index of an option inside the init file
	 * @return string      Returns the key of the given index
	 */
	public static function get($path = null)
	{
		
		if($path) {
			
			$config = $GLOBALS['config'];
			
			$path = explode('/', $path);

			foreach($path as $bit) {

				if(isset($config[$bit])) {

					$config = $config[$bit];
				}
			}

			return $config;
		}
	}
}