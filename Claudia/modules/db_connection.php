<?php

define("PBKDF2_HASH_ALGORITHM", "sha512");
define("PBKDF2_ITERATIONS", 1000);
define("PBKDF2_SALT_BYTE_SIZE", 24);
define("PBKDF2_HASH_BYTE_SIZE", 24);

define("HASH_SECTIONS", 4);
define("HASH_ALGORITHM_INDEX", 0);
define("HASH_ITERATION_INDEX", 1);
define("HASH_SALT_INDEX", 2);
define("HASH_PBKDF2_INDEX", 3);

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
	
	public static function get_login($username, $password){
		$query = "SELECT PASSWORD FROM USERS WHERE USERNAME = ?";
		$stmt = MySQLDbConnection::get_instance()->get_connection()->prepare($query);
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->bind_result($dbpass);
		$stmt->fetch();
		if(self::validate_password($password, $dbpass)){
			return true;
		}
		return false;
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
	
	
	// Compares two strings $a and $b in length-constant time.
	private static function slow_equals($a, $b)
	{
   	 $diff = strlen($a) ^ strlen($b);
   	 for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
   	 {
	   	 $diff |= ord($a[$i]) ^ ord($b[$i]);
	 }
	return $diff === 0;
	}

	private static	function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
	{
    	$algorithm = strtolower($algorithm);
		if(!in_array($algorithm, hash_algos(), true))
       	 trigger_error('PBKDF2 ERROR: Invalid hash algorithm.', E_USER_ERROR);
	   	 if($count <= 0 || $key_length <= 0)
	   	 trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);
	   	 if (function_exists("hash_pbkdf2")) {
		   	 // The output length is in NIBBLES (4-bits) if $raw_output is false!
		   	 if (!$raw_output) {
			   	 $key_length = $key_length * 2;
			   	 }
			 return hash_pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output);
		}
	    $hash_length = strlen(hash($algorithm, "", true));
		$block_count = ceil($key_length / $hash_length);

		$output = "";
		for($i = 1; $i <= $block_count; $i++) {
        // $i encoded as 4 bytes, big endian.
        $last = $salt . pack("N", $i);
        // first iteration
        $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
        // perform the other $count - 1 iterations
        for ($j = 1; $j < $count; $j++) {
            $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
        }
        $output .= $xorsum;
    }

    if($raw_output)
        return substr($output, 0, $key_length);
    else
        return bin2hex(substr($output, 0, $key_length));
	}
	private static function validate_password($password, $correct_hash)
	{
   	 $params = explode(":", $correct_hash);
   	 if(count($params) < HASH_SECTIONS)
    	   return false;
		   $pbkdf2 = base64_decode($params[HASH_PBKDF2_INDEX]);
		   return self::slow_equals(
		   $pbkdf2,
		   self::pbkdf2(
          	  $params[HASH_ALGORITHM_INDEX],
		  	  $password,
		  	  $params[HASH_SALT_INDEX],
		  	  (int)$params[HASH_ITERATION_INDEX],
		  	  strlen($pbkdf2),
           true
		   )
		);
	}

}

?>