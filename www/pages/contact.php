<?php
session_start();
    if (isset($_POST["submit"])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $human = intval($_POST['human']);
        $from = SYSNAME .' Contact <'.SYSMAIL.'>'; 
        $to = SYSMAIL; 
        $subject = 'Message From '.SYSNAME.' Contact';
        
        $body = "From: $name\n E-Mail: $email\n Message:\n $message";
 
        // Check if name has been entered
        if (!$_POST['name']) {
            $errName = 'Please enter your name';
        }
        
        // Check if email has been entered and is valid
        if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errEmail = 'Please enter a valid email address';
        }
        
        //Check if message has been entered
        if (!$_POST['message']) {
            $errMessage = 'Please enter your message';
        }
        //Check if simple anti-bot test is correct
        if ($human !== 5) {
            $errHuman = 'Your anti-spam is incorrect';
        }
 
// If there are no errors, send the email
if (!$errName && !$errEmail && !$errMessage && !$errHuman) {
    if (mail ($to, $subject, $body, "From: $from")) {
        $result='<div class="alert alert-success">Thank You! I will be in touch</div>';
    } else {
        $result='<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later</div>';
    }
}
    }
$content = new Template('templates/contact.tpl');
$content->set('content',"<form class='form-horizontal' role='form' method='post' action='index.php?page=contact'>
    <div class='form-group'>
        <label for='name' class='col-sm-2 control-label'>Name</label>
        <div class='col-sm-10'>
            <input type='text' class='form-control' id='name' name='name' placeholder='First & Last Name' value='$_POST[name]'>
<p class='text-danger'>$errName</p>
        </div>
    </div>
    <div class='form-group'>
        <label for='email' class='col-sm-2 control-label'>Email</label>
        <div class='col-sm-10'>
            <input type='email' class='form-control' id='email' name='email' placeholder='example@domain.com' value='$_POST[email]'>
            <p class='text-danger'>$errEmail</p>
        </div>
    </div>
    <div class='form-group'>
        <label for='message' class='col-sm-2 control-label'>Message</label>
        <div class='col-sm-10'>
            <textarea class='form-control' rows='4' name='message'>$_POST[message]</textarea>
            <p class='text-danger'>$errMessage</p>
        </div>
    </div>
    <div class='form-group'>
        <label for='human' class='col-sm-2 control-label'>2 + 3 = ?</label>
        <div class='col-sm-10'>
            <input type='text' class='form-control' id='human' name='human' placeholder='Your Answer'>
            <p class='text-danger'>$errHuman</p>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-sm-10 col-sm-offset-2'>
            <input id='submit' name='submit' type='submit' value='Send' class='btn btn-primary'>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-sm-10 col-sm-offset-2'>
            $result    
        </div>
    </div>
</form> ");