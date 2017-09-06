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


$output ='';

//collect
if (isset($_POST['search'])){
    $searchq = $_POST['search'];
    $searchq = preg_replace("#[^0-9a-z]#i","",$searchq);

    echo "<h2>Posts related to your search</h2>";
    $query_Search = "SELECT * FROM BlogPosts B WHERE B.postTitle LIKE '%$searchq%' OR B.postDesc LIKE '%$searchq%' OR B.postCont LIKE '%$searchq%'";
    $query = mysqli_query($dbConnected,$query_Search) or die("could not search");
    $count = mysqli_num_rows($query);
    if($count == 0){
        $output = 'There was no search results with any posts like these!';
    }else{
        while($row = mysqli_fetch_array($query)){
            $title = $row['postTitle'];
            $desc = $row['postDesc'];
            $id = $row['postID'];

            $output .= '<div>'.$title.'</br>'.$desc.'</div>';
        }
    }

    print("$output");

    $output = '';
    echo "</br></br>";
    echo "<h2>Users related to your search</h2>";
    $query_SearchUser = "SELECT * FROM BlogUsers U WHERE U.Name LIKE '%$searchq%'";

    $query = mysqli_query($dbConnected,$query_SearchUser) or die("could not search");
    $count = mysqli_num_rows($query);
    if($count == 0){
        $output = 'There was no search results about any users like maxdb_thread_safe(oid)!';
    }else{
        while($row = mysqli_fetch_array($query)){
            $title = $row['Name'];
    
            $output .= '<div>'.$title.'</br></div>';
        }
    }

    print("$output");

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
</head>
<body>
    <form method="post" action="search.php">
        <input type="text" name="search" placeholder="Search for post">
        <input type="submit" value="Submit">
    </form>
</body>
</html>



