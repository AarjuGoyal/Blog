<?php
session_start();
{ 		//	Secure Connection Script
		$hostname = 'localhost';
		$username = 'root'; 
		$password = '';
		$dbSuccess = false;
		$dbConnected = mysqli_connect($hostname,$username,$password);
		$dbname = 'Blog_Ass_1';
		if ($dbConnected) {		
			$dbSelected = mysqli_select_db($dbConnected,$dbname);
			if ($dbSelected) {
				$dbSuccess = true;
			} else {
				echo "DB Selection FAILed";
			}
		} else {
				echo "MySQL Connection FAILed";
		}
		//	END	Secure Connection Script
}
if ($dbSuccess) {
	$BloggerID = $_GET['id']; //The Person who is to be followed
	$FollowerID = $_SESSION['SESS_MEMBER_ID'];

	$query_addFollwer = "INSERT INTO Follow (Blogger_ID,Follower_ID) VALUES (";
	$query_addFollwer .= $BloggerID.", ".$FollowerID.")";
	echo $query_addFollwer;
	if(mysqli_query($dbConnected,$query_addFollwer)) {
		echo "followed";
	}
}
?>