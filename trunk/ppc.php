<?php	
	//$candidateArray = getPPCArray($pc);
	if (str_replace("&amp;", "and", $constituency) != $futureConstituency)
	{
		$ppcConstituency = strtolower($futureConstituency);
	}
	else
	{
		$ppcConstituency = strtolower($constituency);
	}
	
	$ppcConstituency = str_replace(" ", "_", $ppcConstituency);
	$ppcConstituency = str_replace("&amp;", "and", $ppcConstituency);

	$candidateArray = getPPCArray($ppcConstituency);
	
	if (count($candidateArray) > 1)
	{
?>
	<div class="ppc">
		These people want you to vote for them (alphabetical order).
	</div>
<?
	}
	else
	{
		//echo $ppcConstituency;
	}
	
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
