<?

if($_GET['code'])
{
	$DbLink = new DB;

	$DbLink->query("SELECT UUID FROM wi_codetable WHERE code='".$_GET['code']."' and info='confirm'");
	list($UUID) = $DbLink->next_record();
}

if($UUID)
{	
	$found = array();
	$found[0] = json_encode(array('Method' => 'Authenticated', 'WebPassword' => md5(WEBUI_PASSWORD), 'UUID' => $UUID));
	$do_post_requested = do_post_request($found);
	$recieved = json_decode($do_post_requested);
	if ($recieved->{'Verified'} == "true") 
	{
		$WERROR= "Account Verified";
		$DbLink->query("DELETE FROM wi_codetable WHERE code='".$_GET['code']."' and info='confirm'");
	}
	else
	{
		$WERROR="Internal Error";
	}
}
else
{
	$WERROR="Invalid Code";
}
$content = new Template("templates/validate.tpl");
$content->set('content','<table width=\"100%\" height=\"425\" border=\"0\" align=\"center\">
            <tr>
              <td valign=\"top\"><table width=\"50%\" border=\"0\" align=\"center\">
                <tr>
                  <td><p align=\"center\" class=\"Stil1\">Activate Account</p></td>
                </tr>
              </table>
              <br />
              <table width=\"79%\" height=\"199\" border=\"0\" align=\"center\" cellpadding=\"5\" cellspacing=\"5\" bgcolor=\"#FFFFFF\">
                <tr>
                <td valign=\"top\"><br>
                  <br>
 
				  <font color=\"FF0000\">'.$WERROR.'</font><br>
				  
                  <br>
                </tr>
              </table></td>
            </tr>
        </table>');
        
