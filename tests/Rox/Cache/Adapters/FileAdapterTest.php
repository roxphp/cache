<?php

namespace Rox\Cache\Adapters;

class FileTest extends AbstractAdapterTest {

	protected $adapter;

	public function setup()
	{
		$this->adapter = new FileAdapter();
	}

}