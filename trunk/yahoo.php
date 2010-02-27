<?php
//

$yahoo_api_key = "";

// The Yahoo! Web Services request

//The Geocoded details
//$req = 'http://local.yahooapis.com/MapsService/V1/geocode?appid=&zip=&state=UK&output=php';

//the image
$req =	"http://local.yahooapis.com/MapsService/V1/mapImage?"
			."appid=" . $yahoo_api_key
			."&zip="
			."&state=UK"
			."&zoom=3"
			."&image_type=gif"
			."&image_width=320"
			."&image_height=240"
			."&output=php";

	// Make the request
	//Get the CSV of the Lat & Long from postcode
	$curl_handle=curl_init();
	curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($curl_handle,CURLOPT_URL,$req);
	$latlong = curl_exec($curl_handle);
	curl_close($curl_handle);


	//$phpserialized = file_get_contents($req);
	// Parse the serialized response
	$phpobj = unserialize($latlong);
	echo '<pre>';
	print_r($latlong);
	echo '</pre>';
	echo '<pre>';
	print_r($phpobj);
	echo '</pre>';

   echo '<img src="'.$phpobj["Result"].'">';

?>


