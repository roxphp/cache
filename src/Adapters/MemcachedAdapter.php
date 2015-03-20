<?php
/**
 * RoxPHP
 *
 * Copyright (C) 2008 - 2015 Ramon Torres
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2008 - 2015 Ramon Torres
 * @package Rox\Cache
 * @license The MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace Rox\Cache\Adapters;

use \Exception;

/**
 * Memcached cache adapter
 *
 * @package Rox
 */
class MemcachedAdapter extends \rox\cache\Adapter {

	protected $_config = array(
		'servers' => ['127.0.0.1:11211']
	);

	/**
	 * Memcache instance
	 *
	 * @var Memcache
	 */
	protected $_client;

	/**
	 * Constructor
	 *
	 * @param array $options
	 */
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->_initialize();
	}

	/**
	 * Initializes the Memcache object
	 *
	 * @return void
	 */
	protected function _initialize() {
		if (!class_exists('Memcached', false)) {
			throw new Exception('This cache adapter requires the php_memcached extension');
		}

		$this->_client = new \Memcached;
		foreach ($this->_config['servers'] as $server) {
			$parts = explode(':', $server);
			$this->_client->addServer($parts[0], isset($parts[1]) ? $parts[1] : 11211);
		}
	}

	/**
	 * Saves data to the cache
	 * 
	 * @param string $key  The cache key
	 * @param mixed $data  Data to be saved
	 * @param integer|string $expires  Expiration time in seconds or strtotime() friendly format
	 * @return boolean
	 */
	public function write($key, $data, $expires) {
		$expires = is_string($expires) ? strtotime($expires) : time() + $expires;
		return $this->_client->set($key, $data, $expires);
	}

	/**
	 * Retrieves cached data for a given key
	 * 
	 * @param string $key The cache key
	 * @return mixed
	 */
	public function read($key) {
		return $this->_client->get($key);
	}

	/**
	 * Deletes a cache entry
	 * 
	 * @param string $key The cache key
	 * @return boolean
	 */
	public function delete($key) {
		return $this->_client->delete($key);
	}
}
