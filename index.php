<?php
	require 'openid.php';
	
	$domain = 'test.domain.com';

	if ( isset($_GET['check']) ) {
		$id = SteamSignIn::validate();
		if ( !is_numeric($id) ) {
			header("Location: ?");
			die("Trying again...");
		}
		
		$data = file_get_contents('http://steamcommunity.com/profiles/'.$id.'/games?tab=all&xml=1');
		$dom = new DomDocument();
		$dom->loadXML($data);
		
		$names = array();
		
		foreach ($dom->getElementsByTagName("appID") as $nameNode) {
			$appIDs[] = $nameNode->nodeValue;
		}
		
		if ( in_array(242520, $appIDs) ) die("Player has Spearhead Edition.");
		if ( in_array(236370, $appIDs) ) die("Player has Frontier Edition.");
		
		die("Player doesn't have Interstellar Marines.");
	}	
	else
		header("Location: ".SteamSignIn::genUrl('http://'.$domain.'/index.php?check', false));
?>