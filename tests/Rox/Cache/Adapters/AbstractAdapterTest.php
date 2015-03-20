<?php

namespace Rox\Cache\Adapters;

abstract class AbstractAdapterTest extends \PHPUnit_Framework_TestCase {

	protected $adapter;

	public function testRead()
	{
		$this->adapter->delete('test-key');
		$this->assertFalse($this->adapter->read('test-key'));
		$this->adapter->write('test-key', "Hello", '+10 minutes');
		$this->assertEquals("Hello", $this->adapter->read('test-key'));
	}
}