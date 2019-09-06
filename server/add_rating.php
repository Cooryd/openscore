<?php
include("db_connect.php");
if(isset($_COOKIE['hashed_orcid'])){
	$user = $_COOKIE['hashed_orcid'];
	$result = mysqli_query($link,"SELECT * FROM users WHERE hashed_orcid = '$user'");
	if (mysqli_num_rows($result)==0){
		die("Invalid hash");
	}
}
else{
	die("need_orcid"); 
}




$question = $_POST['question'];
$answer = $_POST['answer'];
$doi = $_POST['doi'];
$timestamp = time();
$sql = "INSERT INTO ratings (doi, question, answer, timestamp,user)  VALUES 	('$doi', $question, $answer, $timestamp,'$user') ON DUPLICATE KEY UPDATE answer=$answer"; 

mysqli_query($link,$sql);

?>