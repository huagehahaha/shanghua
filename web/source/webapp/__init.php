<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

if ($action == 'manage' && $do == 'create_display') {
	define('FRAME', 'system');
}

$account_api = WeAccount::create();

if ($action != 'manage' && $do != 'switch') {
	if (is_error($account_api)) {
		message($account_api['message'], url('webapp/manage/list'));
	}
	$check_manange = $account_api->checkIntoManage();
	if (is_error($check_manange)) {
		$account_display_url = $account_api->accountDisplayUrl();
		itoast('', $account_display_url);
	}
}

if ($action == 'manage' && $do == 'list' || $do != 'display') {
	define('FRAME', '');
} elseif ($do == 'display') {
	define('FRAME', 'webapp');
} else {
	$account_type = $account_api->menuFrame;
	define('FRAME', $account_type);
}
