<?php

namespace Rox\Cache\Adapters;

/**
 * @requires extension memcache
 */
class MemcacheAdapterTest extends AbstractAdapterTest {

	protected $adapter;

	public function setup()
	{
		$this->adapter = new MemcacheAdapter();
	}

}