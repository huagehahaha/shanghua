<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

class MessageTable extends We7Table {

	public function messageList($type = '') {
		global $_W;

		if (!user_is_founder($_W['uid']) || user_is_vice_founder($_W['uid'])) {
			$this->query->where('uid', $_W['uid']);
		}

		if (user_is_founder($_W['uid']) && !user_is_vice_founder() && empty($type)) {
			$this->query->where('type !=', array(MESSAGE_USER_EXPIRE_TYPE, MESSAGE_WXAPP_MODULE_UPGRADE))->whereor('type', MESSAGE_WXAPP_MODULE_UPGRADE)->where('uid', $_W['uid']);
		}

		return $this->query->from('message_notice_log')->orderby('id', 'DESC')->getall();
	}

	public function messageRecord() {
		return $this->query->from('message_notice_log')->orderby('id', 'DESC')->get();
	}

	public function searchWithType($type) {
		$this->query->where('type', $type);
		return $this;
	}

	public function searchWithIsRead($is_read) {
		$this->query->where('is_read', $is_read);
		return $this;
	}

	public function messageNoReadCount() {
		global $_W;
		if (!user_is_founder($_W['uid']) || user_is_vice_founder($_W['uid'])) {
			$this->query->where('uid', $_W['uid']);
		}
		if (user_is_founder($_W['uid']) && !user_is_vice_founder()) {
			$this->query->where('type !=', array(MESSAGE_USER_EXPIRE_TYPE, MESSAGE_WXAPP_MODULE_UPGRADE))->whereor('type', MESSAGE_WXAPP_MODULE_UPGRADE)->where('uid', $_W['uid']);
		}
		$list =  $this->query->from('message_notice_log')->orderby('id', 'DESC')->getall();
		return count($list);
	}
}