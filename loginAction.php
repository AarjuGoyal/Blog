<?php 
session_start();
echo "Login page";
/*
	File: loginAction.php
	Author: aarju
	Date: 18-08-2017
*/

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

	if($dbSuccess)
	{
		// echo "db connected";
		// $errmsg_arr = array();

		// $errflag = false;

		$username = $_POST["username"];
		$password = $_POST['password'];

		// echo $username." ".$password; 

		// //Input Validations
		// if($username == '') {
		// 	$errmsg_arr[] = 'Username missing';
		// 	$errflag = true;
		// }
		// if($password == '') {
		// 	$errmsg_arr[] = 'Password missing';
		// 	$errflag = true;
		// }

		// if($errflag) {
		// 	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		// 	session_write_close();
		// 	header("location: index.php");
		// 	exit();
		// }

		//Create query
		$qry="SELECT * FROM BlogUsers ";
		$qry .= "WHERE Email='".$username."' ";
		$qry .= "AND Password='".$password."'";
		echo "The query is ".$qry;
		$result=mysqli_query($dbConnected, $qry);

		if($result) {
			if(mysqli_num_rows($result) > 0) {
				//Login Successful
				//session_regenerate_id();
				$member = mysqli_fetch_assoc($result);
				echo "Query run succecfully";
				echo "The user_id is ".$member['User_ID'];
				$_SESSION['SESS_MEMBER_ID'] = $member['User_ID'];
				$_SESSION['SESS_FIRST_NAME'] = $member['Email'];
				$_SESSION['SESS_PASS'] = $member['Password'];
				session_write_close();
				if($member['Role'])
				{
					header("location: adminUsers.php");
				}
				else
				{
					//echo "Normal User";
					header("location: home.php");
				}
				
				exit();
			}else {
				//Login failed
				echo "The query was unseccfull";
				$errmsg_arr[] = 'user name and password not found';
				$errflag = true;
				if($errflag) {
					//$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
					//session_write_close();
					header("location: index.php");
					exit();
				}
			}
		}else {
			die("Query failed");
		}

	}
?>
	 