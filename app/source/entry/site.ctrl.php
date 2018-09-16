<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */
 
defined('IN_IA') or exit('Access Denied');

$site = WeUtility::createModuleSite($entry['module']);
if(!is_error($site)) {
	$do_function = $site instanceof WeModuleSite ? 'doMobile' : 'doPage';
	$method = $do_function . ucfirst($entry['do']);
	exit($site->$method());
}
exit();