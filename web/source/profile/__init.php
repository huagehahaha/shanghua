<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

if (strexists($_W['siteurl'], 'c=profile&a=module&do=setting')) {
	$other_params = parse_url($_W['siteurl'], PHP_URL_QUERY);
	$other_params = str_replace('c=profile&a=module&do=setting', '', $other_params);
	itoast('', url('module/manage-account/setting'). $other_params, 'info');
}

$account_api = WeAccount::create();
if (is_error($account_api)) {
	message($account_api['message'], url('account/display'));
}
$check_manange = $account_api->checkIntoManage();

if (is_error($check_manange)) {
	$account_display_url = $account_api->accountDisplayUrl();
	itoast('', $account_display_url);
}
$account_type = $account_api->menuFrame;
define('FRAME', $account_type);
