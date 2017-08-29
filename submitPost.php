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

		$user_ID = $_SESSION['SESS_MEMBER_ID'];
		$postTitle = $_POST['postTitle'];
		$postDesc = $_POST['postDesc'];
		$postCont = $_POST['postCont'];


		if(!isset($error)){

	    $query_insertPost = "INSERT INTO BlogPosts (";
	    $query_insertPost .= "Blogger_ID, ";
	    $query_insertPost .= "postTitle, ";
	    $query_insertPost .= "postDesc, ";
	    $query_insertPost .= "postCont";
	    $query_insertPost .= ") ";

		$query_insertPost .= "VALUES ( ";
		$query_insertPost .= $user_ID.", ";
		$query_insertPost .= "'".$postTitle."', ";
		$query_insertPost .= "'".$postDesc."', ";
		$query_insertPost .= "'".$postCont."'";
		$query_insertPost .= " )";

		echo "query is ".$query_insertPost;
	    $result = mysqli_query($dbConnected,$query_insertPost);
	    if($result) {
	    	echo "The query has been run succesfully";
	    	header("location: home.php?action=added");
	    }
	    else{
	    	echo "query unsuccesful";
	    }


	}

	}

?>