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

namespace Rox\Cache;

/**
 * Abstract class for cache adapters
 *
 * @package Rox
 */
abstract class Adapter {

	protected $_config = [];

	public function __construct($config) {
		$this->_config += $config;
	}

	/**
	 * Saves data to the cache
	 * 
	 * @param string $key  The cache key
	 * @param mixed $data  Data to be saved
	 * @param integer|string $expires  Expiration time in seconds or strtotime() friendly format
	 * @return boolean
	 */
	abstract public function write($key, $data, $expires);

	/**
	 * Retrieves cached data for a given key
	 * 
	 * @param string $key  The cache key
	 * @return mixed
	 */
	abstract public function read($key);

	/**
	 * Deletes a cache entry
	 * 
	 * @param string $key  The cache key
	 * @return boolean
	 */
	abstract public function delete($key);
}
