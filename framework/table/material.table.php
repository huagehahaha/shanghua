<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

class MaterialTable extends We7Table {
	public function materialNewsList($attch_id) {
		$this->query->from('wechat_news')
			->where('attach_id', $attch_id)
			->orderby('displayorder', 'ASC');
		return $this->query->getall();
	}
}