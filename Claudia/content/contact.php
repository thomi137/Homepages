<?php
echo<<<END
<form class='contact-us' action="#" method="post">
<h1>Kontaktieren Sie mich!</h1>
<hr />
<br />
<input type="text" name="name" class="name" placeholder="Name">
<input type="text" name="email" class="email" placeholder="Email">
<input type="text" name="subject" class="subject" placeholder="Betreff">
<textarea name="message" class="message" placeholder="Nachricht"></textarea>            
<button type="submit">Nachricht senden</button>
</form>
END;
?>