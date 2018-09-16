<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */

class UnigroupTable extends We7Table {

	protected $tableName = 'uni_group';
	protected $primaryKey = 'id';

	
	public function uniaccounts() {
		return $this->belongsMany('account', 'uniacid', 'id', 'uni_account_group', 'uniacid', 'groupid');
	}


}