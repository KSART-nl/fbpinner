<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);

//"johngrogg/ics-parser": "dev-master"
require_once('vendor/autoload.php');
require_once('db.php');
require_once('config.php');
require_once('functions.php');

use ICal\ICal;

$url = 'https://www.facebook.com/ical/u.php?uid='.$facebook_uid.'&key='.$facebook_key;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
$data = curl_exec($curl);
curl_close($curl);
$ical = file_put_contents("fbevents.ics", $data);

$ical = new ICal('fbevents.ics');
$all_events = [];

foreach($ical->events() as $event) {

	$event = json_decode(json_encode($event),TRUE);

	//wrap_urls(clean_fb_event($event["description"]))
	//get_fb_event_url($event["description"])
	$facebook_event_id = get_fb_event_id($event["url"]);
	$select_event_query = "SELECT * FROM fbevents WHERE `facebook_event_id`='$facebook_event_id';";
	$select_event_result	= $mysqli->query($select_event_query);

	//Event already exists
	if ($mysqli->affected_rows > 0) {
		echo "Facebook event ".$facebook_event_id." already exists<br>";
		//print_r($event);
	} else if(!is_null($facebook_event_id) && is_numeric($facebook_event_id)) {
		echo "So you want to add the new Facebook event ".$facebook_event_id."<br>";

		$summary = real_safe($event["summary"]); //`SUMMARY`
		$dtstamp = real_safe($event["dtstamp"]); //`DTSTAMP`
		$lastmodified = real_safe($event["lastmodified"]); //`LAST-MODIFIED`
		$created = real_safe($event["created"]); //`CREATED`

		$sequence = real_safe($event["sequence"]); //`SEQUENCE`
		$organizer = real_safe($event["organizer"]); //`ORGANIZER`
		$mailto  = real_safe($event["uid"]); //`MAILTO`
		$dtstart = real_safe($event["dtstart"]); //`DTSTART`
		$dtend = real_safe($event["dtend"]); //`DTEND`

		$uid = real_safe($event["uid"]); //`UID`
		$location = real_safe($event["location"]); //`LOCATION`
		$url = real_safe($event["url"]); //`URL`
		$description = real_safe($event["description"]); //`URL`

		$insert_event_query = "INSERT INTO fbevents (
			`facebook_event_id`, `DTSTAMP`,`LAST-MODIFIED`, `CREATED`,
			`SEQUENCE`, `ORGANIZER`, `MAILTO`, `DTSTART`,`DTEND`,
			`UID`,`SUMMARY`,`LOCATION`,`URL`,`DESCRIPTION`
			) VALUES (
			'$facebook_event_id','$dtstamp','$lastmodified','$created',
			'$sequence','$organizer','$mailto','$dtstart','$dtend',
			'$uid','$summary','$location','$url','$description'
			)";
		echo $insert_event_query."<br>";
		$mysqli->query($insert_event_query);

		$all_events[] = [
			"facebook_event_id" => $facebook_event_id,
			"summary" => $summary,
			"dtstamp" => $dtstamp,
			"lastmodified" => $lastmodified,
			"created" => $created,
			"sequence" => $sequence,
			"organizer" => $organizer,
			"mailto" => $mailto,
			"dtstart" => $dtstart,
			"dtend" => $dtend,
			"uid" => $uid,
			"location" => $location,
			"url" => $url,
			"description" => $description
			];

	}

}

exec("php fieldmap.php");
//header("Content-Type: application/json;charset=utf-8");
//echo json_encode(array_utf8_encode($all_events));

























//"kigkonsult/icalcreator": "dev-master"
// $v = new vcalendar();
// //$v->setConfig('url', 'webcal://www.facebook.com/ical/u.php?uid=1673551095&key=AQDjJ60DnCAFsvo5');
// $config = array( "directory" => "calendar", "filename" => "fbevents.ics" );
// $v->setConfig($config); // set directory and file name
// $v->parse();
// $v->sort();

// while( $comp = $v->getComponent()) {
// 	print_r($comp);
// }