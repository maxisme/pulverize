<?php
function generateRandomString($length = 5) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
//post
if(isset($_POST['submit'])) 
{
	//verify captcha
	$userIP = $_SERVER["REMOTE_ADDR"];
	$recaptchaResponse = $_POST['g-recaptcha-response'];
	$secretKey = "6Le_MhYTAAAAACl8JXVr-8vS5hI75qraJtTQyVGj";
	$request = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}&remoteip={$userIP}");
	
	if(!strstr($request, "true")){
		//echo "<span style='color:#bc2122'>Failed Captcha Verification!</span>";
	}else{
		$page = generateRandomString();
		$myfile = fopen($page.".php", "w");
		$content = '<?php 
$userIP = $_SERVER["REMOTE_ADDR"];
$recaptchaResponse = $_POST[\'g-recaptcha-response\'];
$secretKey = "6Le_MhYTAAAAACl8JXVr-8vS5hI75qraJtTQyVGj";
$request = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}&remoteip={$userIP}");

if(!strstr($request, "true")){
	//show recaptcha
	?>
	<link href=\'https://fonts.googleapis.com/css?family=Abel\' rel=\'stylesheet\' type=\'text/css\'>
	<style>
	*{
		font-family: \'Abel\', sans-serif;
		font-size:30px;
	}
	</style>
	<script src=\'https://www.google.com/recaptcha/api.js\'></script>
    Please verify you are not a cheeky robot.
    <form  method="post" action="<?php echo $_SERVER[\'PHP_SELF\']; ?>" >
        <div class="g-recaptcha" data-sitekey="6Le_MhYTAAAAADXTPBXN38FFQ8nBesq-JdzEYOws"></div>
        <input type="submit" name="submit" value="Submit">
    </form>
    
<?php 
}else{
	$file = $_SERVER[\'PHP_SELF\'];
	if($file != "index.php" && unlink(\'/var/www/xn--meh.cf/public_html\'.$file)){ 
	?>
	<link href=\'https://fonts.googleapis.com/css?family=Abel\' rel=\'stylesheet\' type=\'text/css\'>
	<style>
	*{
		font-family: \'Abel\', sans-serif;
		font-size:30px;
	}
	</style>
	<div align="center">
		'.$_POST['content'].'
	</div>
    <?php }
}';
		fwrite($myfile, $content);
		fclose($myfile);
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>✕</title>
<meta name="description" content="Simply enter a string(text) and find the length(amount of characters).">
<meta name="keywords" content="string, length, how many letters, charachters, letters, string length, strlen,">
<script src='https://www.google.com/recaptcha/api.js'></script>
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<meta name="author" content="Maximilian Mitchell">
<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<style>
*{
	font-family: 'Abel', sans-serif;
	font-size:30px;
}
#url{
	-webkit-text-fill-color: white;
    -webkit-text-stroke-width: 1px;
    -webkit-text-stroke-color: #bc2122;
	color:#bc2122;
	font-size:50px;
}
textarea{
	outline: none;
	border:1px solid #fff;
	width:100%;
	color:#4C4C4C;
	-webkit-appearance: none;
}
#extra{
	font-size:12px;
	color:#000;
}
input{
	border:1px solid #000;
	background: none;
}
#sendLink{ 
	font-size:30px;
	padding:20px;
	border:1px dashed #000;
}
</style>
<script>
$(document).ready(function() {

	$("#extra").hide();
	$("textarea").focus();
	
	$(document).not("#url").click(function(){
		$("textarea").focus();
	});
	
    $("textarea").keyup(function(){
		//for phone
		window.scrollTo(0, 0);
	});
});
</script>
</head>

<body>
	<form  method="post" action="/" >
    <div align="center">
    <?php if($page){?>
    	<span id='sendLink'>Link to message:<span id="url">⊗.cf/<?php echo $page?></span></span><br /><br />
    <?php }?>
        <br>
        <span style="font-size:40px">Write a self destructing message:</span>
        <textarea name="content" rows="8"><?php if($_GET["frm"] == "crypter"){ echo "Let's set our password to: ";}?></textarea> 
    </div>
    <div align="center">
        <div class="g-recaptcha" data-sitekey="6Le_MhYTAAAAADXTPBXN38FFQ8nBesq-JdzEYOws"></div><br />
        <input type="submit" name="submit" value="Create Link"> 
        </form>
    </div>
</body>
</html>
