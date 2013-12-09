<?php if(!isset($_SESSION['username'])){
	header('Location: login');
	exit();
}?>
	<form class='upload' action="index.php?content=upload" method="post" enctype="multipart/form-data">
		<h1>Hochladen!</h1>
		<hr />
		<br />
		<input type="file" name="image" class="name" placeholder="Bild">
		<input type="text" name="title" class="name" placeholder="Titel">	
		<textarea name="description" class="message" placeholder="Bildbeschrieb"></textarea>      
		<button type="submit">Datei senden</button>
	</form>