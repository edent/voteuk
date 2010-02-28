<?php
	$title = "iVote2010 - [ALPHA]";
	$header = "It's time for you to make a difference.";
	include "header.php";
?>
<?php
	$postcodeGet = $_GET["q"];
	if ($postcodeGet)
	{
		include "votewriter.php";	
	}
	else
	{
?>	 
	<div class="content">
		We're here to help you register to vote, see who you can vote for and find your polling station.<br/>
		You only have <b><?php echo (daysUntilElection() - 11); ?> days left</b> to register to vote!<br/>
	</div>
<?php
	}
?>
	<div class="form">
		<form method="get" action="/">
			<p>
				<label for="q">What's your <em>home</em> postcode?</label><br/>
				<input class="input" type="text" title="Enter your postcode" maxlength="8" size="8" name="q" id="q" value="" />
				<input type="submit" value="Help me vote" /> 
			</p>
		</form>		
	</div>
	<div class="content">
		We will never pass on your postcode or personal details to any political party.  This site is totally anonymous.<br/>
	</div>
	<div class="alert">
		This is an alpha product. Please do not rely on this site for voter registration or information.<br/>
		Working: Map lookup (Yahoo, Google). Constituency lookup (MySociety), Council lookup (Electoral Commision).<br/>
		TODO: Ward &amp; Polling Station lookup. Candidate lookup. Better data sanitation. Postcode lookup (Earnest Marples)
	</div>
<?php
	include "footer.php";	
?>
