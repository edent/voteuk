<?php
	//include 'DA_php_1.3.1/Mobi/Mtld/DA/Api.php';
	//require_once('DeviceAtlas_PHP_API_Beta_2.3/library/Mobi/Mtld/DA/Api.php');
	//$tree = Mobi_Mtld_DA_Api::getTreeFromFile('DeviceAtlas_PHP_API_Beta_2.3/20100215.json');
	//$ua = $_SERVER['HTTP_USER_AGENT'];

	
	

	include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'DeviceAtlas_PHP_API_Beta_2.3/library/Mobi/Mtld/DA/Client.php';

	$s = microtime(true);

	//Setup cache directory for file caching
	$cacheDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;

	$jsonFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'DeviceAtlas_PHP_API_Beta_2.3' . DIRECTORY_SEPARATOR . '20100216.json';
	$config = array(
		'json' => $jsonFile,
		'cache' => 'file:///' . $cacheDir,
		'defaults' => array(
			'displayWidth' => 128,
			'displayHeight' => 128,
			'vendor' => "Unknown Vendor",
			'model' => "Unknown Model"
	  )
	);

	// Notice that the Client object is instantiated with no headers.
	// This is recommended as the correct headers will automatically be pulled from the $_SERVER variable
	$device = new Mobi_Mtld_DA_Client($config);

	//Clear cache if requested
	if(isset($_REQUEST["DA_CLEAR_CACHE"]))
	{
		$device->clearCache($_REQUEST["DA_CLEAR_CACHE"]);
		$cacheMessage = ($_REQUEST["DA_CLEAR_CACHE"] ? 'Cleared cache for this session and device.' : 'Cleared entire cache.');
	} 
	else 
	{
		$cacheMessage = 'Cache: ' . $device->_cache;
	}
	
	
/*
	$s = microtime(true);

	$memcache_enabled = extension_loaded("memcache");
	$no_cache = array_key_exists("nocache", $_GET);
	if ($memcache_enabled && !$no_cache) 
	{
		$memcache = new Memcache;
		$memcache->connect('localhost', 11211);
		$tree = $memcache->get('tree');
	}

	if (!is_array($tree)) 
	{
		//$tree = Mobi_Mtld_DA_Api::getTreeFromFile("DA_php_1.3.1/20090705.json");
		$tree = Mobi_Mtld_DA_Api::getTreeFromFile("DeviceAtlas_PHP_API_Beta_2.3/20100215.json");
		if ($memcache_enabled && !$no_cache) 
		{
			$memcache->set('tree', $tree, false, 10);
		}
	}

	if ($memcache_enabled && !$no_cache) 
	{
		$memcache->close();
	}

	//Get User Agent - double check if it's Opera Mini	
	$opera_header = "HTTP_X_OPERAMINI_PHONE_UA";
	if (array_key_exists($opera_header, $_SERVER)) 
	{
		$ua = $_SERVER[$opera_header];
	}
	else 
	{
	   $ua = $_SERVER['HTTP_USER_AGENT'];
	}

	//further performance can be gained through caching the properties against the user-agent as a key (since many requests are likely to come from one device during its visit)
		$properties = Mobi_Mtld_DA_Api::getProperties($tree, $ua);

	$e = microtime(true);
	echo "<!-- DEBUG: Device Atlas Time taken = " . floor(($e - $s)*1000) . "ms -->";

	//print_r($properties);
*/
?>
