<?php 
	require_once("config/config.php");
	include_once("template/head.php");
	echo '<div id="header">';
	include("template/topnavigation.php");
	echo "</div>";
	echo '<div id="container">';
	echo '<div id="main_content">';
	if (!isset($_GET['content']) || !key_exists($_GET['content'], $pages)){
		include($pages['gallery']);	
	}
	else{		
		$content = $_GET['content'];
		//TODO! Do some sanitation
		include($pages[$content]);
	}
	echo "</div>\n</div>";
	include_once("template/footer.php");?>
