<?php
/* Globals */
define('ROOT', getenv('DOCUMENT_ROOT').'/Claudia/');

/* Setup of all pages navigation */
$pages = array();
$pages['gallery'] = ROOT.'content/gallery.php';
$pages['contact'] = ROOT.'content/contact.php';
$pages['upload'] = ROOT.'content/upload.php';

/* Setup of media content path */
$paths = array();
$paths['pictures'] = ROOT.'gallery/pictures/';
$paths['thumbnails'] = ROOT.'gallery/thumbnails/';
?>