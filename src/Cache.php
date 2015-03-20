<?php
/**
 * RoxPHP
 *
 * Copyright (C) 2008 - 2011 Ramon Torres
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2008 - 2011 Ramon Torres
 * @package Rox\Cache
 * @license The MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace Rox\Cache;

/**
 * Cache static class
 *
 * @package Rox
 */
class Cache {

	const ADAPTER_FILE     = '\Rox\Cache\Adapters\FileAdapter';
	const ADAPTER_MEMCACHE = '\Rox\Cache\Adapters\MemcacheAdapter';

	protected static $_config = [
		'adapter' => self::ADAPTER_FILE
	];

	/**
	 * Cache adapter instance
	 *
	 * @var Cache_Adapter
	 */
	private static $_adapter;

	/**
	 * Initializes the cache class
	 *
	 * @param array $config
	 * @return void
	 */
	public static function init($config = array()) {
		static::$_config = ($config + static::$_config);
	}

	/**
	 * Saves data to the cache
	 * 
	 * @param string $key  The cache key
	 * @param mixed $data  Data to be saved
	 * @param integer|string $expires  Expiration time in seconds or strtotime() friendly format
	 * @return boolean
	 */
	public static function write($key, $data, $expires) {
		return static::_adapter()->write($key, $data, $expires);
	}

	/**
	 * Retrieves cached data for a given key
	 * 
	 * @param string $key The cache key
	 * @return mixed
	 */
	public static function read($key) {
		return static::_adapter()->read($key);
	}

	/**
	 * Retrieves data by key or executes $callback in case of cache miss. Data returned
	 * by $callback is then cached.
	 *
	 *     \Rox\Cache::fetch('my_key', '+1 hour', function(){
	 *         // some expensive operation
	 *         return $results;
	 *     });
	 *
	 * @param string $key 
	 * @param string $expires expiration time in seconds or strtotime() compatible string
	 * @param \Closure $callback closure to be executed on cache miss
	 * @return mixed
	 */
	public static function fetch($key, $expires, \Closure $callback) {
		$data = static::read($key);
		if ($data === false) {
			$data = $callback->__invoke();
			static::write($key, $data, $expires);
		}

		return $data;
	}

	/**
	 * Deletes a cache entry
	 * 
	 * @param string $key The cache key
	 * @return boolean
	 */
	public static function delete($key) {
		return static::_adapter()->delete($key);
	}

	protected static function _adapter() {
		if (static::$_adapter === null) {
			static::$_adapter = new static::$_config['adapter'](static::$_config);
		}
		return static::$_adapter;
	}
}
