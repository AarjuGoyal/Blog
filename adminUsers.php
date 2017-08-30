<?php

session_start();
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
		$query_retrieveAllUsers = "SELECT User_ID, Name, Email, Role FROM BlogUsers ORDER BY Name";
		//echo $query_retrieveAllUsers;
		if ($result = mysqli_query($dbConnected,$query_retrieveAllUsers))
		{
			while($row = mysqli_fetch_row($result))
			{
				?>
				<br/>
				<tr>
    			<td><?php echo $row[1]?></td>;
    			<td><?php echo $row[2]?></td>;
    			<td>
        		<a href="userDeleteOrEdit.php?edit=<?php echo $row[0];?>">Edit</a> 
        		<?php if($row[3] != 1)
        		{?>
            	<a href="javascript:deluser('<?php echo $row[0];?>','<?php echo $row[1];?>')">Delete</a>
        		<?php
        		} ?>
    			</td>
    			
    			<?php
    		}
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
		<?php
		

	}
echo "<button><a href='logout.php'>Logout</button>";

?>