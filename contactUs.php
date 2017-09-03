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
if($dbSuccess) {


	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	$query_submitMessage = "INSERT INTO ContactUs (AuthorName,AuthorEmail,QueryCont) VALUES (";
	$query_submitMessage .= "'".$name."', ";
	$query_submitMessage .= "'".$email."', ";
    $query_submitMessage .= "'".$message."' )";
    echo $query_submitMessage;
	if(mysqli_query($dbConnected,$query_submitMessage))
	{
				
		?>
		<script type="text/javascript">
		window.alert("Message Submitted. We will reach you shortly");
		</script>
		<?php
		echo "Message submitted";
		header('location: index.php');
	}

}
?>