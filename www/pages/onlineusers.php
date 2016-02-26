<script>
function OpenAgent(firstname, lastname)
{
	locate = "<?php echo $SYSURL ?>?page=profile&name="+firstname+" "+lastname
	window.open(locate,'mywindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=800,height=400')
}
</script>

<?php
$content = new Template("templates/onlineusers.tpl");
$content->set("content1",'<div id="content">
  <div id="ContentHeaderLeft"><h5>'.$SYSURL.'</h5></div>
  <div id="ContentHeaderCenter"></div>
  <div id="ContentHeaderRight"><h5>Online Users</h5></div>
  <div id="usersonline">
  <div id="info"><p>Info</p></div>

<table>
  <tbody>
    <tr>
      <td>
        <b>Username:</b>
      </td>
      
      <td>
        <b>Region:</b>
      </td>
      
      <td>
        <b>Info</b>
      </td>
    </tr>');
	$DbLink = new DB;
	$DbLink->query("SELECT UserID FROM user_info where IsOnline = '1' AND ".
					"LastLogin < (UNIX_TIMESTAMP(FROM_UNIXTIME(UNIX_TIMESTAMP(now())))) AND ".
					"LastLogout < (UNIX_TIMESTAMP(FROM_UNIXTIME(UNIX_TIMESTAMP(now())))) ".
					"ORDER BY LastLogin DESC");
	while(list($UUID) = $DbLink->next_record())
	{
		// Let's get the user info
		$DbLink2 = new DB;
		$DbLink2->query("SELECT FirstName, LastName from user_accounts where PrincipalID = '".cleanQuery($UUID)."'");
		list($firstname, $lastname) = $DbLink2->next_record();
		$DbLink3 = new DB;
		$DbLink3->query("SELECT CurrentRegionID from user_info where UserID = '".cleanQuery($UUID)."'");
		list($regionUUID) = $DbLink3->next_record();

		$username = $firstname." ".$lastname;
		// Let's get the region information
		$DbLink3 = new DB;
		$DbLink3->query("SELECT RegionName from gridregions where RegionUUID = '".cleanQuery($regionUUID)."'");
		list($region) = $DbLink3->next_record();
		if ($region != "")
		{
			$online .= '<tr>';
			$online .= '<td class="even"><b>'.$username.'</b></td>';
			$online .= '<td class="even"><b>'.$region.'</b></td>';
			$online .= "<td class='even'><a onClick=\"OpenAgent('".$firstname."','".$lastname."')\"><b><u>Click for more Info</u></b></a></td>";
			$online .= '</tr>';
      $content->set("online",$online);
		}
	}
$content->set("content2",'

    </tbody>
  </table>

</div>
</div>');


$DbLink->query("SELECT count(*) FROM user_info where IsOnline = '1' and
LastLogin > (UNIX_TIMESTAMP(FROM_UNIXTIME(UNIX_TIMESTAMP(now()) - 86400)))");
list($NOWONLINE) = $DbLink->next_record();
?>
