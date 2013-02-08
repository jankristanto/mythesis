<?php

/** 
 * Dead simple LRU cache making use of the natural 
 * array ordering. 
 *
 * @author Ian Barber http://phpir.com
 */
class LRUArray implements ArrayAccess {
	const CLEAN_PERCENT = 5;
	
	private $data = array(); 
	private $size; 
	private $cleanAmount;
	private $count = 0;
	
	/**
	 * Constructor, specify the maximum cache size
	 *
	 * @param size int - the maximum cache size
	 */
	public function __construct($size = 400000) {
		$this->size = $size;
		$this->cleanAmount = ceil($size/self::CLEAN_PERCENT);
	}
	
	/** 
	 * Array isset()
	 *
	 * @param $key mixed the array key
	 */
	public function offsetExists($key) {
		return isset($this->data[$key]);
	}
	
	/**
	 * Retrieve from array. Reorders the array to 
	 * put this to the end. 
	 * 
 	 * @param $key mixed the array key
 	 */
	public function offsetGet($key) {
		$value = $this->data[$key];
		unset($this->data[$key]);
		$this->data[$key] = $value;
		return $value;
	}
	
	/**
	 * Set a value in the array. If there are
	 * too many items, dump the Least Recently Used.
	 * 
 	 * @param $key mixed the array key
 	 */
	public function offsetSet($key, $value) {
		$this->count++;
		if($this->count > $this->size) {
			$this->resize();
		}
		$this->data[$key] = $value;
	}
	
	/**
	 * Unset a value in the array.
	 * 
 	 * @param $key mixed the array key
 	 */
	public function offsetUnset($key) {
		unset($this->data[$key]);
	}
	
	/**
	 * Discard a percentage of the currently stored data. 
	 */
	protected function resize() {
		$i = 0;
		array_splice($this->data, 0, $this->cleanAmount);
		$this->count -= $this->cleanAmount;
	}
	
}