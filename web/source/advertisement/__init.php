<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
define('FRAME', 'advertisement');
if ($do == 'display') {
	define('ACTIVE_FRAME_URL', url('advertisement/content-provider/account_list'));
}

