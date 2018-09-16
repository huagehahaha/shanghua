<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
isetcookie('__session', '', -10000);
isetcookie('__switch', '', -10000);

$forward = $_GPC['forward'];
if (empty($forward)) {
	$forward = './?refersh';
}
header('Location:' . url('user/login'));