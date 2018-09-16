<?php

/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class StoreModule extends WeModule {
	public function welcomeDisplay() {
		header('Location: ' . $this->createWebUrl('goodsbuyer', array('direct' => 1)));
		exit();
	}
}
