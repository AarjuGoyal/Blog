<?php

/*
	File: SignUpAction.php
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

if ($dbSuccess) {
	
	{ //Collects all the information for Signup through POST

		$Email = $_POST["email"];
		$Password = $_POST["password"];
	}

	{ //Checks if all the values are appropriate
	}

	{ //Forms the SQL Query for insertion
		$SQL_insertUserInfo = "INSERT INTO BlogUsers ( ";
		$SQL_insertUserInfo .= "Email, ";
		$SQL_insertUserInfo .= "Password ";
		$SQL_insertUserInfo .= ") ";


		$SQL_insertUserInfo .= "VALUES ( ";
		$SQL_insertUserInfo .= "'".$Email."', ";
		$SQL_insertUserInfo .= "'".$Password."' ";
		$SQL_insertUserInfo .= " )";

		echo $SQL_insertUserInfo;

	}
	{ //Running the MySQL query
		if(mysqli_query($dbConnected,$SQL_insertUserInfo)) {
			echo "Signup SUCCESFUL";

		}
		else
			echo "Signup FAILED";

	}
}

?>