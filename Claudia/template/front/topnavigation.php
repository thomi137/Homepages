<?php 
$page = $_SERVER['REQUEST_URI'];
$pattern = '@^'.DIRECTORY_SEPARATOR.$environment[ENV].'(\w*)'.DIRECTORY_SEPARATOR.'?.*$@i';
$result = preg_replace($pattern,'${1}', $page);
?>

<div id="navmenu">
<ul id="menu">
<li class="<?php echo ($result == 'art') ? 'active': '';?>"><a href="art">Gallerie</a>
<!--<ul id="submenu-1">
<li><a href="#">Bilder</a></li>
<li><a href="#">Objekte</a></li>
</ul>-->
</li>
<li class="<?php echo ($result == 'events') ? 'active': '';?>" ><a href="events">Ausstellungen</a></li>
<li class="<?php echo ($result == 'about') ? 'active': '';?>"><a href="about">Portrait</a></li>
<li class="<?php echo ($result == 'home'|| $result == '') ? 'active': '';?>"><a href="home">Home</a></li>
<li class="<?php echo ($result == 'contact') ? 'active': '';?>"><a href="contact">Kontakt</a></li>
<li class="<?php echo ($result == 'links') ? 'active': '';?>"><a href="links">Links</a></li>
</ul>
</div>