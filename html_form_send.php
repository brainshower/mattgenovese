<?php
if(isset($_POST['email'])) {
     
    // CHANGE THE TWO LINES BELOW
    $email_to = "matt@mattgenovese.net";
     
    $email_subject = "Form submission";
     
     
    function died($error) {
        // your error code can go here
        echo "Sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please hit your browser's back button and fix these errors.<br /><br />";
        die();
    }
     
    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['message'])) {
        died('Sorry, but there appears to be a problem with the form you submitted.');      
    }
     
    $first_name = $_POST['name']; // required
    $email_from = $_POST['email']; // required
    $comments = $_POST['message']; // required
    $spamtest = $_POST['phone']; // if this is filled in, it's a bot (since it's not displayed via css).
     
    $error_message = "";

    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The email address you entered does not appear to be valid.<br />';
  }

  //$string_exp = "/^[A-Za-z .'-]+$/";
  //if(!preg_match($string_exp,$first_name)) {
  //  $error_message .= 'The name you entered does not appear to be valid.<br />';
  //}

  if(strlen($comments) < 2) {
    $error_message .= 'Enter a real message.<br />';
  }

  // This will check if the PHONE field is filled in.  If it is, it's probably a spam bot.
  if(strlen($spamtest) > 0) {
    $error_message .= '<br />';
  }

  if(strlen($error_message) > 0) {
    died($error_message);
  }
    $email_message = "Form details below:\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     
    $email_message .= "Name: ".clean_string($first_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Message:\n\n".clean_string($comments)."\n";
     
     
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers); 
?>

<!--Success!-->
 
<?php
}
//include "index.html";
header("Location: http://www.mattgenovese.net/index.html?m=1");
die();
?>
