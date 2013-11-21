<?php
include("../config/database.php");

define("ENVIRONMENT", "test");

class MySQLDbConnection{

	private $host = '';
	private $database = '';
	private $username = '';
	private $password = '';
	/**
	* Singleton instance
	* @var MySQLDbConnection
	*/
	private static $connection;

	private function __construct(){
		$this->$host = $db['ENVIRONMENT']['connection'];
		$this->$database = $db['ENVIRONMENT']['database'];
		$this->$username = $db['ENVIRONMENT']['username'];
		$this->$password = $db['ENVIRONMENT']['password'];
		$this->$connection = new mysqli($host, $username, $password, $database);
		if($connection->connect_error){
			error_log('Connection Error: '.$connection->connect_errno.': '.$connection->connect_error);
			throw new Exception('Error: '.$connection->error);
		}
	}
	
	public static function get_connection(){
		if(is_null(self::$connection)){
			self::$connection = new self();
		}
		return self::$connection;
	}
	
	function __destruct(){
		$connection->close();
	}

}

class InsertImageQuery{

	private $query = "INSERT INTO IMAGES (GALLERY_SECTION, IMAGE_FILENAME, IMAGE_FILEPATH, IMAGE_TITLE, THUMB_FILENAME, THUMB_PATH, TEXT, GROUP) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
	private $types = 'ssssssss';
	private $mysql = '';
	private $stmt = '';
	private $image_data = array();
	
	function __construct($image_data){
		$mysql = MySQLDbConnection::get_connection();
		$stmt = $mysql->prepare($query);
		call_user_func_array('$connection->bind_param', array_merge(array($stmt, $types), $image_data)); 
		$this->$image_data = $image_data;
	}
	
	function add_image(){
		$stmt->execute();
		if($stmt->error){
			error_log('Connection Error: '.$stmt->cerror);
			throw new Exception('Error: '.$stmt->error);
		}
		$stmt->close();
	}
	
}

class DbUtils{
	
	public static function get_image_titles(){
		$query = "SELECT IMAGE_TITLE FROM IMAGES";
		return MySQLDbConnection::get_connection()->query($query);
	}
	
}

?>