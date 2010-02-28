<?php
	//Global Keys
	
	//APIs
	$yahoo_api_key = "";
	$google_maps_api_key = "";
	$twfy_api_key = "";

	//mySQL
	$mySQL_username="";
	$mySQL_password="";
	$mySQL_database="";
	//
	
	function getREST($url)
	{
		$curl_handle=curl_init();
		curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl_handle,CURLOPT_URL,$url);
		$response = curl_exec($curl_handle);
		curl_close($curl_handle);
		
		return $response;
	}
	
	function daysUntilElection()
	{
		// Get current time
		$todaysDate = time();
	
		// Get the timestamp of 2010 June 03
		$electionDate = mktime(0,0,0,06,03,2010);

		$dateDiff = $electionDate - $todaysDate;

		$fullDays = floor($dateDiff/(60*60*24));

		return $fullDays;
	}	

	function formatPostcode($postcode)
	{
		//We want W1A 1AA.  Last part is always 3 chars
		//Remove Spaces
		$postcode = str_replace(" ", "", $postcode);
		
		$post_out = substr($postcode, -3);

		$post_in = substr($postcode, 0, -3);

		return strtoupper($post_in . " " . $post_out);
	}

	function validPostcode($postcode) 
	{
		$postcode = strtoupper($postcode);
		if(ereg("((GIR 0AA)|(TDCU 1ZZ)|(ASCN 1ZZ)|(BIQQ 1ZZ)|(BBND 1ZZ)"
		."|(FIQQ 1ZZ)|(PCRN 1ZZ)|(STHL 1ZZ)|(SIQQ 1ZZ)|(TKCA 1ZZ)"
		."|[A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]"
		."|[A-HK-Y][0-9]([0-9]|[ABEHMNPRV-Y]))"
		."|[0-9][A-HJKS-UW])[0-9][ABD-HJLNP-UW-Z]{2})"
		."|[0-9][A-HJKS-UW]) [0-9][ABD-HJLNP-UW-Z]{2})", $postcode)) 
		{
			return $postcode;
		} 
		else 
		{
			return FALSE;
		}
	}

	function yahooMap($postcode, $width, $height)
	{
		$s = microtime(true);
		
		global $yahoo_api_key;

		// The Yahoo! Web Services request
		//the image
		$req =	"http://local.yahooapis.com/MapsService/V1/mapImage?"
					."appid=" . $yahoo_api_key
					."&zip=" . $postcode
					."&state=UK"
					."&zoom=3"
					."&image_type=gif"
					."&image_width=" . $width
					."&image_height=" . $height
					."&output=php";

		// Make the request
		//Get the CSV of the Lat & Long from postcode
		$latlong = getREST($req);

		//$phpserialized = file_get_contents($req);
		// Parse the serialized response
		$phpobj = unserialize($latlong);
/*			
		echo '<pre>';
		print_r($latlong);
		echo '</pre>';
		echo '<pre>';
		print_r($phpobj);
		echo '</pre>';
*/
	
		$e = microtime(true);
		//echo "DEBUG: Yahoo Time taken = " . floor(($e - $s)*1000) . "ms<br/>";
		
		return (str_replace("&","&amp;",$phpobj["Result"]) . "\" alt=\"DEBUG: Yahoo Time taken = " . floor(($e - $s)*1000) . "ms");
	}
	
	function googleMap($postcode, $width, $height)
	{
		$s = microtime(true);
		
		global $google_maps_api_key;

		//URL for the polling station
		$pollingStationURL = "http://maps.google.com/maps/geo?q="
									. $postcode . "+UK"
									."&output=csv"
									."&oe=utf8"
									."&sensor=false"
									."&key=" . $google_maps_api_key;

		//Get the CSV of the Lat & Long from postcode
		$map_csv = getREST($pollingStationURL);
		
		$mapData_array = explode(",",$map_csv);

		$map_img = "http://maps.google.com/staticmap?" 
						. "center=" . $mapData_array[2] .",". $mapData_array[3] 
						. "&amp;markers=" . $mapData_array[2] .",". $mapData_array[3] .",tiny"
						. "&amp;zoom=14"
						. "&amp;size=" . $width . "x" . $height 
						. "&amp;maptype=mobile"
						. "&amp;key=" . $google_maps_api_key 
						. "&amp;sensor=false";
						
		$e = microtime(true);
		//echo "DEBUG: Google Time taken = " . floor(($e - $s)*1000) . "ms<br/>";
		
		return ($map_img . "\" alt=\"DEBUG: Google Time taken = " . floor(($e - $s)*1000) . "ms");
	}

	function theyWorkForYou($postcode)
	{
		$s = microtime(true);
		
		//http://www.theyworkforyou.com/api/function?key=key&output=output&other_variables
		
		global $twfy_api_key;

		$req = "http://www.theyworkforyou.com/api/"
		."getConstituency?"
		."key=" . $twfy_api_key
		."&postcode=" . $postcode
		."&output=php";
		
		// Make the request
		//Get the serialised PHP of the Constituency from postcode
		$const = getREST($req);

		// Parse the serialized response
		$phpobj = unserialize($const);
		
		$e = microtime(true);
		//echo "DEBUG: TWFY Time taken = " . floor(($e - $s)*1000) . "ms<br/>";
		
		if (!$phpobj[error])
		{
			return (htmlspecialchars($phpobj["name"]));
		}
		else
		{
			return ( $phpobj[error] . " (" . floor(($e - $s)*1000) . "ms) ");
		}
	}
	
	
	function futureConstituency($postcode)
	{
		$s = microtime(true);
		
		//http://www.theyworkforyou.com/api/function?key=key&output=output&future=1
		
		global $twfy_api_key;

		$req = "http://www.theyworkforyou.com/api/"
		."getConstituency?"
		."key=" . $twfy_api_key
		."&postcode=" . $postcode
		."&future=1"
		."&output=php";
		
		// Make the request
		//Get the serialised PHP of the Constituency from postcode
		$const = getREST($req);

		// Parse the serialized response
		$phpobj = unserialize($const);
		
		$e = microtime(true);
		//echo "DEBUG: TWFY Time taken = " . floor(($e - $s)*1000) . "ms<br/>";
		
		if (!$phpobj[error])
		{
			return (htmlspecialchars($phpobj["name"]));
		}
		else
		{
			return ( $phpobj[error] . " (" . floor(($e - $s)*1000) . "ms) ");
		}
	}
	
	function currentMP($postcode)
	{

		//http://www.theyworkforyou.com/api/docs/getMP
		
		global $twfy_api_key;

		$req = "http://www.theyworkforyou.com/api/"
		."getMP?"
		."key=" . $twfy_api_key
		."&postcode=" . $postcode
		."&output=php";
		
		// Make the request
		//Get the serialised PHP of the Constituency from postcode
		$const = getREST($req);

		// Parse the serialized response
		$phpobj = unserialize($const);
		
		if (!$phpobj[error])
		{
			$name = htmlspecialchars($phpobj["full_name"]);
			$party = htmlspecialchars($phpobj["party"]);
			$image = "http://www.theyworkforyou.com" . htmlspecialchars($phpobj["image"]);
			$imageWidth = strval($phpobj["image_width"]);
			$imageHeight = $phpobj["image_height"];
			
			$content = "<img src='{$image}' alt='{$name}' width='{$imageWidth}' height='{$imageHeight}' />Your current MP is {$name} - a member of the {$party} party.";

			return $content;
		}
		else
		{
			return ( $phpobj[error] );
		}
	}
	
	function mashupMap($postcode)
	{
		//This takes the postcode, checks it against TWFY. If invalid, returns error.
		//If valid, looks up postcode at Yahoo, gets lat & long
		//Get Google map from Lat & long
		
		$s = microtime(true);
		
		//http://local.yahooapis.com/MapsService/V1/geocode?appid=&street=701+First+Ave&city=Sunnyvale&state=CA
		
		global $yahoo_api_key;
		global $google_maps_api_key;

		// The Yahoo! Web Services request
		//the geo code
		$req =	"http://local.yahooapis.com/MapsService/V1/geocode?"
					."appid=" . $yahoo_api_key
					."&zip=" . $postcode
					."&state=UK"
					."&output=php";

		// Make the request
		//Get the serialised PHP of the Constituency from postcode
		$result = getREST($req);
		
		$phpobj = unserialize($result);
		
		echo '<pre>';
		//print_r($result);
		print_r($phpobj);
		echo '</pre>';
		
		$lat = $phpobj[ResultSet][Result][Latitude];
		$long = $phpobj[ResultSet][Result][Longitude];
		
		echo "Yahoo says Lat=" . $phpobj[ResultSet][Result][Latitude] . ", Longitutde=" . $phpobj[ResultSet][Result][Longitude] . ".";
		
		//Google Map
		$map_img = "http://maps.google.com/staticmap?" 
						. "center=" . $lat .",". $long 
						. "&amp;markers=" . $lat .",". $long .",tiny"
						. "&amp;zoom=14"
						. "&amp;size=" . 240 . "x" . 240 
						. "&amp;maptype=mobile"
						. "&amp;key=" . $google_maps_api_key 
						. "&amp;sensor=false";
		
		echo "<img src=\"" . $map_img . "\" />";
		
		$e = microtime(true);
		echo "DEBUG: Mashup Time taken = " . floor(($e - $s)*1000) . "ms<br/>";
		
		
	}
	
	function latlongYahoo($postcode)
	{
		//http://local.yahooapis.com/MapsService/V1/geocode?appid=&street=701+First+Ave&city=Sunnyvale&state=CA
		
		global $yahoo_api_key;

		// The Yahoo! Web Services request
		//the geo code
		$req =	"http://local.yahooapis.com/MapsService/V1/geocode?"
					."appid=" . $yahoo_api_key
					."&zip=" . $postcode
					."&state=UK"
					."&output=php";

		// Make the request
		//Get the serialised PHP of the Constituency from postcode
		$result = getREST($req);
		
		$phpobj = unserialize($result);
		return $phpobj;
	}
	
	function mashupMapHomePoll($postcode_home, $postcode_poll, $deviceScreenWidth, $deviceScreenHeight)
	{
		//This takes the postcode, checks it against TWFY. If invalid, returns error.
		//If valid, looks up postcode at Yahoo, gets lat & long
		//Get Google map from Lat & long
		
		//global $google_maps_api_key;
		
		$home = latlongYahoo($postcode_home);
		$lat_home = $home[ResultSet][Result][Latitude];
		$long_home = $home[ResultSet][Result][Longitude]; 
		
		$poll = latlongYahoo($postcode_poll);
		$lat_poll = $poll[ResultSet][Result][Latitude];
		$long_poll = $poll[ResultSet][Result][Longitude]; 


		//Google Map
		
	//New Google Maps API v2
	//http://maps.google.com/maps/api/staticmap?size=&maptype=roadmap&mobile=true&markers=&sensor=false
		$map_img = "http://maps.google.com/maps/api/staticmap?" 
						. "&amp;markers=" . $lat_home .",". $long_home ."|". $lat_poll .",". $long_poll .""
						. "&amp;size=" . $deviceScreenWidth . "x" . $deviceScreenHeight 
						. "&amp;maptype=roadmap"
						. "&amp;mobile=true"
						. "&amp;sensor=false";
		return $map_img;
		//echo "<img src=\"" . $map_img . "\" />";		
	}
	
	function ernestmarples($postcode, $deviceScreenWidth, $deviceScreenHeight)
	{
		global $google_maps_api_key;
		
		$s = microtime(true);
		
		//http://ernestmarples.com/?q=[postcode]&f=[csv
		
		$req = "http://ernestmarples.com/?p=" . $postcode . "&f=csv";
		
		$csv = getREST($req);
		
		$latlong_array = explode(",",$csv);		
	
		$lat = trim($latlong_array[1]);
		$long = trim($latlong_array[2]);
		
		//echo "Ernest says Lat=" . $lat . ", Longitutde=" . $long . ".";
		
		
		//Google Map
		$map_img = "http://maps.google.com/staticmap?" 
						. "center=" . $lat .",". $long 
						. "&amp;markers=" . $lat .",". $long .",tiny"
						. "&amp;zoom=14"
						. "&amp;size=" . $deviceScreenWidth . "x" . $deviceScreenHeight 
						. "&amp;maptype=mobile"
						. "&amp;key=" . $google_maps_api_key 
						. "&amp;sensor=false";
		
		//echo "<img src=\"" . $map_img . "\" />";
		
		$e = microtime(true);
		//echo "DEBUG: Mashup Time taken = " . floor(($e - $s)*1000) . "ms<br/>";
		
		return ($map_img . "\" alt=\"DEBUG: Ernest Time taken = " . floor(($e - $s)*1000) . "ms");
	}

	function ernestmarplesHomePoll($postcode_home, $postcode_poll, $deviceScreenWidth, $deviceScreenHeight)
	{
		global $google_maps_api_key;
		
		$s = microtime(true);
		
		//http://ernestmarples.com/?q=[postcode]&f=[csv
		
		$req_home = "http://ernestmarples.com/?p=" . $postcode_home . "&f=csv";
		
		$csv_home = getREST($req_home);
		
		$latlong_home_array = explode(",",$csv_home);		
	
		$lat_home = trim($latlong_home_array[1]);
		$long_home = trim($latlong_home_array[2]);
		

		$req_poll = "http://ernestmarples.com/?p=" . $postcode_poll . "&f=csv";
		
		$csv_poll = getREST($req_poll);
		
		$latlong_poll_array = explode(",",$csv_poll);		
	
		$lat_poll = trim($latlong_poll_array[1]);
		$long_poll = trim($latlong_poll_array[2]);
		

		//echo "Ernest says Lat=" . $lat . ", Longitutde=" . $long . ".";
		
		
		//Google Map
		$map_img = "http://maps.google.com/staticmap?" 
						//. "center=" . $lat .",". $long 
						. "&amp;markers=" . $lat_home .",". $long_home ."|". $lat_poll .",". $long_poll .""
						//. "&amp;zoom=14"
						. "&amp;size=" . $deviceScreenWidth . "x" . $deviceScreenHeight 
						. "&amp;maptype=mobile"
						. "&amp;key=" . $google_maps_api_key 
						. "&amp;sensor=false";
		
		//echo "<img src=\"" . $map_img . "\" />";
		
		$e = microtime(true);
		//echo "DEBUG: Mashup Time taken = " . floor(($e - $s)*1000) . "ms<br/>";
		
		return ($map_img . "\" alt=\"DEBUG: Ernest Time taken = " . floor(($e - $s)*1000) . "ms");
	}
	
	function electoralInfoFromPostcode($postcode)
	{
		global $mySQL_username;
		global $mySQL_password;
		global $mySQL_database;
	
		mysql_connect(localhost,$mySQL_username,$mySQL_password);
		@mysql_select_db($mySQL_database) or die( "Unable to select database");
		//echo "Connected to MySQL. passed ".$postcode."<br />";

		$query = "SELECT Council_ID from postcode_councilID WHERE postcode = '". $postcode . "'";
		$result=mysql_query($query);
		//echo "result = " . $result;		
		//echo "result dump = " . var_dump($result);
		$row = mysql_fetch_array($result);
		if ($row[0] == null) //postcode is probably duff
		{		return false;
		}
		$council_id = $row["Council_ID"];

		$info_query = "SELECT * FROM councils WHERE Council_ID = " . $council_id;
		$info_result=mysql_query($info_query);
		$info_row = mysql_fetch_array($info_result);
		
		mysql_close();
		
		return $info_row;
	}
	
	function validPhoneNumber($number)
	{
		$validNumber = substr($number, 0, strpos($number, '/')); 
		//strstr($number, '/', true); //5.3.0 only
		
		if ($validNumber != false)
		{
			return $validNumber;
		}
		else
		{
			return $number;
		}
	}
	
?>
