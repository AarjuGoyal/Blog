<?php
session_start();
?>
<!DOCTYPE html>
<head>
	<title>Blog</title>
	<link rel="stylesheet" type="text/css" href="FirstPage.css">
</head>

<body>
	<div class="headerBand">

		<form method="post" action="search.php" float="left" align= "left">
        	<input type="text" name="search" placeholder="Search">
        	<input type="submit" value="Submit">
    	</form>
	<?php
	if(isset($_SESSION['SESS_MEMBER_ID']))
	{
		?><button id="BasicButton" style="width:auto;">
		<a href="home.php"><?php echo $_SESSION['SESS_FIRST_NAME']; ?></a>
		</button>
		<?php
	}
	else
	{ ?>
	
		<!-- Login Button -->
		<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;" id="BasicButton">Login</button>

		<div id="id01" class="modal">
			<form name="loginForm" class="modal-content animate" action="loginAction.php" method="post">
	    
		    <div class="container">
		      <label><b>Email </t>   </b></label>
		      <input type="text" placeholder="Enter Email" name="username" required>
		      </br> </br>
		      <label><b>Password</b></label>
		      <input type="password" placeholder="Enter Password" name="password" required>
		        
		      <!-- <input type="submit" name="submit" value="Login"  /> -->
		    </div>

		    <div class="container" style="background-color:#f1f1f1">
		      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
		      <button type="submit" class="loginbtn" id="login">Login</button>
		      <!-- <span class="psw">Forgot <a href="#">password?</a></span> -->
		    </div>

	  		</form>
		</div>


		<!-- SignUp Button -->
		<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;" id="BasicButton">Sign Up</button>

		<div id="id02" class="modal">
		  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">X</span>
		  <form name="signUpForm" class="modal-content animate" action="SignUpAction.php" method="post">
		    <div class="container">
		      <label><b>Name</b></label>
		  	</br>
		      <input type="text" placeholder="Enter Name" name="name" required>
		      <br/>

		      <label><b>Email</b></label>
		  </br>
		      <input type="text" placeholder="Enter Email" name="email" required>
		      </br>

		      <label><b>Password</b></label>
		  </br>
		      <input type="password" placeholder="Enter Password" name="password" onkeyup='check();'id="password" required>
		      </br>

		      <label><b>Repeat Password</b></label>
		  </br>
		      <input type="password" placeholder="Repeat Password" id="confirm_password" onkeyup='check();' required>
		      <span id='message'></span>

		      <?php 
	    		if(isset($msg)){  // Check if $msg is not empty
	        		echo '<div>'.$msg.'</div>'; // Display our message and wrap it with a div with the class "statusmsg".
	    		} 
			  ?>
		      <!-- <input type="checkbox" checked="checked"> Remember me -->
		      <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

		      <div class="clearfix">
		        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
		        <button type="submit" class="signupbtn" id="signup" disabled>Sign Up</button>
		      </div>
		    </div>
		  </form>
		</div>
		<?php
	}
	?>
	</div>
	<div id="banner">
	<div class="heading1">
		Blog
		<br/>
		Write. Read. Explore.
		<br/>	
	</div>
	</div>

	<script>
	// Get the modal for login
	var loginModal = document.getElementById('id01');

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	    if (event.target == loginModal) {
	        loginModal.style.display = "none";
	    }
	}


	// Modal for Signup
	var signUpModal = document.getElementById('id02');

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	    if (event.target == signUpModal) {
	        signUpModal.style.display = "none";
	    }
	}
	//Check to see if the confirm password and pasword are same
	var check = function() {
  	
  	if (document.getElementById('password').value ==
    document.getElementById('confirm_password').value) {

    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'matching';
    document.getElementById('signup').disabled = false; //enable the submit button
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'not matching';
    document.getElementById('signup').disabled = true; //disable the submit button
  }
}

	</script>
	<?php

		//echo "All the posts";
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



			{//Displaying all the authors
	    		$query_AllBloggers = "SELECT User_ID,Name FROM BlogUsers WHERE Role IS NOT true";
	    		if($result= mysqli_query($dbConnected,$query_AllBloggers))
	    		{
	    			
	    			?>
	    			<div class="author">
	    			<?php
	    			echo "<h2>All the authors</h2>";
	    			while($row=mysqli_fetch_row($result))
	    			{
	    				echo "</br>";
	    				echo '<p><a href="viewUser.php?id='.$row[0].'">'.$row[1].'</a></p>';
	    			}
	    			?>
	    			</div>
	    			<?php
	    		}

    		}

			$showPostQuery = "SELECT postID, postTitle, postDate, postDesc FROM BlogPosts ORDER BY postID DESC";
			//echo $showPostQuery;

			if ($result=mysqli_query($dbConnected,$showPostQuery))
			{
			  echo "<br/>all the posts are listed below<br/>";
			  // Fetch one and one row
			  while ($row=mysqli_fetch_row($result))
			  {
			    ?>
			    <div class="post">
			   	<?php
                echo '<h1><a href="viewpost.php?id='.$row[0].'">'.$row[1].'</a></h1>';
                echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row[2])).'</p>';
                echo '<p>'.$row[3].'</p>';                
                echo '<p><a href="viewpost.php?id='.$row[0].'">Read More</a></p>';                
            	?>
            	</div>
            	<?php
			  }
			  // Free result set
			  mysqli_free_result($result);
			}
			else {
				echo "some problem has occured";
			}


		}

		// if(isset($_POST['name']) && !empty($_POST['name']) AND isset($_POST['email']) && !empty($_POST['email'])){
  //       // Form Submited
		// 	$name = mysql_escape_string($_POST['name']); // Turn our post into a local variable
  //   		$email = mysql_escape_string($_POST['email']); // Turn our post into a local variable
  //   		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
  //   			// Return Error - Invalid Email
  //   			$msg = 'The email you have entered is invalid, please try again.';
		// 	} else {
  //   			// Return Success - Valid Email
  //   			$msg = 'Your account has been made, <br /> please verify it by clicking the activation link that has been send to your email.';
		// 	}
  //   	}
    	
		mysqli_close($dbConnected);

	?>
	<?php
	/*if(isset($_POST['submit']))           //send the submitted data
    {
	    $name=$_REQUEST['name'];
	    $email=$_REQUEST['email'];
	    $message=$_REQUEST['message'];
	    if (($name=="")||($email=="")||($message==""))
	    {
			echo "All fields are required, please fill <a href=\"\">the form</a> again.";
		}
	    else
	    {		
		    
		    $query_submitMessage = "INSERT INTO ContactUs (AuthorName,AuthorEmail,QueryCont) VALUES (";
		    $query_submitMessage .= "'".$name."', ";
		    $query_submitMessage .= "'".$email."', ";
		    $query_submitMessage .= "'".$message."' )";
			echo $query_submitMessage;
			if(mysqli_query($dbConnected,$query_submitMessage))
			{
				//header('location: dummyPage.php');
			}
		}
  	}*/	
    ?>
    <div class="bottomBand">
    	<h2>Contact Us</h2>
    <form  action="contactUs.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="submit">
    Your name:<br>
    <input name="name" type="text" value="" size="15"/><br>
    Your email:<br>
    <input name="email" type="text" value="" size="15"/><br>
    Your message:<br>
    <textarea name="message" rows="7" cols="30"></textarea><br>
    <input type="submit" value="Send Message"/>
    </form>
	</div>
    <?php
	
    
?>
</body>

</html>