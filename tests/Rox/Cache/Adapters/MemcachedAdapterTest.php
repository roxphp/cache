<?php

namespace Rox\Cache\Adapters;

class MemcachedAdapterTest extends AbstractAdapterTest {

	protected $adapter;

	public function setup()
	{
		$this->adapter = new MemcachedAdapter();
	}

}