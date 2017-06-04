<?php

function get_urls($string) {
	print_r($string); echo "<br>";
	//http://stackoverflow.com/questions/4275525/regex-for-urls-without-http-https-ftp
	preg_match_all('~(?<url>(https|http)?(:\/\/)?(www.)?(?:[\w-]+\.)[a-z]{2,})~', $string, $matches);
	print_r($matches);
	return $matches["url"];
}

function wrap_urls($text){
	$reg_exUrl = "/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}(\/\S*)?/";
	//$reg_exUrl = '~(?<url>(https|http)?(:\/\/)?(www.)(?:[\w-]+\.)[a-z]{2,})~';
	
	preg_match_all($reg_exUrl, $text, $matches);
	$usedPatterns = array();
	foreach($matches[0] as $pattern){
	  if(!array_key_exists($pattern, $usedPatterns)){
      $usedPatterns[$pattern]=true;
      $text = str_replace($pattern, '<a href="'.$pattern.'" rel="nofollow">'.$pattern.'</a> ', $text);
	  }
	}
	return $text;            
}

function get_fb_event_url($string) {
	preg_match("~(?<fbeventurl>https:\/\/www\.facebook\.com\/events\/\d+\/)~", $string, $match);
	return $match["fbeventurl"];
}

function get_fb_event_id($string) {
	preg_match("~https:\/\/www.facebook.com\/events\/(?<fbeventid>\d+)(\/)?~", $string, $match);
	return isset($match["fbeventid"]) ? $match["fbeventid"] : false;
}

function clean_fb_event($string) {
	return preg_replace("~https:\/\/www\.facebook\.com\/events\/\d+\/~", "", $string);
}

function get_ical_date($date) {
	$date = str_replace('T', '', $date); //remove T
  $date = str_replace('Z', '', $date); //remove Z
  $d    = date('d', strtotime($date)); //get date day
  $m    = date('m', strtotime($date)); //get date month
  $y    = date('Y', strtotime($date)); //get date year
  $now = date('Y-m-d G:i:s'); //current date and time
  $eventdate = date('Y-m-d G:i:s', strtotime($date)); //user friendly date
  return $eventdate;
}

function array_utf8_encode($dat) {
  if (is_string($dat))
      return utf8_encode($dat);
  if (!is_array($dat))
      return $dat;
  $ret = array();
  foreach ($dat as $i => $d)
      $ret[$i] = array_utf8_encode($d);
  return $ret;
}

function real_safe($string) {
	$string = addslashes($string);
	return $string;
}

function rand_color() {
	return sprintf('%06X', mt_rand(0, 0xFFFFFF));
}

function lightness($rgb) {
	$R = $rgb["r"];
	$G = $rgb["g"];
	$B = $rgb["b"];

	return (max($R, $G, $B) + min($R, $G, $B)) / 510.0; // HSL algorithm
}

function hex2rgb($hex) {
	//echo $hex;

	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
	  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
	  $r = hexdec(substr($hex,0,2));
	  $g = hexdec(substr($hex,2,2));
	  $b = hexdec(substr($hex,4,2));
	}
	$rgb = ["r" => $r, "g" => $g, "b" => $b];
	//var_dump($rgb);
	//return implode(",", $rgb); // returns the rgb values separated by commas
	return $rgb; // returns an array with the rgb values
}

function replace_carriage_return($replace, $string) {
	return str_replace(array("\n\r", "\n", "\r"), $replace, $string);
}