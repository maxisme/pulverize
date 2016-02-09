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
$page = false;
//post
if(isset($_POST['submit']) && isset($_POST['g-recaptcha-response'])) 
{
	//verify captcha
	$userIP = $_SERVER["REMOTE_ADDR"];
	$recaptchaResponse = $_POST['g-recaptcha-response'];
	$config = parse_ini_file('/NAS/pulverize.xyz/db.ini');
	$secretKey = $config['secret'];
	$request = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}&remoteip={$userIP}");
	
	if(!strstr($request, "true")){
		$one = true;
	}else{
		$page = generateRandomString();
		$myfile = fopen($page.".php", "w");
		$content = '<?php 
$userIP = $_SERVER["REMOTE_ADDR"];
$recaptchaResponse = $_POST[\'g-recaptcha-response\'];
$secretKey = "'.$secretKey.'";
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
        <div class="g-recaptcha" data-sitekey="6Ld98RYTAAAAALao0zkGHCEYDL6dV0CojDK-QgVk"></div>
        <input type="submit" name="submit" value="Submit">
    </form>
    
<?php 
}else{
	$file = $_SERVER[\'PHP_SELF\'];
	if($file != "index.php" && unlink("/NAS/xn--meh.cf/public_html".$file)){ 
	?>
	<link href=\'https://fonts.googleapis.com/css?family=Abel\' rel=\'stylesheet\' type=\'text/css\'>
	<style>
	*{
		font-family: \'Abel\', sans-serif;
		font-size:30px;
	}
	</style>
	<div align="center">
		<span style="padding:10px;border: 1px solid #000;font-size:20px;color:#ccc;" align="center">This message has already been deleted. Once you leave this page it will no longer be accessible.</span><br /><br />
		'.htmlspecialchars(strip_tags($_POST['content'])).'
	</div>
    <?php }}';
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
<meta name="description" content="SEND SELF DESTRUCTING MESSAGES.">
<meta name="keywords" content="">
<script src='https://www.google.com/recaptcha/api.js'></script>
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<meta name="author" content="Maximilian Mitchell">
<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="clipboard.js"></script>
<?php include_once("analyticstracking.php") ?>
<style>
*{
	font-family: 'Abel', sans-serif;
	font-size:30px;
	margin:0px;
	padding:0px;
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
input:hover{
	  background: -webkit-linear-gradient(left top,#F4F4F4, #fff); /* For Safari 5.1 to 6.0 */
	  background: -o-linear-gradient(left top,#F4F4F4, #fff); /* For Opera 11.1 to 12.0 */
	  background: -moz-linear-gradient(left top,#F4F4F4, #fff); /* For Firefox 3.6 to 15 */
	  background: linear-gradient(left top,#F4F4F4, #fff); /* Standard syntax */
	  cursor:pointer;
}
#sendLink{ 
	font-size:30px;
	border:1px dashed #000;
	padding:10px; 
}
#git{
	position:absolute;
	right:5px;
}
</style>
<script>
function SelectText(element) {
    var text = document.getElementById(element);
    if ($.browser.msie) {
        var range = document.body.createTextRange();
        range.moveToElementText(text);
        range.select();
    } else if ($.browser.mozilla || $.browser.opera) {
        var selection = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(text);
        selection.removeAllRanges();
        selection.addRange(range);
    } else if ($.browser.safari) {
        var selection = window.getSelection();
        selection.setBaseAndExtent(text, 0, text, 1);
    }
}
$(document).ready(function() {

	$("#extra").hide();
	$("textarea").focus();
	
	$(document).not("#url").click(function(){
		$("textarea").focus();
	});
	
	$("#url").hover(function(){
		SelectText($(this));
	});
	
    $("textarea").keyup(function(){
		//for phone
		window.scrollTo(0, 0);
	});
	
	var clipboard = new Clipboard('#copy', {
		text: function(trigger) {
			return $("#url").text();
		}
	});
	
	clipboard.on('success', function(e) {
		$("#copy").hide();
	});

});
</script>
</head>

<body>
	<form method="post" action="/" >
        <div align="center">
        <?php if($page){?><br /><br />
            <span id='sendLink'>Share self destructing link:<span id="url">⊗.cf/<?php echo $page?></span>  <img id="copy" src="paper42.svg" height="20px" /></span><br /><br /><a href="/">Back</a>
        <?php }else{?> 
            <span style="font-size:40px"><br />
Write a self destructing message</span><br /><br />
            <!-- if from crypter.co.uk -->
            <textarea style="border: 1px dashed #333;width:90%;" name="content" rows="8"><?php if(isset($_GET["crypter"])){ echo "Here is a password for our chat on Crypter: \n\n".generateRandomString(15);}?></textarea> <br />
            
            <?php
			if($one){
				echo "<div align='center'><span id='failedCaptcha' style='color:#bc2122'>Failed Captcha Verification!</span></div>";
			}else{
				echo "<br />";
			}
			?>
            <div class="g-recaptcha" data-sitekey="6Ld98RYTAAAAALao0zkGHCEYDL6dV0CojDK-QgVk"></div><br />
            <input onclick="document.getElementById(failedCaptcha).style.display = 'none';" type="submit" name="submit" style="padding:10px; border-radius:5px;" value="Create Self Destructing Link">
            <br /><br />
    <a target="_blank" href="https://github.com/maxisme/pulverize"><img src="git.png" height="20px" /></a>
        </div>
    </form>
    <?php }?>
</body>
</html>

