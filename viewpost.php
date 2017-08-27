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
	echo "The post ID is ".$postID;
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

	$showPostQuery = "SELECT postID, postTitle, postCont, postDate FROM BlogPosts WHERE postID=".$postID;
	echo $showPostQuery;

	$result = mysqli_query($dbConnected,$showPostQuery);
	if(mysqli_num_rows($result) > 0)
	{
		
		echo "</br>";
		while($row = mysqli_fetch_assoc($result)) {
	        echo '<div>';
		    echo '<h1>'.$row['postTitle'].'</h1>';
		    echo '<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>';
		    echo '<p>'.$row['postCont'].'</p>';                
			echo '</div>';
		}
	}
	else
		echo "0 results";

	mysqli_close($dbConnected);

}




?>