<?php 
session_start();
function connectDatabase()
{
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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $command = "SELECT * FROM user WHERE username = '$username' and password = '$password'";
  $role = mysqli_query(connectDatabase(),$command);
  $row = mysqli_fetch_assoc($role);
  echo $row['role'];
  if ($row['role'] === "admin") {
    $_SESSION['user'] = $username;
    $_SESSION['role'] = $row['role'];
    $_SESSION['user_id'] = $row['user_id'];
    header("location: index.php");
  } 
  else if($row['role'] === "user"){
    $_SESSION['user'] = $username;
    $_SESSION['role'] = $row['role'];
    $_SESSION['user_id'] = $row['user_id'];
    header("location: index.php");
  }
  else {
    echo "Yang bener dong inputnya";
  }
}
?>