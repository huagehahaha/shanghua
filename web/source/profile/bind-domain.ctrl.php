<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$dos = array('bind_domain', 'delete');
$do = in_array($do, $dos) ? $do : 'bind_domain';

$_W['page']['title'] = '域名绑定';

if ($do == 'bind_domain') {
	if (checksubmit('submit')) {
		$bind_domain = trim($_GPC['bind_domain']);
		$special_domain = array('.com.cn', '.net.cn', '.gov.cn', '.org.cn', '.com.hk', '.com.tw');
		$bind_domain = str_replace($bind_domain, '.com', $bind_domain);
		$domain_array = explode('.', $bind_domain);
		if (count($domain_array) > 3 || count($domain_array) <2) {
			iajax(-1, '只支持一级域名和二级域名！');
		}
		$data = array('domain' => trim($_GPC['bind_domain']));
		uni_setting_save('bind_domain', iserializer($data));
		iajax(0, '更新成功！', referer());
	}
	template('profile/bind-domain');
}

if ($do == 'delete') {
	uni_setting_save('bind_domain', array());
	itoast('删除成功！', referer(), 'success');
}
