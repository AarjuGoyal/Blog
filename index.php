<!DOCTYPE html>
<head>
	<title>Blog</title>
	<link rel="stylesheet" type="text/css" href="FirstPage.css">
</head>

<body>
	
	<div class="heading1">
		Welcome to Polar Bear Blog
	</div>
	<!-- Login Button -->
	<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>

	<div id="id01" class="modal">
		<form name="loginForm" class="modal-content animate" action="loginAction.php" method="post">
    
	    <div class="container">
	      <label><b>Username</b></label>
	      <input type="text" placeholder="Enter Username" name="uname" required>
	      </br> </br>
	      <label><b>Password</b></label>
	      <input type="password" placeholder="Enter Password" name="psw" required>
	        
	      <input type="submit" name="submit" value="Login"  />
	      <input type="checkbox" checked="checked"> Remember me
	    </div>

	    <div class="container" style="background-color:#f1f1f1">
	      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
	      <span class="psw">Forgot <a href="#">password?</a></span>
	    </div>

  		</form>
	</div>


	<!-- SignUp Button -->
	<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Sign Up</button>

	<div id="id02" class="modal">
	  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">X</span>
	  <form name="signUpForm" class="modal-content animate" action="SignUpAction.php" method="post">
	    <div class="container">
	      <label><b>Email</b></label>
	      <input type="text" placeholder="Enter Email" name="email" required>

	      <label><b>Password</b></label>
	      <input type="password" placeholder="Enter Password" name="password" onkeyup='check();'id="password" required>

	      <label><b>Repeat Password</b></label>
	      <input type="password" placeholder="Repeat Password" id="confirm_password" onkeyup='check();' required>
	      <span id='message'></span>
	      <!-- <input type="checkbox" checked="checked"> Remember me -->
	      <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

	      <div class="clearfix">
	        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
	        <button type="submit" class="signupbtn" id="signup" disabled>Sign Up</button>
	      </div>
	    </div>
	  </form>
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

		echo "All the posts";
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
			$showPostQuery = "SELECT postID, postTitle, postDate FROM BlogPosts ORDER BY postID DESC";
			//echo $showPostQuery;

			if ($result=mysqli_query($dbConnected,$showPostQuery))
			{
			  echo "<br/>all the posts are listed below<br/>";
			  // Fetch one and one row
			  while ($row=mysqli_fetch_row($result))
			  {
			    echo '<div>';
                echo '<h1><a href="viewpost.php?id='.$row[0].'">'.$row[1].'</a></h1>';
                echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row[2])).'</p>';
                //echo '<p>'.$row['postDesc'].'</p>';                
                echo '<p><a href="viewpost.php?id='.$row[0].'">Read More</a></p>';                
            	echo '</div>';
			  }
			  // Free result set
			  mysqli_free_result($result);
			}
			else {
				echo "some problem has occured";
			}


		}
		mysqli_close($dbConnected);

	?>
</body>

</html>