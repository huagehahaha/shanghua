<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('cache');
load()->model('setting');
load()->object('cloudapi');

$_W['page']['title'] = '更新缓存 - 设置 - 系统管理';

if (checksubmit('submit', true)) {
	$cloud_api = new CloudApi();
	$cloud_cache_key = array(
		'key' => array(cache_system_key('module:all_uninstall'), cache_system_key('user_modules:' . $_W['uid']))
	);
	$cloud_api->post('cache', 'delete', $cloud_cache_key);
	$account_ticket_cache = cache_read('account:ticket');
	pdo_delete('core_cache');
	cache_clean();
	cache_write('account:ticket', $account_ticket_cache);
	unset($account_ticket_cache);

	cache_build_template();
	cache_build_users_struct();
	cache_build_module_status();
	cache_build_cloud_upgrade_module();
	cache_build_setting();
	cache_build_frame_menu();
	cache_build_module_subscribe_type();
	cache_build_cloud_ad();
	iajax(0, '更新缓存成功！', '');
}

template('system/updatecache');