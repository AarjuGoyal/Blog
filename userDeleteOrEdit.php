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

if($dbSuccess)
{
	if(isset($_GET['deluser'])){ 

		//if user id is 1 ignore
		if($_GET['deluser'] !='1'){

    		$UserID = $_GET['deluser'];
    		$query_deleteUser = "DELETE FROM BlogUsers WHERE User_ID = ".$UserID;
    		echo $query_deleteUser;
    		if(mysqli_query($dbConnected,$query_deleteUser))
    		{
    			echo "User Deleted";
    			header('Location: adminUsers.php?action=deleted');
    			exit;
    		}
    		
    		// $stmt->execute(array(':memberID' => $_GET['deluser']));

    		// header('Location: users.php?action=deleted');
    		// exit;

	    }
	}

	if(isset($_GET['edit'])) {
		$UserID = $_GET['edit'];
		$query_LoadUser = "SELECT User_ID, Name, Email FROM BlogUsers WHERE User_ID = ".$UserID;
		if($result = mysqli_query($dbConnected,$query_LoadUser))
		{
			$row = mysqli_fetch_row($result);
			?>
			<form action='' method='post'>
			    <input type='hidden' name='memberID' value='<?php echo $row[0];?>'>

			    <p><label>Username</label><br />
			    <input type='text' name='username' value='<?php echo $row[1];?>'></p>

			    <p><label>Password (only to change)</label><br />
			    <input type='password' name='password' value=''></p>

			    <p><label>Confirm Password</label><br />
			    <input type='password' name='passwordConfirm' value=''></p>

			    <p><label>Email</label><br />
			    <input type='text' name='email' value='<?php echo $row[2];?>'></p>

			    <p><input type='submit' name='submit' value='Update User'></p>

			</form>
			<?php

			$_POST = array_map( 'stripslashes', $_POST );

			    //collect form data
			extract($_POST);
			if( strlen($password) > 0){

			    if($password ==''){
			        $error[] = 'Please enter the password.';
			    }

			    if($passwordConfirm ==''){
			        $error[] = 'Please confirm the password.';
			    }

			    if($password != $passwordConfirm){
			        $error[] = 'Passwords do not match.';
    			}

			}

			if(isset($password))
			{

			    //$hashedpassword = $user->create_hash($password);

			    //update into database
			    $query_EditInfo = "UPDATE BlogUsers SET ";
			    $query_EditInfo .= "Name = '".$username."'";
			    $query_EditInfo .= ", Email = '".$email."'";
			    $query_EditInfo .= ", Password= '".$password."'";
			    $query_EditInfo .= " WHERE User_ID = ".$memberID;
			    
			    if(mysqli_query($dbConnected,$query_EditInfo))
			    {
			    	echo "User Updated";
			    	header('Location: adminUsers.php?action=edited');
    				exit;
			    }


			}
			else
			{

			    $query_EditInfo = "UPDATE BlogUsers SET ";
			    $query_EditInfo .= "Name = '".$username."'";
			    $query_EditInfo .= ", Email = '".$email."'";
			    $query_EditInfo .= " WHERE User_ID = ".$memberID;
			    //update database
			    if(mysqli_query($dbConnected,$query_EditInfo))
			    {
			    	echo "User Updated";
			    	header('Location: adminUsers.php?action=edited');
    				exit;
			    }
			}

		}
	}
	if(isset($_GET['perm']))
	{
		$perm = $_GET['perm'];
		$userID = $_GET['id'];
		$query_ChangePerm = "UPDATE BlogUsers SET Permission = ".$perm." WHERE User_ID = ".$userID;
		if(mysqli_query($dbConnected,$query_ChangePerm))
		{
	    	echo "Permission Changed";
	    	header('Location: adminUsers.php?action=PermChanged');
    		exit;
	    }
	}

	if(isset($_GET['contactDel']))
	{

		$deleteContact = $_GET['contactDel'];
		$query_DeleteContactMe = "DELETE FROM ContactUs WHERE QueryID =".$deleteContact;
		if(mysqli_query($dbConnected,$query_DeleteContactMe))
		{
			echo "Contact Deleted";
			header('Location: adminUsers.php?action=deleted');
    		exit;
		}

	}
}

?>