<?php
require("mysql.php");
require("config.php");
require("classes/class_mysql.php");
require("classes/class_template.php");
require("classes/class_json.php");
if (isset($_POST['Submit']) && $_POST['Submit'] == "Login") {

    $found = array();
    $found[0] = json_encode(array('Method' => 'Login', 'WebPassword' => md5(WEBUI_PASSWORD),
                                 'Name' => cleanQuery($_POST[logname]),
                                 'Password' => cleanQuery($_POST[logpassword])));
    $do_post_request = do_post_request($found);
    $recieved = json_decode($do_post_request);
    $UUIDC = $recieved->{'UUID'};

    if ($recieved->{'Verified'} == "true") {
        setcookie("USERID", $UUIDC, time() + (86400 * 30), "/");
        setcookie("NAME", $_POST['logname'], time() + (86400 * 30), "/");
        setcookie("FIRSTNAME", $recieved->{'FirstName'}, time() + (86400 * 30), "/");
        setcookie("LASTNAME", $recieved->{'LastName'}, time() + (86400 * 30), "/");
        $found[0] = json_encode(array('Method' => 'SetWebLoginKey', 'WebPassword' => md5(WEBUI_PASSWORD),
                                 'PrincipalID' => $UUIDC));
        $do_post_request = do_post_request($found);
        $recieved = json_decode($do_post_request);
        $WEBLOGINKEY = $recieved->{'WebLoginKey'};
        $_SESSION[WEBLOGINKEY] = $WEBLOGINKEY;
        setcookie("WEBLOGINKEY", $WEBLOGINKEY, time() + (86400 * 30), "/");
        $error = false;
        header("location:?page=$_GET[page]&act=login");
    } else {
       $error = true;
       $errmsg = "<div class=\"alert alert-danger\" id=\"box\">
 <i class=\"fa fa-exclamation-triangle\"></i>
 <strong>Error!</strong><br>No Account Matched.
</div>";
    }
}
$found = array();
$found[0] = json_encode(array('Method' => 'OnlineStatus', 'WebPassword' => md5(WEBUI_PASSWORD)));
$do_post_request = do_post_request($found);
$recieved = json_decode($do_post_request);
$GRIDSTATUS = $recieved->{'Online'};

// Doing it the same as the Who's Online now part
$DbLink = new DB;
$DbLink->query("SELECT UserID FROM user_info where IsOnline = 1 AND ".
				"LastLogin < (UNIX_TIMESTAMP(FROM_UNIXTIME(UNIX_TIMESTAMP(now())))) AND ".
				"LastLogout < (UNIX_TIMESTAMP(FROM_UNIXTIME(UNIX_TIMESTAMP(now())))) ".
				"ORDER BY LastLogin DESC");
$NOWONLINE = 0;

while(list($UUID) = $DbLink->next_record())
{
// Let's get the user info
$DbLink3 = new DB;
$DbLink3->query("SELECT CurrentRegionID from user_info where UserID = '".cleanQuery($UUID)."'");
list($RegionUUID) = $DbLink3->next_record();

$DbLink2 = new DB;
$DbLink2->query("SELECT FirstName, LastName from user_accounts where PrincipalID = '".cleanQuery($UUID)."'");
list($firstname, $lastname) = $DbLink2->next_record();
$username = $firstname." ".$lastname;
// Let's get the region information
$DbLink3 = new DB;
$DbLink3->query("SELECT RegionName from gridregions where RegionUUID = '".cleanQuery($RegionUUID)."'");
list($region) = $DbLink3->next_record();
if ($region != "")
{
$NOWONLINE = $NOWONLINE + 1;
}
}

$DbLink->query("SELECT count(*) FROM user_info where LastLogin > UNIX_TIMESTAMP(FROM_UNIXTIME(UNIX_TIMESTAMP(now()) - 2419200))");
list($LASTMONTHONLINE) = $DbLink->next_record();
 
$DbLink->query("SELECT count(*) FROM user_accounts");
list($USERCOUNT) = $DbLink->next_record();

$DbLink->query("SELECT count(*) FROM gridregions");
list($REGIONSCOUNT) = $DbLink->next_record();

$layout = new Template("templates/index.tpl");
  if(isset($_GET['page']))
{
if(!file_exists("pages/$_GET[page].php"))
{
include("pages/404.php");
}
else
{
include("pages/$_GET[page].php");
$page = ucfirst($_GET['page']);
$logpage = $_GET['page'];
}
}
else
{
$page = "Home";
$logpage = "home";
include("pages/home.php");
}
if($_GET['act'] == "logout")
{
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}
header("location:index.php?act=finishlogout&page=$_GET[page]");
}
else if($_GET['act'] == "finishlogout")
{
header("location:index.php?page=$_GET[page]");
}
else if($_GET['act'] == "login")
{
header("location:index.php?page=$_GET[page]");
}
if (isset($_COOKIE['NAME']))
{
$layout->set("login","<ul class='nav navbar-nav pull-right' id='main-navigation'>
                <li><a href='?page=profile&name=$_COOKIE[NAME]'>Welcome back $_COOKIE[NAME]</a></li>
                <li><a href='?page=$logpage&act=logout' class='pull-right'>Logout</a></li>
            </ul>");
}
else
{
$layout->set("login","<ul class='nav navbar-nav pull-right' id='main-navigation'>
                <li><a  id='my-button' href='#' class='pull-right'>Login</a></li>
                      <li><a href='?page=register' class='pull-right'>Register</a></li>
            </ul>");
}
if($error)
{
$layout->set("error",$errmsg);
}
else
{
$layout->set("error","");
}
                  if($GRIDSTATUS){ 
                  $layout->set("status","<span class=online>Grid Online</span>");
                     } else { 
                  $layout->set("status","<span class=offline>Grid Offline</span>");
                    }     
                    $USERCOUNT = $USERCOUNT - 5; ///Remove System Users from Grid Info Count
                    $layout->set("usercount","$USERCOUNT");
                    $layout->set("regionscount","$REGIONSCOUNT");
                    $layout->set("lastmonthonline","$LASTMONTHONLINE");
                    $layout->set("nowonline","$NOWONLINE");
                    if(ECONOMY)
                    {
                    	$layout->set("economy","Enabled");
                    }
                    else
                    {
                    	$layout->set("economy","Disabled");
                    }
                    $layout->set("voice",VOICE);
	$layout->set("title", SYSNAME);
  $layout->set("style",STYLE);
   $layout->set("page",$page);
      $layout->set("logpage",$logpage);
   $layout->set("link","$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
  $layout->set("year",date('Y'));
  $layout->set("content", $content->output());
	echo $layout->output();
?>
