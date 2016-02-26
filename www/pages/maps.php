<?php
session_start();
$content = new Template("templates/maps.tpl");
$content->set("page","Maps");
$content->set("startx",1000);
$content->set("starty",1000);
$content->set("text","Maps work is in Progress");