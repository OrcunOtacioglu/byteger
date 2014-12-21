#Bytect Package
[![Build Status](https://travis-ci.org/OrcunOtacioglu/bytect.svg?branch=master)](https://travis-ci.org/OrcunOtacioglu/bytect)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/OrcunOtacioglu/bytect/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/OrcunOtacioglu/bytect/?branch=master)

Bytect package currently supoorts only MySQL driver. You can extend the package whatever driver you are using.

Requirements
------------

You need **PHP >= 5.3.0** and the `pdo_mysql` extension to use this.

Configuration
-------------

You need to set the default driver and its connection information in `config/init.php`. By default the default driver is MySQL.

```
<?php
//init.php file
$GLOBALS['config'] = array(
	'defaultDriver' => 'mysql', #Set the default driver here
	'mysql' => array(
		'host' => '127.0.0.1', //Connection informations
		'username' => 'root',
		'password' => '',
		'charset'  => 'utf8'
	)
);
?>
```

Usage
-----
####Setting Up

```
<?php
#Get the default driver first.
$defaultDriver = Config::get('defaultDriver');

#Then instantiate the object using defaultDriver
$bytect = new Bytect($defaultDriver);
?>
```

####CRUD Database

```
<?php
# To create database
$bytect->create($databaseName);

# To drop a database
$bytect->drop($databaseName);

# To select a database
$bytect->select($databaseName);

?>
```

####CRUD Database Tables
```
<?php

# To create a table
$bytect->createTable($tableName);

# To drop a table
$bytect->dropTable($tableName);

?>
```

####CRUD Objects into Tables

You can create, retrieve, update and delete fields from a database table.

```
<?php
# To insert objects into table
# i.e insert('table', (
# 	'username' => 'Orcun',
# 	'age'      => 23
# ))
$bytect->insert($table, $fields);

# To retrieve objects from table
# i.e get('username', 'table', ('age', '>=', 21))
$bytect->get($column, $table, $where)->results();

# To delete objects from a table
# i.e delete('table', ('username', '=', 'Orcun'))
$bytect->delete($table, $where);

# To update existing objects in a table
# i.e update('table', 1, (
# 	'username' => 'Something else',
# 	'age'      => 15
# ))
$bytect->update($table, $id, $fields);
?>
```

License
-------
The MIT License (MIT). Please see [License File](LICENSE) for more information.