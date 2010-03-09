<?php
	//Start a session to facilitate storing device data in the session which vastly improves performance.
	session_start();
	include "dtd.xhtml-mp.php";
	include "functions.php";
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
			<h2>You only have <?php echo (daysUntilElection() - 11); ?> days left to register to vote!</h2>
			We're here to help you:
			<ul>
				<li>Register to vote</li>
				<li>See who wants your vote</li>
				<li>Find your polling station</li>
			</ul>
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
			We will never pass on your postcode or personal details to any political party.  This site is anonymous.<br/>
		</div>
		<div class="content">
			<a href="mailto:ivote2010.co.uk@shkspr.mobi">Email your feedback, comments and suggestions</a>.<br/>
		</div>
		<div class="alert">
			This is an beta product. Please do not rely solely on this site for voter registration or information.<br/>
		</div>
		<div class="navigation"> 
			<a class="whitelink" href="index.php">Home</a> - <a class="whitelink" href="about.php">About</a>
		</div>
	</body>
</html>

