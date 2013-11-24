<?php

class MySQLDbConnection{

	private $host = '';
	private $database = '';
	private $username = '';
	private $password = '';
	private $port = '';
	/**
	* Singleton instance
	* @var MySQLDbConnection
	*/
	static private $instance = NULL;
	private $connection = '';

	private function __construct(){
		include("../config/database.php");
		$this->host = $db['test']['connection'];
		$this->database = $db['test']['database'];
		$this->username = $db['test']['username'];
		$this->password = $db['test']['password'];
		$this->port = $db['test']['port'];
		$this->connection = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);
		if($this->connection->connect_error){
			error_log('Connection Error: '.$this->connection->connect_errno.': '.$this->connection->connect_error);
			throw new Exception('Error: '.$this->connection->error);
		}
	}
	
	public static function get_instance(){
		if(is_null(self::$instance)){
			self::$instance = new MySQLDbConnection();
		}
		return self::$instance;
	}
	
	public function get_connection(){
		return $this->connection;
	}
	
	function __destruct(){
		$this->connection->close();
	}

}

class InsertImageQuery{

	private $query = "INSERT INTO IMAGES (GALLERY_SECTION, IMAGE_FILENAME, IMAGE_FILEPATH, IMAGE_TITLE, THUMB_FILENAME, THUMB_PATH, TEXT, GROUP_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
	private $types = 'sssssssi';
	private $mysql = '';
	private $stmt = '';
	private $image_data = array();
	
	function __construct($image_data){
		$this->mysql = MySQLDbConnection::get_instance()->get_connection();
	    $this->stmt = $this->mysql->prepare($this->query);
		$this->stmt->bind_param($this->types, $image_data[0], $image_data[1], $image_data[2], $image_data[3], $image_data[4], $image_data[5], $image_data[6], $image_data[7]);
		$this->image_data = $image_data;
	}
	
	function add_image(){
		$this->stmt->execute();
		if($this->stmt->error){
			error_log('Connection Error: '.$stmt->cerror);
			throw new Exception('Error: '.$stmt->error);
		}
		$this->stmt->close();
	}
}

class DbUtils{
	
	public static function get_image_titles(){
		$query = "SELECT IMAGE_TITLE FROM IMAGES";
		return MySQLDbConnection::get_connection()->query($query);
	}
	
}

?>