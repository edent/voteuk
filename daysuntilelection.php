<?php
	function daysUntilElection
	{
		// Get current time
		$date1 = time();
	
		// Get the timestamp of 2010 June 03
		$date2 = mktime(0,0,0,03,06,2010);

		$dateDiff = $date1 - $date2;

		$fullDays = floor($dateDiff/(60*60*24));

		return $fullDays;
	}	
?>
