<?php
session_start();
$content = new Template("templates/about.tpl");
$content->set("text",'<div id="annonce7"><h3>Welcome to ThunderLife</h3>
		<p>This is a New Virtual World based proudly on the <a href="http://whitecore-sim.org/" target="_BLANK">WhiteCore-Sim Platform</a></p>
		<p>Together with the Developers (thank you Rowan Deppeler aka greythane for supporting us) our Goal is to provide a Open and Free Grid where Creativity is everything that counts.</p>
		<p>Our World is created by its Users, you can build everything you can imagine here.</p>
		<p><a href="index.php?page=register">Create a free account today</a> build a virtual you and play in our world.</p>
		<p>Join us now, and make a difference!</p></div>
<div id="annonce10"><p>Please keep in mind that the WhiteCore platform is still in alpha release and so may not always perform as expected.</p></div>');