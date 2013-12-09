<?php
/* Globals do not touch unless you know what you do!!! */
define('ENV', 'test');

/* Environment */
$environment = array();
$environment['test'] = 'Claudia'.DIRECTORY_SEPARATOR;
$environment['production'] = '';

define('ROOT', getenv('DOCUMENT_ROOT').DIRECTORY_SEPARATOR.$environment[ENV]);
define('TEMPLATES', ROOT.'template/');



/* Setup of all pages navigation */
$pages = array();
$pages['art'] = ROOT.'content/art.php';
$pages['contact'] = ROOT.'content/contact.php';
$pages['login'] = ROOT.'content/login.php';
$pages['home'] = ROOT.'content/home.php';
$pages['about'] = ROOT.'content/about.php';

/* Setup of media content path */
$paths = array();
$paths['pictures'] = ROOT.'gallery/pictures/';
$paths['thumbnails'] = ROOT.'gallery/thumbnails/';

/* Setup of template folder */
$template = array();
$template['mainsite'] = 'front/';


?>