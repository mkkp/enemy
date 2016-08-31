<?php

namespace Mkkp\Enemy;

class Entity
{
	/**
	 * @var array
	 */
	private $parts;

	public function __construct($parts)
	{
		$this->parts = $parts;
	}

	public function toString($glue = ' ')
	{
		return join(
			$glue,
			array_map(function($part) {
				return $part['title'];
			}, $this->parts)
		);
	}

	public function indexesString($glue = '/')
	{
		return join(
			$glue,
			array_map(function($part) {
				return $part['index'];
			}, $this->parts)
		);
	}
}
