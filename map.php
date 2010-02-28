<?php 
	//Use DeviceAtlas to get the usable screen size of the device
	$deviceScreenWidth = $device->usableDisplayWidth;
	$deviceScreenHeight = $device->usableDisplayHeight;
	
	//If we can't get a usable screen size, default to 240*240
	if ($deviceScreenWidth == null)
	{
		$deviceScreenWidth = 240;
		$deviceScreenHeight = 240;
	}
	
	//Sanitise the postcode data	
	$safePostcode = str_replace(" ", "+", $postcodeGet);
	$safePostcodePoll = str_replace(" ", "+", $council_postcode);

?>
This map shows your home and the council offices.<br/>
<a href="http://maps.google.co.uk/m?q=<?php echo $safePostcodePoll; ?>&amp;site=maps&amp;sa=X&amp;oi=map&amp;ct=res">
	<?php 
	
		$map_img = mashupMapHomePoll($safePostcode, $safePostcodePoll, $deviceScreenWidth, $deviceScreenHeight); 
		echo "<img src='{$map_img}' width='{$deviceScreenWidth}' height='{$deviceScreenHeight}' alt='A map of your house and council offices' />";	
	?>
</a>
