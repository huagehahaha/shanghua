<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class ImagesModuleProcessor extends WeModuleProcessor {
	public function respond() {
		global $_W;
		$rid = $this->rule;
		$sql = "SELECT `mediaid` FROM " . tablename('images_reply') . " WHERE `rid`=:rid";
		$mediaid = pdo_fetchcolumn($sql, array(':rid' => $rid));
		if (empty($mediaid)) {
			return false;
		}
		return $this->respImage($mediaid);
	}
}
