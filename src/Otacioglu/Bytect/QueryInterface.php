<?php namespace Otacioglu\Bytect;

interface QueryInterface
{
	public function query();

	public function insert();

	public function get();

	public function delete();

	public function update();
}