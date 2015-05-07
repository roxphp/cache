<?php

namespace Rox\Cache\Adapters;

/**
 * @requires extension memcached
 */
class MemcachedAdapterTest extends AbstractAdapterTest {

	protected $adapter;

	public function setup()
	{
		$this->adapter = new MemcachedAdapter();
	}

}