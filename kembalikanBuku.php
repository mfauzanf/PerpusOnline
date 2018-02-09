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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['book_id'] > 0) {
         $bookID = $_POST['book_id'];
         $userID =  $_SESSION['user_id'];
  	     $command1 = "DELETE FROM loan WHERE book_id =$bookID AND user_id=$userID";
         $command2 = "UPDATE book SET quantity = quantity+1 WHERE book_id =".$_POST['book_id'];
  	     $conn = connectDB();
        if(!$result1 = mysqli_query($conn, $command1)) {
          die("Error: $command1");
        }
        if(!$result2 = mysqli_query($conn, $command2)) {
          die("Error: $command2");
        }
        echo "<script>alert('Berhasil Mengembalikan Buku');</script>";

        mysqli_close($conn);
        header("Location:listBuku.php");
    }

    else{
      echo "<script>alert('buku tidak tersedia, gagal meminjam');</script>";
    }

}













 ?>
