<?php	
	$candidateArray = getPPCArray($pc);
	
	if ($device->uriSchemeTel == 1)
	{
		$phonePrefix = "tel:";
	}
	else
	{
		$phonePrefix = "wtai://wp/mc;";
	}
	
	for ($i = 0; $i < count($candidateArray); $i++)
	{
		echo "<div class=\"ppc\" style=\"clear:both;\">";

		if ($candidateArray[$i]["image"] != null) //Candidate's image
		{
			echo "<img src=\"" . $candidateArray[$i]["image"]["medium"]["url"] 
				. "\" height=\"{$candidateArray[$i]["image"]["medium"]["height"]}\"
				width=\"{$candidateArray[$i]["image"]["medium"]["width"]}\" class=\"floatLeft\" 
				alt=\"{$candidateArray[$i]["name"]}\"/>";
		}
		else //or Party Image
		{
			echo "<img src=\"" . $candidateArray[$i]["party"]["image"]["medium"]["url"] 
				. "\" height=\"{$candidateArray[$i]["image"]["medium"]["height"]}\"
				width=\"{$candidateArray[$i]["image"]["medium"]["width"]}\" class=\"floatLeft\"
				alt=\"{$candidateArray[$i]["name"]}\"/>";
		}
		echo $candidateArray[$i]["name"] . " a member of the " 
			. $candidateArray[$i]["party"]["name"] . ".  ";
		if ($candidateArray[$i]["email"] != null)
		{
			echo "Email: <a href=\"mailto:" . $candidateArray[$i]["email"] . "\">" 
			. $candidateArray[$i]["email"] . "</a>.  ";
		}
		
		if ($candidateArray[$i]["phone"] != null)
		{
			echo "Call: <a href=\"" . $phonePrefix . str_replace(" ", "", $candidateArray[$i]["phone"]) . "\">" . $candidateArray[$i]["phone"] . "</a>";
		}
		echo "</div>";
	}
?>