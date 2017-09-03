<?php
?>
<!DOCTYPE html>
<head>
	<title>
		Blogger Information
	</title>
	<link rel="stylesheet" type="text/css" href="UserPage.css">
</head>
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
	
	$User_ID = $_GET['id'];
	if(isset($_SESSION['SESS_MEMBER_ID'])) //The User logged in follows the Author who's posts he is seeing
	{
		if($_SESSION['SESS_MEMBER_ID'] != $User_ID)
		{
		?>
		<button id='BasicButton'><a href='dummyPage.php?id=<?php echo $User_ID?>'>Follow</a></button>
		<?php
		}
	}
	{//Script to display all the posts of the blogger
		$query_displayAllPosts = "SELECT postID, postTitle, postDesc, postCont, postDate ";
		$query_displayAllPosts .= "FROM BlogPosts ";
		$query_displayAllPosts .= "WHERE Blogger_ID = ".$User_ID;

		//echo "The query is ".$query_displayAllPosts;
		if($result = mysqli_query($dbConnected,$query_displayAllPosts))
		{
			//echo "All your posts ";
			while($row = mysqli_fetch_row($result))
			{
				echo '<div>';
		    	echo '<h1>'.$row[1].'</h1>';
		    	echo '<p>Posted on '.date('jS M Y', strtotime($row[4])).'</p>';
		    	echo '<p>'.$row[3].'</p>';                
				echo '</div>';
			}
		}

	}
	


}

?>