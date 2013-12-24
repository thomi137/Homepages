<?php include('./content/model_home.php');?>

	<?php while($row = $result->fetch_assoc()):
	echo '<img class = "front_image" alt = "'.$row['IMAGE_TITLE'].'" src = "'.$row['IMAGE_FILEPATH'].'/'.$row['IMAGE_FILENAME'].'" />'; ?>
	<?php if($row['IMAGE_TITLE'] != ''): ?>
	  <div class = "front_image_title"><?php echo$row['IMAGE_TITLE']; ?></div>
	  <br />
	<?php endif; ?>
	<?php if($row['TEXT'] != ''):?>
	 <div class = "front_image_text"><?php echo $row['TEXT']; ?></div>
	<?php endif; ?>
 <?php endwhile;?>	
