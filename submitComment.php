<?php

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
	$postID = $_POST["postid"];
	$Name = $_POST["name"];
	$Email = $_POST["email"];
	$Comment = $_POST["comment"];

	$query_InsertComment = "INSERT INTO Comment (postID, AuthorName,AuthorEmail,commentCont) ";
	$query_InsertComment .= "VALUES (".$postID.", ";
	$query_InsertComment .= "'".$Name."', ";
	$query_InsertComment .= "'".$Email."', ";
	$query_InsertComment .= "'".$Comment."')";

	echo $query_InsertComment;
	if(mysqli_query($dbConnected,$query_InsertComment))
	{
		echo "<br/> Succesfully Inserted Comment";
	}
}

?>