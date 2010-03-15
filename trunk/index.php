<?php
	//Start a session to facilitate storing device data in the session which vastly improves performance.
	session_start();
	include "dtd.xhtml-mp.php";
	include "functions.php";

	$postcodeGet = $_GET["q"];

?>
	<head>
		<?php
			include "style.css";
		?>
		<title>iVote2010 - [Beta]</title>
	</head>
	<body>
		<div class="header">
			<h1>It's time for you to make a difference</h1>
		</div>
		<div class="content">
			<h2>You only have <?php echo (daysUntilElection() - 11); ?> days left to register to vote!</h2>
		</div>

<?php
	$postcodeGet = $_GET["q"];
	if ($postcodeGet)
	{
		include "votewriter.php";	
	}
	else if ($_GET["p"] == "about")
	{
	?>
		<div class="content">
			This service is created by me, <a href="http://shkspr.mobi/blog/">Terence Eden</a>. I am not a member of any political party. I do not seek to influence your vote. This site is funded entirely by me.<br/>
			You may be interested in <a href="http://shkspr.mobi/blog/index.php/2009/07/getting-people-to-the-polling-station/">the origins of this site</a> and the <a href="http://shkspr.mobi/blog/index.php/tag/voteuk/">development of VoteUK</a><br/>
			This site is intended to be an unbiased way to help you register to vote, find out about the candidates seeking your vote, and help you find your way to the polling station.<br/>
			This data is provided on a best-effort basis. I've tried to ensure that it is accurate. If you have any doubts or questions PLEASE CHECK YOUR POLLING CARD OR WITH YOUR LOCAL COUNCIL.<br/>
			I cannot be held responsible for any mistakes in the data nor any consequences arising from their use or misuse.<br/> 
			This service could not have been created without the help of the following talented individuals &amp; organisations. They are (in no particular order)...<br/>
			The magnificent <a href="http://secretlondon.livejournal.com/">Caroline Ford</a> who provided the ONS coded wards.<br/>
			<a href="http://harrymetcalfe.com/">Harry Metcalfe</a> and all those who worked on the outstanding <a href="http://ernestmarples.com/">Ernest Mapels project</a> which converts postcodes into precise latitude and longitude. <br/>
			The cunning Matthew Somerville (aka Dracos) and all the democracy obsessed people behind TheyWorkForYou for constituency lookup services. <br/>
			The dedicated and talented team at<a href="http://www.mysociety.org/donate/">MySociety</a> for their APIs and groundbreaking work in opening up Government data.<br/>
			The organisers, speakers and attendees of <a href="http://www.ukuug.org/events/opentech2009/"> OpenTech 2009</a> for their advice and inspiration.<br/>
			Russel Davies's <a href="http://russelldavies.typepad.com/planning/2009/07/100-hours.html">100 Hours challenge</a><br/>
			And finally, my ever patient wife, Liz Eden, with whom nothing is impossible.<br/>
			Any failings in this service are mine and mine alone.<br/>
			Now, stop reading this and GO VOTE!
		</div>	
	<?php
	}
	else
	{
?>	 
		
<?php
	}
?>
	<div class="form">
			<form method="get" action="/">
				<p>
					<label for="q">What's your <em>full home</em> postcode? For example W1A 1AA.</label><br/>
					<input class="input" type="text" title="Enter your postcode" maxlength="8" name="q" id="q" value="" />
					<br />
					<input type="submit" value="Help me vote" /> 
				</p>
			</form>		
		</div>
		<div class="content">
			We will never pass on your postcode or personal details to any political party.  This site is anonymous.<br/>
		</div>
		<div class="content">
			We're here to help you:
			<ul>
				<li>Register to vote</li>
				<li>See who wants your vote</li>
				<li>Find your polling station</li>
			</ul>
		</div>
		<div class="content">
			<a href="mailto:ivote2010.co.uk@shkspr.mobi">Email your feedback, comments and suggestions</a>.<br/>
		</div>
		<div class="alert">
			This is an beta product. Please do not rely solely on this site for voter registration or information.<br/>
		</div>
		<div class="navigation"> 
			<a class="whitelink" href="/">Home</a> - <a class="whitelink" href="?p=about">About</a>
		</div>
	</body>
</html>
