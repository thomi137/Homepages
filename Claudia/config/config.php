<?php
/* Globals do not touch unless you know what you do!!! */
define('ROOT', getenv('DOCUMENT_ROOT').'/Claudia/');
define('TEMPLATES', ROOT.'template/');


/* Setup of all pages navigation */
$pages = array();
$pages['art'] = ROOT.'content/art.php';
$pages['contact'] = ROOT.'content/contact.php';
$pages['upload'] = ROOT.'content/upload.php';
$pages['about'] = ROOT.'content/about.php';

/* Setup of media content path */
$paths = array();
$paths['pictures'] = ROOT.'gallery/pictures/';
$paths['thumbnails'] = ROOT.'gallery/thumbnails/';

/* Setup of template folder */
$template = array();
$template['mainsite'] = 'front/';


?>