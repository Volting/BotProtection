<?php
/* BotProtection by Volting
v1.0 | Last update: 17/06/2018 - 16:34
https://gitlab.com/Volting/BotProtection
*/

// Don't forget to configure me !
$siteKey = '6Lf4X18UAAAAAJ7pYbOBv2Yt7Vs3XE9L65G7oVU9';
$secret = '6Lf4X18UAAAAAPOdNzSKWqADCxuIG9ToXFlJdcuV';

require 'recaptchalib.php';

if(session_status() == PHP_SESSION_NONE) { session_start(); }

if(!isset($_SESSION['BotProtectionValidated'])){ $_SESSION['BotProtectionValidated'] = 'false'; }

if(isset($_POST['g-recaptcha-response'])){
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];
    $api_url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$response."&remoteip=".$remoteip;
    $decode = json_decode(file_get_contents($api_url), true); 
	if ($decode['success'] == true) {
		$_SESSION['BotProtectionValidated'] = 'true';
	} 
}


if($_SESSION['BotProtectionValidated'] != 'true'){ ?>
<html>
<head>
<title>Verification</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<script src="https://www.google.com/recaptcha/api.js"></script>
<style>
.content {
  margin-top: 50vh;
  transform: translateY(-50%);
}
</style>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#edeff5",
      "text": "#838391"
    },
    "button": {
      "background": "#4b81e8"
    }
  },
  "theme": "classic",
  "position": "bottom-left"
})});
</script>
</head>
<body>
<center class="content">
<h1>Verification</h1>
<br>
<form method="post">
<div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
<br>
<input type="submit" class="btn btn-primary" />
</form>
</center>
</body>
<?php 
    die();
}
?>