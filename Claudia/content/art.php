<?php
include_once('./modules/db_connection.php');

$result = DbUtils::get_image_data();

?>
<?php while($row = $result->fetch_assoc()):

	echo '<a rel="group" href="'.$row['IMAGE_FILEPATH'].'/'.$row['IMAGE_FILENAME'].'" title = "'.$row['TEXT'].'"><img alt = "'.$row['IMAGE_TITLE'].'" src = "'.$row['THUMB_PATH'].'/'.$row['THUMB_FILENAME'].'" /></a>';
?>
<?php endwhile;?>	


