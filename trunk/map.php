<?php 
/*
	try
	{
		$deviceScreenWidth = Mobi_Mtld_DA_Api::getPropertyAsInteger($tree, $ua, "displayWidth");
		$deviceScreenHeight = Mobi_Mtld_DA_Api::getPropertyAsInteger($tree, $ua, "displayHeight");
	}
	catch (Mobi_Mtld_Da_Exception_InvalidPropertyException $e)
	{
		$deviceScreenWidth = 240;
		$deviceScreenHeight = 240;
		echo "<!-- DEBUG: DeviceAtlas didn't find a match. Using default Width &amp; Height<br/> -->";
	}
	*/
	$deviceScreenWidth = $device->usableDisplayWidth;
	$deviceScreenHeight = $device->usableDisplayHeight;
		
	$safePostcode = str_replace(" ", "+", $postcodeGet);
	$safePostcodePoll = str_replace(" ", "+", $council_postcode);
	/*
	<img src="<?php echo googleMap($safePostcode, $deviceScreenWidth, $deviceScreenHeight); ?>" />
	<img src="<?php echo yahooMap($safePostcode, $deviceScreenWidth, $deviceScreenHeight); ?>" />
	<img src="<?php echo ernestmarples($safePostcode, $deviceScreenWidth, $deviceScreenHeight); ?>" />
	*/
?>
This map shows your home and the council offices.<br/>
<a href="http://maps.google.co.uk/m?q=<?php echo $safePostcodePoll; ?>&amp;site=maps&amp;sa=X&amp;oi=map&amp;ct=res">
	<?php 
		$map_img = mashupMapHomePoll($safePostcode, $safePostcodePoll, $deviceScreenWidth, $deviceScreenHeight); 
		echo "<img src='{$map_img}' alt='A map of your house and council offices' />";	
	?>
</a>

