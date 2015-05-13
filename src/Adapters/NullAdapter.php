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

use Rox\Cache\Adapter;

/**
 * Null cache adapter
 *
 * @package Rox
 */
class NullAdapter extends Adapter {

	/**
	 * Constructor
	 *
	 * @param array $config
	 */
	public function __construct($config = []) {
		// Noop
	}

	/**
	 * Stores data into the cache
	 * 
	 * @param string $key  The cache key
	 * @param mixed $data  Data to be saved
	 * @param integer|string $expires  Expiration time in seconds or strtotime() friendly format
	 * @return boolean
	 */
	public function write($key, $data, $expires) {
		// Noop
	}

	/**
	 * Retrieves cached data for a given key
	 * 
	 * @param string $key  The cache key
	 * @return mixed
	 */
	public function read($key) {
		// Always miss
		return false;
	}

	/**
	 * Deletes a cache entry
	 * 
	 * @param string $key  The cache key
	 * @return boolean
	 */
	public function delete($key) {
		return true;
	}
}
