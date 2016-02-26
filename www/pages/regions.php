<?php
session_start();
$content = new Template("templates/regions.tpl");
$query = "SELECT * FROM gridregions";
$sql = mysql_query($query);
while($region = mysql_fetch_array($sql))
{
$owner = mysql_fetch_array(mysql_query("SELECT * FROM user_accounts WHERE PrincipalID='$region[6]'")) or die(mysql_error());
$locx = $region['LocX'] / 256;
$locy = $region['LocY'] / 256;
$regions .= "<div class=\"col-md-4\">$region[RegionName]</div><div class=\"col-md-4\">X: $locx , Y:$locy</div><div class=\"col-md-4\">$owner[FirstName] $owner[LastName]</div>";
}
$content->set("regions",$regions);
//echo $regions;