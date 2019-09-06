
<?
include("db_connect.php");
if(!isset($_GET['code'])){
	setcookie("redirect",$_GET['redirect']);
	header("Location: https://orcid.org/oauth/authorize?client_id=APP-P1P7N7T9YVBHQ4EH&response_type=code&scope=/authenticate&redirect_uri=http://rateapaper.nfshost.com/orcid-signin.php");
	die();
}

$vars  = array();
$code=$_GET['code'];
include("orcid_credentials.php");
$vars['client_id'] = $client_id;
$vars['client_secret'] = $client_secret;
$vars['grant_type'] = "authorization_code";
$vars['redirect_uri'] = "http://rateapaper.nfshost.com/orcid-signin.php";
$vars['code']= $code;
$data = http_build_query($vars);



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://orcid.org/oauth/token");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data);  //Post Fields
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
    'Accept: application/json'
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$server_output = curl_exec ($ch);

curl_close ($ch);

$result = json_decode($server_output, true);
if(!isset($result['orcid'])){
	print("Error\n");
	print_r($result);
	print("<a href='/orcid-signin.php'>Click here to try again.</a>");
	die();
}
$orcid = $result['orcid'];
include("salt.php");
$hashed_orcid = md5($orcid.$salt);
$time = time();
mysqli_query($link, "INSERT INTO users (time,hashed_orcid) VALUES ($time,'$hashed_orcid') ");
setcookie( "hashed_orcid", $hashed_orcid, time() + (10 * 365 * 24 * 60 * 60) );
header("Location: ".$_COOKIE['redirect'])
?>