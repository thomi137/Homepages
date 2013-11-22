<?php

	require_once('../modules/db_connection.php');
	require_once('../modules/image_resizer.php');
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
	   	$img->save_to_paths('../gallery/pictures', '../gallery/thumbnails');
	
	   	// write stuff to db
	 
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
