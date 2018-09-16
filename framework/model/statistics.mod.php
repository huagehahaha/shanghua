<?php
/**
 * [ShangHua System] Copyright (c) 2018 AAYKK
 * ShangHua is NOT a free software, it under the license terms, visited http://www.aaykk.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function stat_visit_info($type, $module = '', $daterange = array(), $is_system_stat = false) {
	global $_W;
	$result = array();
	if (empty($type)) {
		return $result;
	}
	$params = array();
	if (empty($is_system_stat)) {
		$params['uniacid'] = $_W['uniacid'];
	}
	if (!empty($module)) {
		$params['module'] = $module;
	}
	switch ($type) {
		case 'today':
			$params['date'] = date('Ymd');
			break;
		case 'yesterday':
			$params['date'] = date('Ymd', strtotime('-1 days'));
			break;
		case 'week':
			$params['date >'] = date('Ymd', strtotime('-7 days'));
			$params['date <='] = date('Ymd');
			break;
		case 'month':
			$params['date >'] = date('Ymd', strtotime('-30 days'));
			$params['date <='] = date('Ymd');
			break;
		case 'daterange':
			if (empty($daterange)) {
				return stat_visit_info('month', $module, array(), $is_system_stat);
			}
			$params['date >='] = date('Ymd', strtotime($daterange['start']));
			$params['date <='] = date('Ymd', strtotime($daterange['end']));
			break;
	}
	$visit_info = pdo_getall('stat_visit', $params, array('uniacid', 'module', 'count', 'date'), '', 'date ASC');
	if (!empty($visit_info)) {
		$result = $visit_info;
	}
	return $result;
}


function stat_visit_info_byuniacid($type, $module = '', $daterange = array(), $is_system_stat = false) {
	$result = array();
	$visit_info = stat_visit_info($type, $module, $daterange, $is_system_stat);
	if (empty($visit_info)) {
		return $result;
	}
	foreach ($visit_info as $info) {
		if ($is_system_stat) {
			if (empty($info['uniacid'])) {
				continue;
			}
			if ($result[$info['uniacid']]['uniacid'] == $info['uniacid']) {
				$result[$info['uniacid']]['count'] += $info['count'];
				$result[$info['uniacid']]['highest'] = $result[$info['uniacid']]['highest'] >= $info['count'] ? $result[$info['uniacid']]['highest'] : $info['count'];
			} else {
				$result[$info['uniacid']] = $info;
				$result[$info['uniacid']]['highest'] = $info['count'];
			}
		} else {
			if (empty($info['module'])) {
				continue;
			}
			if ($result[$info['module']]['module'] == $info['module']) {
				$result[$info['module']]['count'] += $info['count'];
				$result[$info['module']]['highest'] = $result[$info['module']]['highest'] >= $info['count'] ? $result[$info['module']]['highest'] : $info['count'];
			} else {
				$result[$info['module']] = $info;
				$result[$info['module']]['highest'] = $info['count'];
			}
		}
	}
	$modules = stat_modules_except_system();
	$count = count($modules);
	foreach ($result as $key => $val) {
		$result[$key]['avg'] = round($val['count'] / $count);
	}
	return $result;
}


function stat_visit_info_bydate($type, $module = '', $daterange = array(), $is_system_stat = false) {
	$result = array();
	$visit_info = stat_visit_info($type, $module, $daterange, $is_system_stat);
	if (empty($visit_info)) {
		return $result;
	}
	$count = stat_account_count();
	foreach ($visit_info as $info) {
		if (empty($info['uniacid']) || empty($info['date'])) {
			continue;
		}
		if ($result[$info['date']]['date'] == $info['date']) {
			$result[$info['date']]['count'] += $info['count'];
			$result[$info['date']]['highest'] = $result[$info['date']]['highest'] >= $info['count'] ? $result[$info['date']]['highest'] : $info['count'];
		} else {
			unset($info['module'], $info['uniacid']);
			$result[$info['date']] = $info;
			$result[$info['date']]['highest'] = $info['count'];
		}
	}
	if (empty($result)) {
		return $result;
	}
	foreach ($result as $key => $val) {
		$result[$key]['avg'] = round($val['count'] / $count);
	}
	return $result;
}



function stat_all_visit_statistics($type, $data) {
	if ($type == 'current_account') {
		$modules = stat_modules_except_system();
		$count = count($modules);
	} elseif ($type == 'all_account') {
		$count = stat_account_count();
	}
	$result = array(
		'visit_sum' => 0,
		'visit_highest' => 0,
		'visit_avg' => 0
	);
	if (empty($data)) {
		return $result;
	}
	foreach ($data as $val) {
		$result['visit_sum'] += $val['count'];
		if ($result['visit_highest'] < $val['count']) {
			$result['visit_highest'] = $val['count'];
		}

	}
	$result['visit_avg'] = round($result['visit_sum'] / $count);
	return $result;
}


function stat_modules_except_system() {
	$modules = uni_modules();
	if (!empty($modules)) {
		foreach ($modules as $key => $module) {
			if (!empty($module['issystem'])) {
				unset($modules[$key]);
			}
		}
	}
	return $modules;
}

function stat_account_count() {
	$count = 0;
	$account_table = table('account');
	$account_table->searchWithType(array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH));
	$account_table->accountRankOrder();
	$account_list = $account_table->searchAccountList();
	$count = count($account_list);
	return $count;
}


function stat_date_range($start, $end) {
	$result = array();
	if (empty($start) || empty($end)) {
		return $result;
	}
	$start = strtotime($start);
	$end = strtotime($end);
	$i = 0;
	while(strtotime(end($result)) < $end) {
		$result[] = date('Ymd', $start + $i * 86400);
		$i++;
	}
	return $result;
}
