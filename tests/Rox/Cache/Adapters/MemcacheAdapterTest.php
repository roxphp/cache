<?php

namespace Rox\Cache\Adapters;

class MemcacheAdapterTest extends AbstractAdapterTest {

	protected $adapter;

	public function setup()
	{
		$this->adapter = new MemcacheAdapter();
	}

}