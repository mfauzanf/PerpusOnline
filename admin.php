<?php
    session_start();
    if (isset($_SESSION['role'])) {
      if ($_SESSION['role']==='user') {
        header('Location: index.php');
      }
    }else{
      header('Location: index.php');
    }
    
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

    function addBook() {
		$conn = connectDB();
		$gambar = $_POST['book_img'];
		$judul = $_POST['book_title'];
		$penulis = $_POST['book_author'];
		$penerbit = $_POST['book_publisher'];
    $desc = $_POST['book_desc'];
    $jum = $_POST['book_value'];
    $sql3 = "UPDATE book SET quantity = quantity+$jum WHERE title ='$judul'";
    $sql2 = "SELECT*FROM book WHERE title='$judul'";
		$sql = "INSERT into book (img_path, title, author, publisher, description,quantity) values('$gambar','$judul','$penulis','$penerbit','$desc','$jum')";
    $result = mysqli_query($conn, $sql2);
    $result2 = null;
    $result3 = null;
    $rows = mysqli_num_rows($result);

    if ($rows==1) {
      if($result2 = mysqli_query($conn, $sql3)) {
        echo "New record created successfully <br/>";
        header("Location: admin.php");
      }
    }

    else {
      if($result3 = mysqli_query($conn, $sql)) {
  			echo "New record created successfully <br/>";

  			header("Location: admin.php");
  		}
      else {
  			die("Error: $sql");
  		}

    }
		mysqli_close($conn);
	}

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  		if($_POST['command'] === 'insert') {
  			addBook();
  		}
      else if($_POST['command'] === 'update') {
			updateUser($_POST['userid']);
			} else if($_POST['command'] === 'delete') {
			deleteUser($_POST['userid']);
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Halaman Admin | PerpusOnline.com</title>
  <!-- Material Design fonts -->
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Bootstrap Material Design -->
  <link rel="stylesheet" type="text/css" href="libs/bootstrap-material-design/dist/css/bootstrap-material-design.css">
  <link rel="stylesheet" type="text/css" href="libs/bootstrap-material-design/dist/css/ripples.min.css">
  <script type="text/javascript" src="libs/bootstrap-material-design/dist/js/material.js"></script>
  <link rel="stylesheet" type="text/css" href="src/css/style.css">
  <script type="text/javascript">
    $(document).ready(function() {
      $.material.init();
      $.material.input();

      $("#show").click(function() {
       $("#tabel").fadeToggle();
     })

      $("#hide").click(function() {
       $("#tabel").fadeOut();
     })

      $("#drop").click(function() {
        $("#login-dp").fadeToggle();
      })
    });
  </script>
  <meta charset="utf-8">
</head>
<body>

<nav class="navbar navbar-fixed-top col-md-12">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">PerpusOnline.com</a>
    </div>
    <div class="navbar-collapse collapse navbar-responsive-collapse" id="myScrollspy">
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control col-md-8" placeholder="Search">
        </div>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php">Beranda</a></li>
        <?php
        if (isset($_SESSION['role'])) {
          if ($_SESSION['role'] === "admin") {
           echo "<li><a href='admin.php'>Tambah Buku</a></li>";
         }elseif ($_SESSION['role'] === "user") {
           // echo "<li><a href='listBuku.php'>Buku Dipinjam</a></li>";
           echo "<li><a href='#tabel'>Buku Dipinjam</a></li>";
         }
       }
       ?>
       <!-- <li><a href="#tabel">Daftar Buku</a></li> -->
       <?php
       if (isset($_SESSION['role'])) {
         $nama = $_SESSION['user'];
         // $userID = getUserID($nama);
         //echo "$nama";
         echo "<script type='text/javascript'>
         function logout() {
           $.get('logout.php');
           window.location.assign('index.php');
           return false;
         }
       </script>
       <li class='dropdown' >
         <a href='#' id='drop' class='dropdown-toggle' data-toggle='dropdown'><b>Welcome $nama</b><span class='caret'></span></a>
         <ul id='login-dp' class='dropdown-menu'>
           <button type='submit' id='logout' onclick='logout();' class='btn btn-primary btn-block'>Sign out</button>
         </ul>
       </li>";
     }
     else {
       echo '
       <li class="dropdown" >
        <a href="#" id="drop" class="dropdown-toggle" data-toggle="dropdown">Login <span class="caret"></span></a>
        <ul id="login-dp" class="dropdown-menu">
          <li>
           <div class="row">
            <div class="col-md-12">
             <form class="form-horizontal" role="form" method="post" action="login.php" accept-charset="UTF-8" id="login-nav">
              <div class="form-group">
               <label class="sr-only" for="inputUser">Username</label>
               <input name="username" type="text" class="form-control input" id="inputUser" placeholder="Username" required>
             </div>
             <div class="form-group">
               <label class="sr-only" for="inputPass">Password</label>
               <input name="password" type="password" class="form-control input" id="inputPass" placeholder="Password" required>
             </div>
             <div class="col-md-10 col-md-offset-2">
               <button type="submit" id="login" class="btn btn-primary btn-block">Sign in</button>
             </div>
           </form>
         </div>
       </div>
     </li>
   </ul>
 </li>
 ';
}
?>

</ul>
</div>
</div>
</nav>
<br>
<br>
<br>
  <div class="jumbotron text-center">
    <h1 id="header">Tambah Buku</h1>
</div>
    <div class="container-fluid">
        <form class="form-horizontal" action="admin.php"   method="post" >
            <div class="form-group">
              <label class="control-label col-sm-2" for="gambar">Gambar Buku:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="i5ps" placeholder="Enter Link or Path" name = "book_img">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="judul">Judul:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="judul" placeholder="Enter Title" name = "book_title">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="penulis">Penulis:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="penulis" placeholder="Enter Author" name = "book_author">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="penerbit">Penerbit:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="penerbit" placeholder="Enter Publisher" name = "book_publisher">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="desc">Description:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="desc" placeholder="Enter Description" name = "book_desc">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="jum">Jumlah:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="jum" placeholder="Enter Quantity" name = "book_value">
              </div>
            </div>
            <input type="hidden" id="insert-command" name="command" value="insert">
								<button type="submit" class="btn btn-primary btn-lg btn-block btn-raised">Submit</button>
        </form>
  </div>
  <div class="footer">
    <hr>
    <footer>
      <p class="text-center"> &copy; 2016 PerpusOnline Inc.</p>
    </footer>
  </div>
</body>
</html>
