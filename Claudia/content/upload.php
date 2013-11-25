<?php

	require_once('./modules/db_connection.php');
	require_once('./modules/image_resizer.php');
	
	$file_path = './gallery/pictures';
	$thumb_path = './gallery/thumbnails';
	$title = '';
	$text = '';
	$filenames = array();
	// get file data
	if (!empty($_FILES['image'])) {
		 $image = $_FILES['image'];
		 if ($image['error'] !== UPLOAD_ERR_OK) {
			 echo "<p>An error occurred.</p>";
			 exit;
		}

		// verify the file type
		$file_type = exif_imagetype($_FILES["image"]["tmp_name"]);
		$allowed = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
		if (!in_array($file_type, $allowed)) {
       		echo "<p>File type is not permitted.</p>";
	   		exit;
	   	}
	   	$name = preg_replace('/[^A-Z0-9._-]/i', '_', $image['name']);
	   	
	   	// sanitize text fields
	   	if(isset($_POST['title']) && !is_null($_POST['title'])){
		   	$title =  DbUtils::sanitize($_POST['title']); 
	   	}
	   	else{
		   	$title = 'Ohne Titel';
	   	}
	   	if(isset($_POST['description']) && !is_null($_POST['description'])){
	   		$text = DbUtils::sanitize($_POST['description']);
	   	}
	   	else{
		   	$text = '';
	   	}
    
	   	$img = new Image($_FILES['image']['tmp_name'], $file_type);
	   	$filenames = $img->save_to_paths($file_path, $thumb_path);
	   	$query = new InsertImageQuery('PAINTING', $filenames[0], $file_path, $title, $filenames[1], $thumb_path, $text, 'NULL');
	   	$query->add_image();
	 }
?>
<form class='upload' action="index.php?content=upload" method="post" enctype="multipart/form-data">
<h1>Hochladen!</h1>
<hr />
<br />
<input type="file" name="image" class="name" placeholder="Bild">
<input type="text" name="title" class="name" placeholder="Titel">
<textarea name="description" class="message" placeholder="Bildbeschrieb"></textarea>      
<button type="submit">Datei senden</button>
</form>