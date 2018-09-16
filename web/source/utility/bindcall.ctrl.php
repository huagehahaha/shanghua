<?php 
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('module');

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$modulename = trim($_GPC['modulename']);
$callname = trim($_GPC['callname']);
$uniacid = intval($_GPC['uniacid']);
$_W['uniacid'] = intval($_GPC['uniacid']);

$args = $_GPC['args'];
$module_info = module_fetch($modulename);
if (empty($module_info)) {
	iajax(0, array());
}
$site = WeUtility::createModuleSite($modulename);
if (empty($site)) {
	iajax(0, array());
}
if (!method_exists($site, $callname)) {
	iajax(0, array());
}
$ret = @$site->$callname($args);
iajax(0, $ret);