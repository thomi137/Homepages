<?php
require_once(+"../config/db_config.php");

define("ENVIRONMENT", "test");

abstract class DbQuery{

	private $url = $db['ENVIRONMENT']['connection'];
	private $database = $db['ENVIRONMENT']['database'];
	private $username = $db['ENVIRONMENT']['username'];
	private $password = $db['ENVIRONMENT']['password'];
	private $connection = '';

	function __construct(){
		$this->$connection = mysql_connect($url, $username, $password);
	}
	
	function __destruct(){
		mysql_close($this->$connection);
		mysql_select_db($database);
	}

}

class InsertImageQuery extends DbQuery{
	
	private $query = "INSERT INTO IMAGES (GALLERY_SECTION, IMAGE_FILENAME, IMAGE_FILEPATH, IMAGE_TITLE, THUMB_FILENAME, THUMB_PATH, TEXT) VALUES (?, ?, ?, ?, ?, ?, ?)";
	
}


?>