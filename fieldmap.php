<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);

//"johngrogg/ics-parser": "dev-master"
require_once('vendor/autoload.php');
require_once('db.php');
require_once('functions.php');


function find_town($location, $towns) {
	foreach ($towns as $town_key => $town) {
		$is_town = strpos($location, $town["town"]);
		//Town is found
		if ($is_town !== false) {
			return $town;
		}
	}
	return false;
}


$unfielded_query = "SELECT * FROM fbevents WHERE `is_field_mapped`=0;";
$unfielded_result	= $mysqli->query($unfielded_query);

$towns_array = [];
$towns_query = "SELECT * FROM towns";
$towns_result	= $kmysqli->query($towns_query);
if ($kmysqli->affected_rows > 0) {
	while($town = $towns_result->fetch_array()) {
		$towns_array[] = [
		"id"=> $town["id"], "town" => $town["town"], "province" => $town["province"], "country" => $town["country"]
		];
	}
}
//var_dump($towns_array);

if(count($towns_array)) {

	//Event exists
	if ($mysqli->affected_rows > 0) {
		while($unfielded_row = $unfielded_result->fetch_array()) {
			//var_dump($unfielded_row);

			$rand_color = rand_color();

			$found_town = find_town($unfielded_row["LOCATION"], $towns_array);

			//if($found_town) {
			
				/*'facebook_event_id' => $unfielded_row["facebook_event_id"],
				'DTSTAMP' => $unfielded_row["DTSTAMP"],
				'LAST-MODIFIED`' => $unfielded_row["LAST-MODIFIED"],
				'CREATED' => $unfielded_row["CREATED"],
				'SEQUENCE' => $unfielded_row["SEQUENCE"],
				'ORGANIZER' => $unfielded_row["ORGANIZER"],
				'MAILTO' => $unfielded_row["MAILTO"],
				'DTSTART' => $unfielded_row["DTSTART"],
				'DTEND' => $unfielded_row["DTEND"],
				'UID' => $unfielded_row["UID"],
				'SUMMARY' => $unfielded_row["SUMMARY"],
				'LOCATION' => $unfielded_row["LOCATION"],
				'URL' => $unfielded_row["URL"],
				'DESCRIPTION' => $unfielded_row["DESCRIPTION"],*/

				$facebook_event_id = $unfielded_row["facebook_event_id"];
				$allow = true;
				$user_id = 31;
				$user_name = "Iemand van KSART";
				$message = replace_carriage_return(" ", clean_fb_event($unfielded_row["DESCRIPTION"]));
				//'message' => clean_fb_event($unfielded_row["DESCRIPTION"]),
				$url = $unfielded_row["URL"];

				$color = $rand_color;
				$bright = lightness(hex2rgb($rand_color)) > 0.5 ? 0 : 1;

				$town = null;
				$province = null;
				$country = null;

				$created_at = get_ical_date($unfielded_row["CREATED"]);
				$updated_at = get_ical_date(!empty($unfielded_row["LAST-MODIFIED"]) ? $unfielded_row["LAST-MODIFIED"] : $unfielded_row["CREATED"]);

				
				//exit();
				
				$insert_pin_query = "INSERT INTO pins (allow,user_id,user_name,message,url,bright,color,created_at,updated_at)
				VALUES ($allow, $user_id, '$user_name', '$message', '$url', $bright, '$color', '$created_at', '$updated_at');";
				echo $insert_pin_query."<br><br>";
				$kmysqli->query($insert_pin_query);


				$is_fielded_querry = "UPDATE fbevents SET is_field_mapped=1 WHERE facebook_event_id='$facebook_event_id'";
				echo $is_fielded_querry."<br><br>";
				$mysqli->query($is_fielded_querry);
			//}

		}
	}
}

