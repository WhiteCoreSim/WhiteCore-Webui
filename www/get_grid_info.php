<?php
include("config.php");
include("mysql.php");
$login = mysql_fetch_array(mysql_query("SELECT link FROM site_gridinfo WHERE name='platform'"));
$login2 = mysql_fetch_array(mysql_query("SELECT link FROM site_gridinfo WHERE name='loginuri'"));
$login3 = mysql_fetch_array(mysql_query("SELECT link FROM site_gridinfo WHERE name='forgotpass'"));
$login4 = mysql_fetch_array(mysql_query("SELECT link FROM site_gridinfo WHERE name='welcome'"));
//print_r($gridinfo);
header("content-type:text/xml");
echo "<gridinfo>
<gridnick>".SYSNAME."</gridnick>
<platform>$login[0]</platform>
<login>$login2[0]</login>
<password>$login3[0]</password>
<welcome>$login4[0]</welcome>
<register>$login5</register>
<help>$login6</help>
<economy>$login7</economy>
<marketplace>$login8</marketplace>
<about>$login9</about>
<gridname>".SYSNAME."</gridname>
<snapshotconfig/>
<search/>
<helperuri>http://thunderlife.top/economy</helperuri>
<destination/>
<tutorial/>
</gridinfo>";
?>