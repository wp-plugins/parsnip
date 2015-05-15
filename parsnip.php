<?php
/*
 Plugin Name: Parsnip
 Plugin URI: http://www.zingiri.com
 Description: Include snippets from other sites in your own site
 Author: Zingiri
 Version: 1.0.1
 Author URI: http://www.zingiri.com/
 */

require(dirname(__FILE__).'/includes/http.class.php');
require(dirname(__FILE__).'/includes/phpQuery/phpQuery.php');
add_shortcode( 'parsnip', 'parsnip_shortcode' );

function parsnip_shortcode( $atts, $content=null, $code="" ) {
	if (!is_page() && !is_single()) return '';

	$level=isset($_REQUEST['parsniplevel']) ? $_REQUEST['parsniplevel'] : 1;
	$scLevel=isset($atts['level']) ? $atts['level'] : 1;
	if (($level != $scLevel) && ($scLevel != '*')) {
		return;
	} 
	$output='';
	if (isset($atts['selectors'])) {
		$selectors=explode(',',$atts['selectors']);
	} else {
		$selectors=array('html');
	}
	if (isset($_REQUEST['parsnip'])) {
		$url=base64_decode($_REQUEST['parsnip']);
	} elseif (isset($atts['url'])) {
		$url=$atts['url'];
	} else {
		return;
	}
	$buffer=parsnip_output($url);
	phpQuery::newDocumentHTML($buffer);
	$output.='<div class="parsnip">';
	foreach ($selectors as $selector) {
		foreach (pq($selector) as $e) {
			$wrapper=pq('<div>');
			$output.=$wrapper->append(pq($e))->html();
		}
	}
	$output.='</div>';
	preg_match_all('/href="([^"]*)"/',$output,$matches);
	$link=get_permalink();
	$pre=isset($atts['pre']) ? $atts['pre'] :'';
	if (substr($pre,-1)!='/') $pre.='/';
	$link.='?parsniplevel='.($level+1).'&parsnip=';
	if (count($matches) > 0) {
		foreach ($matches[1] as $match) {
			if (isset($atts['nofollow']) && ($atts['nofollow'])) $output=str_replace($match,'#',$output);
			else $output=str_replace($match,$link.urlencode(base64_encode($pre.$match)),$output);
		}
	}
	return $output;
}

function parsnip_output($http) {
	global $post,$parsnip;
	global $wpdb;
	global $wordpressPageName;
	global $parsnip_loaded;

	$ajax=isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : false;

	$news = new parsnipHttpRequest($http,'parsnip');
	$news->noErrors=true;
	//$news->post=array('temp'=>'temp');

	if (!$news->curlInstalled()) {
		return "cURL not installed";
	} elseif (!$news->live()) {
		return "A HTTP Error occured";
	} else {
		$buffer=$news->DownloadToString(true,true);
		return $buffer;
	}
}

