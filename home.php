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

	echo "This is the homepage of the user";
	$User_ID = $_SESSION['SESS_MEMBER_ID'];
	$Name = $_SESSION['SESS_FIRST_NAME'];
	//$Password = $_SESSION['SESS_PASS'];


	echo "Member ID is ".$User_ID;
	?>

	<form action='submitPost.php' method='post'>

	    <p><label>Title</label><br />
	    <input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>

	    <p><label>Description</label><br />
	    <textarea name='postDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

	    <p><label>Content</label><br />
	    <textarea name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>

	    <p><input type='submit' name='submit' value='Submit'></p>

	</form>


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

	<?php

		

}


?>
