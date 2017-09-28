<?php

session_start();
?>
<!DOCTYPE html>
<head>
	<title>
		Admin Page
	</title>
	<link rel="stylesheet" type="text/css" href="AdminPage.css">
</head>
<div class="headerBand">
		<button id="BasicButton" align="right" onClick="dummyPage.php">
			<?php echo $_SESSION['SESS_FIRST_NAME']; ?>	
		</button>
		<button id="BasicButton" align="right">
			<a href='logout.php'>Logout</a>
		</button>
</div>	
<?php
echo "Admin Page";


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
		$query_retrieveAllUsers = "SELECT User_ID, Name, Email, Role, Permission FROM BlogUsers ORDER BY Name";
		//echo $query_retrieveAllUsers;
		if ($result = mysqli_query($dbConnected,$query_retrieveAllUsers))
		{
			?>
			<table>
				<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Edit</th>
				<th>Delete</th>
				<th>Change Permission</th>
				</tr>
			<?php

			while($row = mysqli_fetch_row($result))
			{
				?>
				<br/>
				<tr>
	    			<td><?php echo $row[1]?></td>
	    			<td><?php echo $row[2]?></td>
	    			<td>
	        			<a href="userDeleteOrEdit.php?edit=<?php echo $row[0];?>">Edit</a>
	        		</td>
	        		<?php 
	        		if($row[3] != 1)
	        		{	?>
		            	<td>
		            		<a href="javascript:deluser('<?php echo $row[0];?>','<?php echo $row[1];?>')">Delete</a>
		        		</td>
		        		
		        		<?php
			        		if($row[4])
			        		{
			        			?>
			        			<td>
			        			<a href="userDeleteOrEdit.php?perm=0&id=<?php echo $row[0];?>">Deny Permission to Post</a>
			        			</td>
			        			<?php
			        		}
			        		else
			        		{
			        			?>
			        			<td>
			        			<a href="userDeleteOrEdit.php?perm=1&id=<?php echo $row[0];?>">Acess Permission to Post</a>
			        			</td>
			        			<?php
			        		}
	        		}
	        		?>
        		</tr>
        		<?php
        		
    		}
    		?>
    		</table>
    		<?php
		}
		
		?>
		<script language="JavaScript" type="text/javascript">
		function deluser(id, title)
		{
  			if (confirm("Are you sure you want to delete '" + title + "'"))
  			{
     			 window.location.href = 'userDeleteOrEdit.php?deluser=' + id;
  				//window.location.href = 'dummyPage.php';
  			}
		}
		</script>
		<br/><br/><br/><br/>
		<?php
		

		$query_retrieveAllMessages = "SELECT * FROM ContactUs";
		if($result = mysqli_query($dbConnected,$query_retrieveAllMessages))
		{
			?>
			<table id="table">
				<tr>
					<th>QueryNo.</th>
					<th>Name</th>
					<th>EmailID</th>
					<th>Message</th>
					<th>Delete</th>
					<th>Reply</th>
				</tr>
			<?php
				while($row = mysqli_fetch_row($result))
				{
					?>
					<tr>
						<td><?php echo $row[0]?></td>
						<td><?php echo $row[1]?></td>
						<td><?php echo $row[2]?></td>
						<td><?php echo $row[3]?></td>
						<td><a href='userDeleteOrEdit.php?contactDel=<?php echo $row[0]?>'>Delete</a></td>
						<td><a>Reply</a></td>
					</tr>
					<?php
				}
		}

	}


?>