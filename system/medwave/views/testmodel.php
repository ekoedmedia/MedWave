<?php

class Report {
	
	protected $name;
	protected $value;
	protected $color;

	public function getName()
	{
		return $this->name;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function getColor()
	{
		return $this->color;
	}

	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	public function setValue($value)
	{
		$this->value = $value;
		return $this;
	}

	public function setColor($color)
	{
		$this->color = $color;
	}
}