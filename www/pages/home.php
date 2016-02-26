<?php
$content = new Template("templates/home.tpl");
$content->set("page","Home");
  $sql = "SELECT * FROM wi_startscreen_news";
                  $query = mysql_query($sql);
                  while($news = mysql_fetch_array($query))
                  {
                  $time = date("D/d/Y h:i A",$news['time']);
                  $new .= "<h3>$news[title]<small class='pull-right'>$time</small></h3><br />$news[message]<br />
                  <small class='pull-right'>Written by <a href='?page=profile&name=$news[user]'>$news[user]</a></small><hr><br />";
                  } 
                  
$content->set("text","$new");