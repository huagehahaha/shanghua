<?php 
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('cloud');
load()->func('communication');

$do = !empty($_GPC['do']) && in_array($do, array('module', 'system')) ? $_GPC['do'] : exit('Access Denied');

$result = cloud_prepare();

if (is_error($result)) {
	message($result['message'], '', 'ajax');
}

if ($do == 'module') {
	$info = cloud_m_info(trim($_GPC['m']));
	if (is_error($info) && $info['errno'] == -10) {
		message($info, '', 'ajax');
	}
}