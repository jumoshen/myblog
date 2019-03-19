<?php
namespace backend\models;

class RedisModel
{

	public function _initialize(){
		$this->redisHandle = $this->redisHandle();
	}

	public function redisHandle(){
		$redis = new \Redis();
		$redis->connect('23.83.251.75',6379);
		$redis->auth("lh951121");
		return $redis;
	}

	/**
	 * @desc 获取锁
	 * @param $key
	 * @param int $expire
	 * @return bool
	 */
	public function lock($key, $expire = 5){
		$redisHandle = $this->redisHandle();
		$hasLock     = $redisHandle->setnx($key, time() + $expire);
		if (!$hasLock) {
			$lockTime = $redisHandle->get($key);
			if (time() > $lockTime) {
				$this->unlock($key);
				$hasLock = $redisHandle->setnx($key, time() + $expire);
			}
		}
		return $hasLock ? true : false;
	}

	/**
	 * @desc 释放锁
	 * @param string $key
	 * @return int
	 */
	public function unlock($key = ''){
		$redisHandle = $this->redisHandle();
		return $redisHandle->del($key);
	}
}
