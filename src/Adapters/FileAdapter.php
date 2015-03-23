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

use \Rox\Exception;
use \Rox\Cache\Adapter;

/**
 * Filesystem based cache adapter
 *
 * @package Rox
 */
class FileAdapter extends Adapter {

	/**
	 * Constructor
	 *
	 * @param array $config
	 */
	public function __construct($config = []) {
		parent::__construct(array_merge(['path' => '/tmp'], $config));

		if (!is_dir($this->_config['path'])) {
			throw new Exception('Cache path does not exists');
		}
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
		$expires = is_string($expires) ? strtotime($expires) : time() + $expires;
		$serializedData = serialize($data);

		$fp = fopen($this->_config['path'] . '/' . sha1($key) . '.roxcache', 'w');
		flock($fp, LOCK_EX);
		fwrite($fp, pack('N', $expires));
		fwrite($fp, pack('N', strlen($serializedData)));
		fwrite($fp, $serializedData);
		flock($fp, LOCK_UN);
		fclose($fp);
	}

	/**
	 * Retrieves cached data for a given key
	 * 
	 * @param string $key  The cache key
	 * @return mixed
	 */
	public function read($key) {
		$fp = @fopen($this->_config['path'] . '/' . sha1($key) . '.roxcache', 'r');
		if ($fp === false) {
			return false;
		}

		flock($fp, LOCK_EX);

		$meta = unpack('Nexpires/Nlen', fread($fp, 8));
		if ($meta['expires'] < time()) {
			flock($fp, LOCK_UN);
			fclose($fp);
			$this->delete($key);
			return false;
		}

		$data = fread($fp, $meta['len']);

		flock($fp, LOCK_UN);
		fclose($fp);

		$data = unserialize($data);
		return $data;
	}

	/**
	 * Deletes a cache entry
	 * 
	 * @param string $key  The cache key
	 * @return boolean
	 */
	public function delete($key) {
		$path = $this->_config['path'] . '/' . sha1($key) . '.roxcache';

		if (!file_exists($path)) {
			return false;
		}

		return @unlink($path);
	}
}
