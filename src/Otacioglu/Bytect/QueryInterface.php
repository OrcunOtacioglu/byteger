<?php namespace Otacioglu\Bytect;

interface QueryInterface
{
	public function query($sql, $params = array());

	public function insert($table, $fields = array());

	public function get($column, $table, $where);

	public function delete($table, $where);

	public function update($table, $id, $fields);

	public function results();

	public function first();

	public function error();

	public function count();
}