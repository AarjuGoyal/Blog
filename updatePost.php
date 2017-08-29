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
if($dbSuccess) {

	$Blogger_ID = $_SESSION['SESS_MEMBER_ID'];
	$postID = $_GET['id'];

	$showPostQuery = "SELECT postID, postTitle, postDesc, postCont, postDate ";
	$showPostQuery .= "FROM BlogPosts WHERE postID=".$postID;
	$showPostQuery .= " AND Blogger_ID=".$Blogger_ID;
	
	//echo $showPostQuery;
	if($result = mysqli_query($dbConnected,$showPostQuery)) {
		$row = mysqli_fetch_row($result);
		
		echo "<form action='' method='post'>";
	    	echo "<input type='hidden' name='postID' value=".$row[0].">";

	    	echo "<p><label>Title</label><br />";
	    	echo "<input type='text' name='postTitle' value='".$row[1]."' ></p>";

	    	echo "<p><label>Description</label><br />";
	    	echo "<textarea name='postDesc' cols='60' rows='10'>".$row[2]."</textarea></p>";

	    	echo "<p><label>Content</label><br />";
	    	echo "<textarea name='postCont' cols='60' rows='10'>".$row[3]."</textarea></p>";

	    	echo "<p><input type='submit' name='submit' value='Update'></p>";

		echo "</form>";

			if(isset($_POST['submit'])) {

		    	$_POST = array_map( 'stripslashes', $_POST );

			    //collect form data
			    extract($_POST);

			    //very basic validation
			    if($postID ==''){
			        $error[] = 'This post is missing a valid id!.';
			    }

			    if($postTitle ==''){
			        $error[] = 'Please enter the title.';
			    }

			    if($postDesc ==''){
			        $error[] = 'Please enter the description.';
			    }

			    if($postCont ==''){
			        $error[] = 'Please enter the content.';
			    }

			    if(!isset($error)){
			    	$query_Update = "UPDATE BlogPosts SET ";
			    	$query_Update .= "postTitle = '".$postTitle."', ";
			    	$query_Update .= " postDesc = '".$postDesc."', ";
			    	$query_Update .= " postCont = '".$postCont."' ";
			    	$query_Update .= " WHERE postID = ".$postID;
			    	$query_Update .= " AND Blogger_ID = ".$Blogger_ID;
			    	echo $query_Update;

			    	if(mysqli_query($dbConnected,$query_Update))
			    	{
			    		echo "post updated succesfully";
			    	}
		    	}
			}
			mysqli_close($dbConnected);
	}

	echo "<button><a href='home.php'>Go Back</a></button>";
}

?>