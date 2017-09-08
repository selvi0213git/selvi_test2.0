<?php
/*
Plugin Name: KBoard 에스크원 상담 스킨
Plugin URI: http://www.cosmosfarm.com/wpstore/product/kboard-ask-one-skin
Description: KBoard 에스크원 상담 스킨입니다.
Version: 1.0
Author: 코스모스팜 - Cosmosfarm
Author URI: http://www.cosmosfarm.com/
*/

if(!defined('ABSPATH')) exit;

add_filter('kboard_skin_list', 'kboard_skin_list_ask_one', 10, 1);
function kboard_skin_list_ask_one($list){

	$skin = new stdClass();
	$skin->dir = dirname(__FILE__);
	$skin->url = plugins_url('', __FILE__);
	$skin->name = basename($skin->dir);

	$list[$skin->name] = $skin;

	return $list;
}
?>