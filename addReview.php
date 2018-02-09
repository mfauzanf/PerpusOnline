<?php 
session_start();
function connectDB() {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "tappw";

      // Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);

      // Check connection
	if (!$conn) {
		die("Connection failed: " + mysqli_connect_error());
	}
	return $conn;
}
function getUsernameById($userId)
{
  $conn = connectDB();
  $command = "SELECT username FROM user WHERE user_id = $userId";
  if(!$result = mysqli_query($conn, $command)) {
    die("Error: $command");
  }
  mysqli_close($conn);
  return $result;
}
function getAllReview()
{
  $conn = connectDB();

  $command = "SELECT * FROM review WHERE book_id = ".$_POST['book_id'];

  if(!$result = mysqli_query($conn, $command)) {
    die("Error: $command");
  }
  mysqli_close($conn);
  return $result;
}

if (isset($_POST['addReview'])) {
	$date = mysql_escape_string($_POST['date']);
	$review = mysql_escape_string($_POST['review']);
	$book_id = $_POST['book_id'];
	$user_id = $_SESSION['user_id'];
	$command="INSERT INTO review (book_id,user_id,date,content) VALUES ('$book_id','$user_id','$date','$review')";
	$conn = connectDB();
	if(!$result = mysqli_query($conn, $command)) {
		die("Error: $command");
	}
	mysqli_close($conn);
}
if (isset($_POST['display'])) {
	$allReview = getAllReview();
          while ($row = mysqli_fetch_row($allReview)) {
            $userId = null;
            $date = null;
            $reviews = null;
            $username = null;
            foreach ($row as $key => $value) {
              switch ($key) {
                case 2:
                $userId = $value;
                $temp = mysqli_fetch_row(getUsernameById($userId));
                $username = $temp[0];
                break;
                case 3:
                $date = $value;
                break;
                case 4:
                $reviews = $value;
                break;
              }
            }
            ?>
            <tr><td><h4><b><?php echo "".$username; ?></b><?php echo " ".$date; ?></h4><?php echo "".$reviews; ?></td></tr>
            <?php
          }
}
?>