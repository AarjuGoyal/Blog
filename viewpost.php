<?php
session_start();
?>
<!DOCTYPE html>
<head>
		<link rel="stylesheet" type="text/css" href="RegularPage.css">
</head>
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

if ($dbSuccess) {

	$postID = $_GET['id'];
	//echo "The post ID is ".$postID;
	/*if($stmt = $mysqli->prepare("SELECT postID, postTitle, postCont, postDate FROM blog_posts WHERE postID=?"))
	{
		echo "succesfully query run";
		$stmt->bind_param("i",$postID);

		$stmt->execute();

		$result = $stmt->get_result();

		printf("%s is the content",$result);

		$stmt->close();

    }
*/

	$showPostQuery = "SELECT postID, postTitle, postCont, postDate, Likes FROM BlogPosts WHERE postID=".$postID;
	//echo $showPostQuery;

	$result = mysqli_query($dbConnected,$showPostQuery);
	if(mysqli_num_rows($result) > 0)
	{
		
		echo "</br>";
		$row = mysqli_fetch_assoc($result);
	        echo '<div>';
		    echo '<h1>'.$row['postTitle'].'</h1>';
		    echo '<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>';
		    echo '<p>'.$row['postCont'].'</p>';   
		    echo '</br></br>';
		    echo $row['Likes'].' Likes';             
			echo '</div>';
		

		//echo "<br/>";

		

		if(isset($_SESSION['SESS_MEMBER_ID']))
		{
			?>
			<form method="POST">
				<input type="image" src="like2.png" name="Like" value="like" alt="Like" width="30" height="30">
			</form>
			<?php

			if(isset($_POST['Like']))
			{
				$query_Like = "Update BlogPosts SET Likes = Likes + 1 WHERE postID =".$postID;
				//echo $query_Like;
				if($result = mysqli_query($dbConnected,$query_Like))
				{
					echo "Liked";
					header("Refresh:0");
				}


			}
		}

		$show_AllComments = "SELECT commentCont, AuthorName FROM Comment WHERE PostID =".$postID." ORDER BY Date";
		//echo $show_AllComments;
		if($result = mysqli_query($dbConnected,$show_AllComments))
		{
			while ($row = mysqli_fetch_assoc($result))
			{
				echo "<div>";
				echo "<br/>".$row[0];
				echo "<br/>Written By: ".$row[1];
				echo "</div>";
			}
		}



		?>
		<br/><br/>
		<h3>Comment On this Post</h3>
		<form method='post' action = 'submitComment.php'>
		  Name: <input type='text' name='name' id='name' /><br />

		  Email: <input type='text' name='email' id='email' /><br />

		  Comment:<br />
		  <textarea name='comment' id='comment'></textarea><br />

		  <input type='hidden' name='postid' id='postid' value='<?php echo $postID; ?>' />

		  <input type='submit' value='Submit' />  
		</form>

		<?php
	}
	else
		echo "0 results";

	mysqli_close($dbConnected);

}




?>