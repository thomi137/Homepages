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
		include("./config/database.php");
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
		$this->connection->set_charset("utf-8");
		$this->connection->query('SET NAMES utf8');
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
	
	function __construct($section, $filename, $filepath, $title, $thumbfilename, $thumbfilepath, $text, $group_id){
		$this->mysql = MySQLDbConnection::get_instance()->get_connection();
	    $this->stmt = $this->mysql->prepare($this->query);
		$this->stmt->bind_param($this->types, $section, $filename, $filepath, $title, $thumbfilename, $thumbfilepath, $text, $group_id);
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
	
	public static function get_image_data(){
		$query = "SELECT IMAGE_FILEPATH , IMAGE_FILENAME , THUMB_PATH , THUMB_FILENAME , IMAGE_TITLE , TEXT FROM IMAGES";
	    return MySQLDbConnection::get_instance()->get_connection()->query($query);
	}
	
	private static function cleanInput($input) {

		 $search = array(
			 '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
			 '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
			 '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
			 '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
		 );

		 $output = preg_replace($search, '', $input);
		 return $output;
	}
		 
	public static function sanitize($input) {
		if (is_array($input)) {
        	foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = self::cleanInput($input);
        $output = mysqli_real_escape_string(MySQLDbConnection::get_instance()->get_connection(), $input);
    }
    return $output;
}
	
}

?>