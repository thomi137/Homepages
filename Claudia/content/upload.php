<?php

	require_once('../modules/db_connection.php');
	require_once('../modules/image_resizer.php');
	
	$file_path = '../gallery/pictures';
	$thumb_path = '../gallery/thumbnails';
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
    
	   	$img = new Image($_FILES['image']['tmp_name'], $file_type);
	   	$filenames = $img->save_to_paths($file_path, $thumb_path);
	   	$image_info = array();
	   	$image_info[] = 'PAINTING';
	   	$image_info[] = $filenames[0];
	   	$image_info[] = $file_path;
	   	$image_info[] = 'title';   
	   	$image_info[] = $filenames[1];
	   	$image_info[] = $thumb_path;
	   	$image_info[] = 'Lorem ipsum dolor gägägüüüööö amet';
	   	$image_info[] = 'NULL';
	   	
	   	$query = new InsertImageQuery($image_info);
	   	$query->add_image();
	 
	 } 
?>
<form class='contact-us' action="upload.php" method="post" enctype="multipart/form-data">
<h1>Kontaktieren Sie mich!</h1>
<hr />
<br />
<input type="file" name="image" class="name" placeholder="Bild">
<input type="text" name="title" class="name" placeholder="Titel">
<textarea name="description" class="message" placeholder="Bildbeschrieb"></textarea>      
<button type="submit">Nachricht senden</button>
</form>


//Gallery Section
//Image_filepath
//Image_filename
//Thumbnail_filepath
//Thumbnail_filename
//Text
//groupid