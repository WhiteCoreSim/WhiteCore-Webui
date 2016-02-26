<?php
ini_set("display_errors",0);
$content = new Template("templates/profile.tpl");
if ($_GET[name]) {
    $userName = $_GET['name'];

    $found = array();
    $found[0] = json_encode(array('Method' => 'GetProfile', 'WebPassword' => md5(WEBUI_PASSWORD),
        'Name' => cleanQuery($_GET['name'])));

    $do_post_requested = do_post_request($found);
    $recieved = json_decode($do_post_requested);

    $profileTXT = $recieved->{'profile'}->{'AboutText'};
    $profileImage = $recieved->{'profile'}->{'Image'};
    $created = $recieved->{'account'}->{'Created'};
    $UUID = $recieved->{'account'}->{'PrincipalID'};
    $diff = $recieved->{'account'}->{'TimeSinceCreated'};
    $type = $recieved->{'account'}->{'AccountInfo'};
    $partner = $recieved->{'account'}->{'Partner'};
    $date = date("D d M Y - g:i A", $created);
        if($_COOKIE['NAME'] == $_GET['name'])
        {
        $edit = "<a href='?page=edit'>Edit Account</a>";
        }
        if ($profileTXT != '') {$profile_text = $profileTXT;}
        
                  else {$profile_text = "No information Stored";}
                  
            if ($profileImage == "00000000-0000-0000-0000-000000000000" || $profileImage == "")
            {
                $profileLink = "images/info.jpg";
            }
            else     {
                $profileLink = WEBUI_TEXTURE_SERVICE . '/index.php?method=GridTexture&uuid=' . $profileImage;
                      }
$content->set("content","
          <img alt=\"$profileImage\" src=\"$profileLink\" title=\"$userName\" />
<table>
          <tr>
              <td>
                  Resident Since: $date <br /> Age: ($diff)
              </td>
          </tr>
          <tr>
              <td>
                  Account Type: $type
              </td>
          </tr>         
          <tr>
              <td></td>
          </tr>
              
          <tr>
              <td>
              Partner: $partner
              </td>
          </tr>
          <tr>
              <td></td>
          </tr>
              
          <tr>
              <td>
                  <h2>About</h2>
              </td>
          </tr>       
          <tr>
              <td>
               
               $profile_text
              
              
              </td>
          </tr>
      </table>
      $edit
  ");
  }
  else
  {
  $content->set("content","No Profile Choosen!");
  }