<?php 
	include "deviceatlas.php";
	//Correctly format the postcode
	$pc = formatPostcode($postcodeGet);
	
	//Get the electoral info based on the post code
	$council_data_array = electoralInfoFromPostcode($pc);

	//Assuming we've got data about the post code
	if ($council_data_array != FALSE)
	{
		//Get the constituency & future changes
		$constituency = theyWorkForYou($pc);
		$futureConstituency = futureConstituency($pc);
		$currentMP = currentMP($pc);
		$invalid = "Invalid";
		$pos = strpos($constituency,$invalid);
		
		//All the data about the council
		$council_phone = validPhoneNumber($council_data_array["Council_Phone"]);
		$council_email = $council_data_array["Council_Email"];
		$council_website = $council_data_array["Council_Website"];
		$council_name = $council_data_array["Council_Name"];
		$council_address2 = $council_data_array["Council_Address2"];
		$council_postcode = $council_data_array["Council_Postcode"];
		
		//Formatted Data
		$dialPhoneNumber = "<a href=\"";

		if ($device->uriSchemeTel == 1)
		{
			$dialPhoneNumber .= "tel:";
		}
		else
		{
			$dialPhoneNumber .= "wtai://wp/mc;";
		}
		$dialPhoneNumber .= str_replace(" ", "", $council_phone) . "\">{$council_phone}</a>";		
?> 

<div class="constituency">
	Your postcode is <?php echo $pc; ?>, that puts you in the constituency of <?php echo $constituency; ?>
</div>
<div class="newconstituency">
	<?php
		if ($constituency != $futureConstituency)
		{
			echo "Due to boundary changes, on election day you will be in the consituency of {$futureConstituency}.";
		}
	 ?>
</div>
<hr/>
<div class="register">
	Call <?php echo $dialPhoneNumber; ?> to register to vote.  You will be sent a simple form to fill in. It's free to post the form back.<br/>
	You can also email <a href="mailto:<?php echo $council_email; ?>"><?php echo $council_email; ?></a> for information.<br/>
	The election is being run by <?php echo $council_name; ?> Council.
</div>
<hr/>
<div class="polling">
<!-- 
	You are in the electoral district of <?php echo "UNKNOWN"; ?>. 
-->
	Your polling station is <?php echo $council_address2 . ", " . $council_postcode . " (this is the council offices, not your polling station)"; ?>.<br/>
<em>You can only vote at the polling station printed on your polling card, if in doubt, please call <?php echo $dialPhoneNumber; ?>.</em><br/>
<?php 
	include "map.php"; 
?>
</div>
<hr/>
<div class="current">
	<?php echo $currentMP; ?>
</div>
<hr/>
<div class="ppc">
	These people want you to vote for them (alphabetical order).
</div>
<?php 
	include "ppc.php"; 
?>
<hr/>
<?php
	}
	else //invalid postcode
	{
?>
	<div class="content">
		We can't find that postcode. Please check it and try again.<br/>
	</div>
<?php
	
	}
?>