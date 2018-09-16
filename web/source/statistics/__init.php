<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
if (in_array($action, array('app', 'setting'))) {
	define('FRAME', 'account');
}
if (in_array($action, array('account'))) {
	define('FRAME', 'system');
}
