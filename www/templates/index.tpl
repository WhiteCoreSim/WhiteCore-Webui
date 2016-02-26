<!DOCTYPE html>
<html>
<head>
<title>[@title] - [@page]</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" type="text/css" href="css/[@style]/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="css/[@style]/bootstrap-theme.css" />
<link rel="stylesheet" type="text/css" href="css/[@style]/custom.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/popup.js"></script>
</head>
<body>        
    <div id="element_to_pop_up"><a class="b-close">x</a>
    <form role="form" action="index.php?page=[@logpage]" method="post">
     <h3>Login</h3><hr>
     <div class="form-group">
       <label for="logname"><b>Username</b></label>
       <input type='text' class="form-control" name='logname'>
      </div>
      <div class="form-group">
      <label for="logpassword"><b>Password</b></label>
      <input type='password'  class="form-control" name='logpassword'><br>
      </div>
      <input type="submit"  class="btn btn-default" name="Submit" value="Login">
      </form>
      </div>
      
<nav class="navbar navbar-default">  
  <div class="container-fluid">    
    <div class="navbar-header">
      <a class="navbar-brand" href="#">[@title]</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Home</a></li>
      <li><a href="?page=maps">Maps</a></li>
      <li><a href="?page=regions">Regions</a></li>
      <li><a href="?page=about">About Us</a></li>
      <li><a href="?page=contact">Contact</a></li>
    </ul>
[@login]       
  </div>                                       
</nav> 
<div id="wrap">
  <div id="main" class="container clear-top"> 
    [@error]       
   <div class="pull-right"><div class="panel panel-primary hidden-xs">
      <div class="panel-heading">GridStatus</div>
      <div class="panel-body">
      <div id="gridstatus">
<table>
  <tbody>
  <tr>
    <td>
      <table>
        <tbody>
        <tr>
          <td>
            <table width="100%">
              <tbody>
              <tr>
                  <td align=right>
[@status]
                 </td>
              </tr>
              </tbody>
            </table>
            <table cellSpacing=0 cellPadding=0>
              <tbody>
              <tr>
                <td vAlign=top noWrap align=left>Users:</td>
                <td vAlign=top noWrap align=right width="1%">[@usercount]</td>
              </tr>
              <tr>
                <td vAlign=top noWrap align=left>Regions:</td>
                <td vAlign=top noWrap align=right width="1%">[@regionscount]</td>
              </tr>
              <tr>
                <td vAlign=top noWrap align=left>Unique Visitors:</td>
                <td vAlign=top noWrap align=right width="1%">[@lastmonthonline]</td>
              </tr>
			  <tr>
                <td vAlign=top noWrap align=left><strong><a href="index.php?page=onlineusers">Now Online</a>:</strong></td>
                <td vAlign=top noWrap align=right width="1%"><strong>[@nowonline]</strong></td>
              </tr>
			  </tbody></table></td>
 </tr>
      </tbody>
    </table>
  </td>
</tr>
</tbody>
</table>
</div>
      </div>
    </div></div>
 <div class="panel panel-default" style="width:85%">
  <div class="panel-heading">[@title] >> [@page]</div>
  <div class="panel-body">
  [@content]
  </div>
  </div>
  </div>
<script type="text/javascript">
    window.cookieconsent_options = {"message":"This website uses cookies to ensure you get the best experience on our website","dismiss":"Got it!","learnMore":"More info","link":"index.php?page=cookies","theme":"dark-bottom"};
</script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>

<footer class="footer">&copy; [@title] [@year] <br /><a href="https://validator.w3.org/nu/?doc=[@link]" target="_BLANK"><img src="http://vacaas.nl/images/w3c-valid-html5.png" alt="Valid HTML5" /></a></footer>

  <script>
  // Semicolon (;) to ensure closing of earlier scripting
    // Encapsulation
    // $ is assigned to jQuery
    ;(function($) {

         // DOM Ready
        $(function() {

          
            $('#my-button').bind('click', function(e) {

                // Prevents the default action to be triggered. 
                e.preventDefault();

                // Triggering bPopup when click event is fired
                $('#element_to_pop_up').bPopup();

            });

        });

    })(jQuery);
    </script>
     <script>
   $('#box').fadeIn('slow').delay(5000).fadeOut('slow');
   </script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>