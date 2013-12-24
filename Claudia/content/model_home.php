<?php
	include_once('./modules/db_connection.php');
	$query = 'SELECT IMAGE_FILEPATH , IMAGE_FILENAME, IMAGE_TITLE, TEXT FROM IMAGES WHERE FRONT = TRUE';
	$mysqli = MySQLDbConnection::get_instance()->get_connection();
	$result = $mysqli->query($query);
?>