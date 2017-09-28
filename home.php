<?php
session_start();
?>
<!DOCTYPE html>
<head>
	<title>HomePage</title>
	<link rel="stylesheet" type="text/css" href="UserPage.css">
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

	//echo "This is the homepage of the user<br/>";
	$User_ID = $_SESSION['SESS_MEMBER_ID'];
	$Name = $_SESSION['SESS_FIRST_NAME'];
	?>
	<div class="headerBand">
		<button id="BasicButton" align="right" onClick="dummyPage.php">
			<?php echo $_SESSION['SESS_FIRST_NAME']; ?>
			
		</button>
	</div>
	<?php
	//$Password = $_SESSION['SESS_PASS'];

	echo "Hello ".$Name."<br/>";
	//echo "Member ID is ".$User_ID;
	$query_getPermission = "SELECT Permission FROM BlogUsers WHERE User_ID=".$User_ID;
	$PerResult = mysqli_query($dbConnected,$query_getPermission);
	$PerRow = mysqli_fetch_row($PerResult);
	if($PerRow[0])
	{
	?>
		<button id="myBtn">Write New Post</button>

		<!-- The Modal -->
		<div id="myModal" class="modal">
		<form action='submitPost.php' method='post'>

		    <p><label>Title</label><br />
		    <input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>

		    <p><label>Description</label><br />
		    <textarea name='postDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

		    <p><label>Content</label><br />
		    <textarea name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>

		    <p><input type='submit' name='submit' value='Submit'></p>
		    <button type="button" onclick="document.getElementById('myModal').style.display='none'" class="cancelbtn">Cancel</button>

		</form>
	</div>


		<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
		<script>
		        tinymce.init({
		            selector: "textarea",
		            plugins: [
		                "advlist autolink lists link image charmap print preview anchor",
		                "searchreplace visualblocks code fullscreen",
		                "insertdatetime media table contextmenu paste"
		            ],
		            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
		        });
		</script>
		<script>
			// Get the modal
			var modal = document.getElementById('myModal');

			// Get the button that opens the modal
			var btn = document.getElementById("myBtn");

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];

			// When the user clicks the button, open the modal 
			btn.onclick = function() {
			    modal.style.display = "block";
			}

			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
			    modal.style.display = "none";
			}

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
			    if (event.target == modal) {
			        modal.style.display = "none";
			    }
			}
		</script>

	<?php
	}
	else
	{
		echo "You have been denied permission to write further posts. Please Contact Admin<br/>";
	}
	?>
	<div class="Notification">
		<?php
			echo "<h2>Notifications</h2>";
			$query_getNotification = "SELECT B.postTitle,B.postDate, B.postDesc, U.Name FROM Follow F, BlogPosts B, BlogUsers U Where F.Follower_ID = ".$User_ID." and B.Blogger_ID = F.Blogger_ID and U.User_ID = B.Blogger_ID ORDER BY B.postDate DESC";
			//echo $query_getNotification;
			if($result = mysqli_query($dbConnected,$query_getNotification))
			{
				while($row = mysqli_fetch_row($result))
				{
					echo $row[3]." posted on ".$row[0]." on ".$row[1]."</br>";
					echo "Description: ".$row[2];
					echo "</br></br>";
				}

			}
		?>
	</div>
	<?php	
	{//Script to display all the posts of the blogger
		
		echo "</br></br>";
		$query_displayAllPosts = "SELECT postID, postTitle, postDesc, postCont, postDate ";
		$query_displayAllPosts .= "FROM BlogPosts ";
		$query_displayAllPosts .= "WHERE Blogger_ID = ".$User_ID;

		//echo "The query is ".$query_displayAllPosts;
		if($result = mysqli_query($dbConnected,$query_displayAllPosts))
		{
			echo "All your posts ";
			while($row = mysqli_fetch_row($result))
			{
				?>
				<div class="post">
			   	<?php
                echo '<h1><a href="viewpost.php?id='.$row[0].'">'.$row[1].'</a></h1>';
                echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row[4])).'</p>';
                echo '<p>'.$row[2].'</p>';                
                echo '<p><a href="viewpost.php?id='.$row[0].'">Read More</a></p>';                
            	?>
            	</div>
				<?php
				echo '<button><a href="updatePost.php?id='.$row[0].'">'."Update".'</a></button>';	
			}

		  mysqli_free_result($result);

		}

	}
	echo '</br></br>';
	echo "<button><a href='logout.php'>Logout</a></button>";
	echo "<button><a href='index.php'>Go to index page</a></button>";

}



?>

</html>
