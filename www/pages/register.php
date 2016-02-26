<?php
$DbLink = new DB;
$DbLink->query("SELECT adress,region,allowRegistrations,verifyUsers,ForceAge FROM wi_adminsetting");
list($ADRESSCHECK, $REGIOCHECK, $ALLOWREGISTRATION, $VERIFYUSERS, $FORCEAGE) = $DbLink->next_record();
$content = new Template("templates/register.tpl");
// Get IP Adress
if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
    $userIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
} elseif ($_SERVER["REMOTE_ADDR"]) {
    $userIP = $_SERVER["REMOTE_ADDR"];
} else {
    $userIP = "This user has no ip";
}

if($ALLOWREGISTRATION == '1')
{

if ($_POST[action] == "") {
    $_SESSION[PASSWD] = "";
    $_SESSION[EMAIC] = "";
	
	
function printLastNames()
{
	$DbLink = new DB;
	$DbLink->query("SELECT lastnames FROM wi_adminsetting");
	list($LASTNAMESC) = $DbLink->next_record();
  $last .= "<div class=\"form-group\"><label for='accountlast'>Avatar Last Name*</label>";
	if ($LASTNAMESC == "1") {
	$last .= "<select style=\"width:auto;\" class=\"form-control selectWidth\" id=\"register_input\" wide=\"25\" name=\"accountlast\">";
		$DbLink->query("SELECT name FROM wi_lastnames WHERE active=1 ORDER BY name ASC ");
		while (list($NAMEDB) = $DbLink->next_record()) {
		$last .= "<option>$NAMEDB</option>";
		}
    $last .= "</select>";
	} else {
	$last .= "<input minlength=\"3\" style=\"width:auto;\" class=\"form-control selectWidth\" name=\"accountlast\" type=\"text\" size=\"25\" maxlength=\"15\" value=\"$_SESSION[ACCLAST]\" />";
	$last .= "</div>";
  }
  return $last;
}


function displayRegions()
{
	$DbLink = new DB;
$reg .= "<div class=\"form-group\"><label for='startregion'>Select Start Region</label><select style=\"width:auto;\" class=\"form-control selectWidth\" require=\"true\" label=\"startregion_label\" id=\"register_input\" wide=\"25\" name=\"startregion\">";
	$DbLink->query("SELECT RegionName,RegionUUID FROM gridregions ORDER BY RegionName ASC ");
	while (list($RegionName, $RegionHandle) = $DbLink->next_record()) {
	$reg .= "<option value=\"$RegionHandle\">$RegionName</option>";
	}
$reg .= "</select></div>";
return $reg;
}


function displayCountry()
{
	$DbLink = new DB;
$coun .= "<select style=\"width:auto;\" class=\"form-control selectWidth\" require=\"true\" label=\"country_label\" id=\"register_input\" wide=\"25\" name=\"country\" value=\"$_SESSION[COUNTRY]\">";
	$DbLink->query("SELECT name FROM wi_country ORDER BY name ASC ");
$coun .= "<option></option>";
	while (list($COUNTRYDB) = $DbLink->next_record()) {
	$coun .= "<option>$COUNTRYDB</option>";
	}
$coun .= "</select>";
return $coun;
}


function displayDOB()
{	
	 
	if ($status == 1 and $monat == '')
	$bod .= "<select  id=\"selectDate\" style=\"width:auto;\" class=\"form-control selectWidth\" require=\"true\" name='tag'>"; 
	else
		$bod .= "<select id=\"selectDate\" style=\"width:auto;\" class=\"form-control selectWidth\" require=\"true\" name='tag'>"; 
	$bod .= "<option></option>";
	for ($i = 1; $i <= 31; $i++) 
	{
		$bod .="<OPTION VALUE=\"$i\" ";
		if ($tag == $i)
			$bod .= "selected ";
		$bod .= ">$i";
	}
$bod .= "</select>";

	if ($status == 1 and $monat == '')
	$bod .= "<select id=\"selectDate\" style=\"width:auto;\" class=\"form-control selectWidth\" require=\"true\" name=\"monat\">"; 
	else
$bod .= "<select id=\"selectDate\" style=\"width:auto;\" class=\"form-control selectWidth\" require=\"true\" name=\"monat\">"; 
$bod .= "<option></option>";
	for ($i = 1; $i <= 12; $i++) 
	{
$bod .="<OPTION VALUE=\"$i\" ";
		if ($monat == $i)
		$bod .="selected ";
	$bod .=">$i";
	}
	$bod .= "</select>";
	if ($status == 1 and $jahr == '')
		$bod .= "<select id=\"selectDate\" style=\"width:auto;\" class=\"form-control selectWidth\" require=\"true\" name=\'jahr\'>"; 
	else
		$bod .= "<select id=\"selectDate\" style=\"width:auto;\" class=\"form-control selectWidth\" require=\"true\" name=\'jahr\'>"; 
	$bod .= "<option></option>";
	$jetzt = getdate();
	$jahr1 = $jetzt["year"];

	for ($i = 1920; $i <= $jahr1; $i++) {
		$bod .= "<OPTION VALUE=\"$i\" ";
		if ($jahr == $i)
		$bod .= "selected ";
		$bod .= ">$i";
	}
	$bod .= "</select>";
  return $bod;
}


/*function displayDefaultAvatars()
{
	$found = array();
	$found[0] = json_encode(array('Method' => 'GetAvatarArchives', 'WebPassword' => md5(WEBUI_PASSWORD)));
	$do_post_requested = do_post_request($found);
	$recieved = json_decode($do_post_requested);
  //  print_r($do_post_requested);
	//if (!isset($recieved->{'names'}, $recieved->{'snapshot'}) && count($recieved->{'names'}) < 0)
	//{
  $sql = mysql_fetch_array(mysql_query("SELECT * FROM wi_appearance"));
    print_r($sql);
	//	$snapshot = $recieved->{'snapshot'};
		$snapshot = array("36694202-ceef-46f3-86cb-db45c1c7a60c","36694202-ceef-46f3-86cb-db45c1c7a60c");
    $count = count($names);
    $av .= "<h1>Select Outfit</h1>";

		for ($i = 0; $i < $count; $i++)
		{
			$av .= "<label for=\"$names[$i]\" >$names[$i]</label>";
			$av .= "<input type=\"radio\" id=\"$names[$i]\" name=\"AvatarArchive\" value=\"$names[$i]\"";
			if (($_SESSION["AVATARARCHIVE"] == $names[$i]) || (($i == 0) && ($_SESSION["AVATARARCHIVE"] == "")))
			{
				$av .= "checked />";
			}
			$av .= "<label for=\"$names[$i]\" ><br><br /><img src=\"".WEBUI_TEXTURE_SERVICE."/index.php?method=GridTexture&uuid=".$snapshot[$i]."\" /></div>";
		}
	
//	return $av;
  //}
return $av;
} */
function displayDefaultAvatars()
{
$sql = "SELECT * FROM wi_appearance WHERE Enabled='1'";
$query = mysql_query($sql);
$av .= "<div class='row-fluid'>";
while($archive = mysql_fetch_array($query))
{
$av .= "<div style='display:inline-block;'>
<input type='radio' id='$archive[ArchiveName]' name='AvatarArchive' value='$archive[ArchiveName]'><img src=\"".WEBUI_TEXTURE_SERVICE."/index.php?method=GridTexture&uuid=".$archive['Picture']."\" /></div>&nbsp;";
}
$av .= "</div></div>";
return $av; 
}
$lastnames = printLastNames();
$regions = displayRegions();
$countr = displayCountry();
$birthd = displayDOB();
   if ($REGIOCHECK == "0") { 

            $region = "
                        $regions
                    ";

                 }
                 
                   if ($ADRESSCHECK == "1") { 
           $address   =  "   <div class=\"form-group\">
           <label for='firstname'>First Name*</label>
                            <input require=\"true\" style=\"width:auto;\" class=\"form-control selectWidth\" name=\"firstname\" type=\"text\" maxlength=\"15\" value=\"$_SESSION[NAMEF]\">
                        </div>
                    

             <div class=\"form-group\">
             <label for='lastname'>Lastname*</label>
                    
                            <input require=\"true\" style=\"width:auto;\" class=\"form-control selectWidth\" name=\"lastname\" type=\"text\" maxlength=\"15\" value=\"$_SESSION[NAMEL]\">
                        </div>
                   

 <div class=\"form-group\">
 <label for='address'>Address*</label>

                            <input require=\"true\" style=\"width:auto;\" class=\"form-control selectWidth\" name=\"adress\" type=\"text\" maxlength=\"50\" value=\"$_SESSION[ADRESS]\">
                        </div>
                   <div class=\"form-group\">
                   <label for='zip'>Zip Code*</label>
                 
                            <input require=\"true\" style=\"width:auto;\" class=\"form-control selectWidth\" name=\"zip\" type=\"text\" maxlength=\"15\" value=\"$_SESSION[ZIP]\">
                        </div>

                <div class=\"form-group\">
                <label for='city'>City*</label>
             
                            <input require=\"true\" style=\"width:auto;\" class=\"form-control selectWidth\" name=\"city\" type=\"text\" maxlength=\"15\" value=\"$_SESSION[CITY]\">
                        </div>
                     <div class=\"form-group\">
                     <label for='country'>Country*</label>
                 
                        $countr
                   </div>
               <div class=\"form-group\">
             
             <label for=\"selectDate\">Date of Birth*</label>
                       </div>
                       <div class=\"form-inline\">
                        $birthd
                   </div>";

                }
                if ($FORCEAGE == "1"){

             $force =  "   <div class=\"form-group\">
             
             <label for='tag'>Date of Birth*</label>
                    
                        $birthd
                    </div>";

                } 
                $avatars = displayDefaultAvatars(); 
                if( file_exists("./tos.txt"))  {
                 $tos_text = file_get_contents("./tos.txt");
                $tos = "<tr>                              
                    <td class='even' colspan='2'>
                        <div style='width:100%;height:300px;overflow:auto;'>
                           $tos_text
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan=\"2\" valign=\"top\" class=\"odd\"><input label=\"agree_label\" require=\"true\" type=\"checkbox\" name=\"Agree_with_TOS\" id=\"agree\" value=\"1\" />
                        <label for=\"agree\"><span id=\"agree_label\">I agree to the TOS</span></label>
                    </td>
                </tr>";

                }
                if(isset($_COOKIE['ERROR']))
                {
                $error =  '<div id="box" class="alert alert-danger"> '.$_COOKIE['ERROR'].'</div>';
                }
                $content->set("content2","");
$content->set("content",'

        <center><form  role="form" ACTION="index.php?page=register" METHOD="POST" onsubmit="if (!validate(this)) return false;">
    '.$error.'
         <div class="form-group">
          <label for="accountfirst">Avatar First Name*</label>
                            <input minlength="3" id="register_input" style="width:auto;" class="form-control selectWidth" require="true" nospecial="true" label="accountfirst_label" name="accountfirst" type="text" size="25" maxlength="15" value="">
                            </div>
                       '.
                     $lastnames
                     .'
                      <div class="form-group">
               <label for="wordpass">Password*</label>
                            <input minlength="6" style="width:auto;" class="form-control selectWidth" compare="wordpass2" require="true" nospecial="true" label="wordpass_label" id="register_input" name="wordpass" type="password" size="25" maxlength="15">
                       </div>
                        <div class="form-group">
                        <label for="wordpass2">Confirm Password*</label>
                            <input minlength="6" require="true" nospecial="true" style="width:auto;" class="form-control selectWidth" label="wordpass2_label" id="register_input" name="wordpass2" type="password" size="25" maxlength="15">
                    </div>   

              '.$address.'  
              '. $region .'

                
            
                     <div class="form-group">
                <label for="email">Email*</label>
                            <input compare="emaic" style="width:auto;" class="form-control selectWidth" require="true" nospecial="true" label="email_label" id="register_input" name="email" type="text" size="40" maxlength="40" value="">
                          </div>
                          <div class="form-group">
                       <label for="emaic">Confirm Email*</label>
                            <input require="true" nospecial="true" style="width:auto;" class="form-control selectWidth" label="emaic_label" id="register_input" name="emaic" type="text" size="40" maxlength="40" value="" >
                             </div>

                
         
                            <script type="text/javascript">var RecaptchaOptions = {theme : \'white\'};</script>                            <script type="text/javascript" src="http://api.recaptcha.net/challenge?k=6Lf_MQQAAAAAAIGLMWXfw2LWbJglGnvEdEA8fWqk"></script>



 
 
	<noscript>
  		<iframe src="http://api.recaptcha.net/noscript?k=6Lf_MQQAAAAAAIGLMWXfw2LWbJglGnvEdEA8fWqk" height="300" width="500" frameborder="0"></iframe><br/>
  		<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
  		<input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
	</noscript>                 
                       '.$avatars.'
                       '.$tos.'
                    
                            <input type="hidden" name="action" value="check">
                           <br /><center> <button class="btn btn-default" name="submit" type="submit">Create New Account</button></center>
                          
                       
        </form>
    ');
   
} else if ($_POST[action] == "check") 
{
	$_SESSION[ACCFIRST] = $_POST[accountfirst];
	$_SESSION[ACCFIRSL] = strtolower($_POST[accountfirst]);
	$_SESSION[ACCLAST] = $_POST[accountlast];
	$_SESSION[AVATARARCHIVE] = $_POST[AvatarArchive];

	if ($ADRESSCHECK == "1") {
		$_SESSION[NAMEF] = $_POST[firstname];
		$_SESSION[NAMEL] = $_POST[lastname];
		$_SESSION[ADRESS] = $_POST[adress];
		$_SESSION[ZIP] = $_POST[zip];
		$_SESSION[CITY] = $_POST[city];
		$_SESSION[COUNTRY] = $_POST[country];
	} else {
		$_SESSION[NAMEF] = "none";
		$_SESSION[NAMEL] = "none";
		$_SESSION[ADRESS] = "none";
		$_SESSION[ZIP] = "00000";
		$_SESSION[CITY] = "none";
		$_SESSION[COUNTRY] = "none";
	}

	if ($REGIOCHECK == "0") {
		$_SESSION[REGIONID] = $_POST[startregion];
	} else {
		$DbLink->query("SELECT startregion FROM wi_adminsetting");
		list($adminregion) = $DbLink->next_record();
		$_SESSION[REGIONID] = $adminregion;
	}
	
	$_SESSION[EMAIL] = $_POST[email];
	$_SESSION[EMAIC] = $_POST[emaic];
	$_SESSION[PASSWD] = $_POST[wordpass];
	$_SESSION[PASSWD2] = $_POST[wordpass2];

	$tag = $_POST[tag];
	$monat = $_POST[monat];
	$jahr = $_POST[jahr];

	$tag2 = date("d", time());
	$monat2 = date("m", time());
	$jahr2 = date("Y", time());

	$jahr2 = $jahr2 - 18;
	$agecheck1 = $tag + $monat + $jahr;
	$agecheck2 = $tag2 + $monat2 + $jahr2;
	
	if ($FORCEAGE == "1")
	{
		if ($agecheck1 > $agecheck2)
		{
			session_unset();
			session_destroy();
			$_SESSION = array();
			header("Location: Index.php?page=register&ERROR=Sorry, you must be 18 to sign up.");
			exit();
		}
	}
	
	require_once('recaptchalib.php');
	$privatekey = "6Lf_MQQAAAAAAB2vCZraiD2lGDKCkWfULvhG4szK";
	$resp = recaptcha_check_answer($privatekey,
					$_SERVER["REMOTE_ADDR"],
					$_POST["recaptcha_challenge_field"],
					$_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) {
	 header("location:error.php?error=The reCAPTCHA wasn't entered correctly. Please try it again.");
	} else if (($_SESSION[PASSWD] != $_SESSION[PASSWD2]) or ($_SESSION[PASSWD] == '') or ($_SESSION[PASSWD2] == '') or ($_SESSION[EMAIC] == '') or ($_SESSION[EMAIL] == '') or ($_SESSION[CITY] == '') or ($_SESSION[ZIP] == '') or ($_SESSION[ADRESS] == '') or ($_SESSION[NAMEL] == '') or ($_SESSION[NAMEF] == '') or ($_SESSION[ACCFIRST] == '') or ($_SESSION[ACCLAST] == '')) {

		if ($_SESSION[EMAIC] == '') {
    header("location:error.php?error=Please confirm your email.");
		}

		if ($_SESSION[PASSWD] != $_SESSION[PASSWD2]) {
      header("location:error.php?error=Passwords do not match.");
		}

		if ($_SESSION[PASSWD] == '') {
       header("location:error.php?error=Please enter your Password.");
		}

		if ($_SESSION[PASSWD2] == '') {
       header("location:error.php?error=Please confirm your Password.");
		}

		if ($_SESSION[EMAIL] == '') {
		 header("location:error.php?error=Please enter your Email.");
		}

		if ($_SESSION[CITY] == '') {
			 header("location:error.php?error=Please enter your City.");
		}

		if ($_SESSION[ZIP] == '') {
			 header("location:error.php?error=Please enter your ZIP Code.");
		}

		if ($_SESSION[ADRESS] == '') {
			 header("location:error.php?error=Please enter your Address.");
		}

		if ($_SESSION[NAMEL] == '') {
			 header("location:error.php?error=Please enter your real Last Name.");
		}

		if ($_SESSION[NAMEF] == '') {
			 header("location:error.php?error=Please enter your real First Name.");
		}

		if ($_SESSION[ACCFIRST] == "") {
			 header("location:error.php?error=Please enter a First Name for your Avatar.");
		}

		if ($_SESSION[ACCLAST] == "") {
		 header("location:error.php?error=Please enter a Last Name for your Avatar.");
		}
	} 
	else if ($_SESSION[EMAIL] != $_SESSION[EMAIC]) {
		 header("location:error.php?error=Email Confirmation not correct.");
	} else {
		$passneu = $_SESSION[PASSWD];
		$passwordHash = md5(md5($passneu) . ":");

		$found = array();
		$found[0] = json_encode(array('Method' => 'CheckIfUserExists', 'WebPassword' => md5(WEBUI_PASSWORD), 'Name' => cleanQuery($_SESSION[ACCFIRST].' '.$_SESSION[ACCLAST])));
		$do_post_requested = do_post_request($found);
		$recieved = json_decode($do_post_requested);

		// echo '<pre>';
		// var_dump($recieved);
		// var_dump($do_post_requested);
		// echo '</pre>';

		if ($recieved->{'Verified'} != false) {
	 header("location:error.php?error=This Avatar already Exists.");
		} else {

			// CODE generator
			function code_gen($cod="") {
				$cod_l = 10;
				$zeichen = "a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,0,1,2,3,4,5,6,7,8,9";
				$array_b = explode(",", $zeichen);

				for ($i = 0; $i < $cod_l; $i++) {
					srand((double) microtime() * 1000000);
					$z = rand(0, 35);
					$cod .= "" . $array_b[$z] . "";
				}
				return $cod;
			}

			$code = code_gen();
			
			$userLevel = -1;
			if($VERIFYUSERS == 1)
				$userLevel = 0;

			$found = array();
			$found[0] = json_encode(array('Method' => 'CreateAccount', 'WebPassword' => md5(WEBUI_PASSWORD),
						'Name' => cleanQuery($_SESSION[ACCFIRST].' '.$_SESSION[ACCLAST]),
						'Email' => cleanQuery($_SESSION[EMAIL]),
						'HomeRegion' => cleanQuery($_SESSION[REGIONID]),
						'PasswordHash' => cleanQuery($passneu),
						'PasswordSalt' => cleanQuery($passwordSalt),
						'AvatarArchive' => cleanQuery($_SESSION[AVATARARCHIVE]),
						'UserLevel' => cleanQuery($userLevel),
						'RLName' => cleanQuery($_SESSION[NAMEF] . ' ' . $_SESSION[NAMEL]),
						'RLAdress' => cleanQuery($_SESSION[ADRESS]),
						'RLCity' => cleanQuery($_SESSION[CITY]),
						'RLZip' => cleanQuery($_SESSION[ZIP]),
						'RLCountry' => cleanQuery($_SESSION[COUNTRY]),
						'RLDOB' => cleanQuery($tag . "/" . $monat . "/" . $jahr),
						'RLIP' => cleanQuery($userIP)
						));
						
						
			$do_post_requested = do_post_request($found);
			$recieved = json_decode($do_post_requested);

			
			// echo '<pre>';
			// var_dump($recieved);
			// var_dump($do_post_requested);
			// echo '</pre>';

			if ($recieved->{'Verified'} == "true") {
      $deletetime = "24";
				$DbLink = new DB;
				//-----------------------------------MAIL--------------------------------------
				$date_arr = getdate();
				$date = "$date_arr[mday].$date_arr[mon].$date_arr[year]";
				$sendto = $_SESSION[EMAIL];
				$subject = "Account Activation from " . SYSNAME;
        $body .= '<html>
<head>
    <title>Welcome to '.SYSNAME.'</title>
</head>
 
<body> 
<table border="1">
  <tr>';
				$body .= "<td><h1>Your account was successfully created at " . SYSNAME . ".</h1></td>\n";
				$body .= "<td>Your first name: $_SESSION[ACCFIRST]</td>\n";
				$body .= "<td>Your last name:  $_SESSION[ACCLAST]</td>\n";
				$body .= "<td>Your password:  $_SESSION[PASSWD]</tr>\n\n";
				$body .= "<td>In order to login, you need to confirm your email by clicking this link within $deletetime hours:</td>";
				$body .= "\n";
				$body .= "<td><a href='".SYSURL."/index.php?page=validate&code=$code'>Validate</a></td>";
				$body .= "<td>Thank you for using " . SYSNAME . "</td>";
        $body .= "</tr></table>\n\n\n";
				$header .= "From: " . SYSMAIL . "\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$mail_status = mail($sendto, $subject, $body, $header);

				//-----------------------------MAIL END --------------------------------------
				// insert code
				$UUIDC = $recieved->{'UUID'};
				$DbLink->query("INSERT INTO wi_codetable (code,UUID,info,email,time)VALUES('$code','$UUIDC','confirm','".cleanQuery($_SESSION[EMAIL])."'," . time() . ")");
				// insert code end


$content->set("content",".");
$content->set("content2",'<div id="content">
    <div id="ContentHeaderLeft"><h5>'.SYSNAME.'</h5></div>
    <div id="ContentHeaderCenter"><p class="register"><b>Registration Successfull</b></p></div>
	
    <div class="clear"></div>

    <div id="message"><p>Account Info</p></div>

    <div id="register">
        <p>'.SYSNAME.' Avatar First Name: <b>'.$_SESSION['ACCFIRST'].'</b></p>
        <p>'.SYSNAME.'Avatar Last Name:  <b>'.$_SESSION['ACCLAST'].'</b></p>
        <p>'.SYSNAME.' Email: '.$_SESSION['EMAIL'].'</b></p>
    </div>
</div>');
    session_unset();
	session_destroy();
}

else
{
    echo "<script language='javascript'>
	    <!--
		    window.alert('Unknown error. Please try again later.');
		    window.location.href='index.php?page=register';
		-->
		</script>";
        }
      }
    }
  }
}

else { ?>

<div id="content">
    <div id="ContentHeaderLeft"><h5><?php echo SYSNAME; ?></h5></div>
    <div id="ContentHeaderCenter"></div>
    <div id="ContentHeaderRight"><h5><?php echo $webui_register; ?></h5></div>
    <div class="clear"></div>
    <div id="alert"><p><?php echo $webui_registrations_disabled; ?></p></div>
</div>

<?php } ?>
