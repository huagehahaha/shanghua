<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

class FansTable extends We7Table {
	public function fansAll($openids) {
		global $_W;
		return $this->query->from('mc_mapping_fans')
			->where('openid', $openids)
			->where('uniacid', $_W['uniacid'])
			->where('acid', $_W['acid'])
			->getall('openid');
	}
}