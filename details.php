<?php
session_start();
$hasilDetail = null;
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
function selectBooksByUserId($userId) {
  $conn = connectDB();
  $sql = "SELECT book_id FROM loan WHERE user_id = $userId";

  if(!$result = mysqli_query($conn, $sql)) {
    die("Error: $sql");
  }
  mysqli_query($conn, $sql);
  mysqli_close($conn);
  return $result;
}
function getBookDesc($bookId){
  $conn = connectDB();

  $sql = "SELECT description FROM book WHERE book_id = $bookId";

  if(!$result = mysqli_query($conn, $sql)) {
    die("Error: $sql");
  }
  mysqli_close($conn);
  return $result;
}
function selectAllFromTableBook($table) {
  $conn = connectDB();

  $sql = "SELECT img_path, title, author,publisher,quantity FROM $table";

  if(!$result = mysqli_query($conn, $sql)) {
    die("Error: $sql");
  }
  mysqli_close($conn);
  return $result;
}

function getBookDetailById($id) {
 $conn = connectDB();

 $sql = "SELECT * FROM book WHERE book_id = $id";

 if(!$result = mysqli_query($conn, $sql)) {
  die("Error: $sql");
}

mysqli_close($conn);
return $result;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <title>PerpusOnline.com | Baca Buku ? Disini aja !</title>
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="libs/bootstrap-material-design/dist/css/bootstrap-material-design.css">
  <link rel="stylesheet" type="text/css" href="libs/bootstrap-material-design/dist/css/ripples.css">
  <link rel="stylesheet" type="text/css" href="src/css/style.css">
  <script type="text/javascript" src="libs/bootstrap-material-design/dist/js/material.js"></script>
  <script type="text/javascript" src="libs/bootstrap-material-design/dist/js/ripples.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $.material.init();
      $.material.input();

      $("#show").click(function() {
       $("#tabel").fadeIn();
     })

      $("#hide").click(function() {
       $("#tabel").fadeOut();
     })

      $("#drop").click(function() {
        $("#login-dp").fadeToggle();
      })
    });
  </script>
  <script type="text/javascript" src="src/js/details.js"></script>
</head>

<body data-spy="scroll" data-target="#myScrollspy" data-offset="20">
 <nav class="navbar navbar-fixed-top col-md-12">
   <div class="container-fluid">
     <div class="navbar-header">
       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </button>
       <a class="navbar-brand" href="javascript:void(0)">PerpusOnline.com</a>
     </div>
     <div class="navbar-collapse collapse navbar-responsive-collapse" id="myScrollspy">
       <form class="navbar-form navbar-left">
         <div class="form-group">
           <input type="text" class="form-control col-md-8" placeholder="Search">
         </div>
       </form>
       <ul class="nav navbar-nav navbar-right">
         <li><a href="index.php">Beranda</a></li>
         <li><a href="#tabel">Daftar Buku</a></li>
         <?php
         if (isset($_SESSION['role'])) {
          $nama = $_SESSION['user'];
          echo "<script type='text/javascript'>
          function logout() {
            $.get('logout.php');
            window.location.reload()
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



<div class="container-fluid">
  <div class="row">
    <div class="col-md-5 col-md-offset-1">
      <?php echo "<img src = '".$_POST['book_img']."'>"; ?>
    </div>
    <div class="col-md-5">
      <h1><?php echo "".$_POST['book_title']; ?></h1>
      <h4>by <?php echo "".$_POST['book_author']; ?></h4>
      <p><?php
        $bookDesc = mysqli_fetch_row(getBookDesc($_POST['book_id']));
        echo "".$bookDesc[0];
        ?></p>
        <p>Published by <?php echo "".$_POST['book_publisher']; ?></p>
        <h3>Jumlah Tersedia : <?php echo "".$_POST['book_value']; ?></h3>
        <?php if (isset($_SESSION['role'])) {
         if ($_SESSION['role']==="user") {
          $borrowedBooks = selectBooksByUserId($_SESSION['user_id']);
        $rows = [];
        while($row = mysqli_fetch_array($borrowedBooks))
        {
          $rows[] = $row[0];
        }
        if (in_array($_POST['book_id'], $rows)) {
          # taro tombol balikin
          echo "
          <!-- Trigger the modal with a button -->
          <button type='button' class='btn btn-raised btn-primary' data-toggle='modal' data-target='#book".$_POST["book_id"]."'>kembalikan</button>

          <!-- Modal -->
          <div class='modal fade' id='book".$_POST["book_id"]."' role='dialog'>
           <div class='modal-dialog'>

             <!-- Modal content-->
             <div class='modal-content'>
               <div class='modal-header'>
                 <button type='button' class='close' data-dismiss='modal'>&times;</button>
                 <h2 class='modal-title'>Apakah kamu yakin ingin mengembalikan buku ini?</h2>
               </div>
               <div class='modal-body'>
                 <a href='".$_POST["book_img"]."' data-toggle='tooltip' title='Click to See Book Image' ><img data-toggle='modal'
                   data-target='#myModal' src='".$_POST["book_img"]."'
                   alt='gambar buku' height='300' width='200' class= 'center-block'/></a>
                   <h4 class='text-center'>".$_POST["book_title"]."</h4>
                 </div>
                 <div class='modal-footer'>
                   <form action='kembalikanBuku.php' method='post' class= 'form-inline'>
                    <input type='hidden' id='delete-userid' name='book_id' value='".$_POST["book_id"]."'>
                    <input type='hidden' id='delete-command' name='book_value' value='".$_POST["book_value"]."'>
                    <button name='kembalikan' type='submit' class='btn btn-raised btn-primary'>kembalikan</button>
                    <button type='kembalikan' class='btn btn-default' data-dismiss='modal'>Batal</button>
                  </form>
                </div>
              </div>

            </div>
          </div>";


        }else{
           echo "
           <!-- Trigger the modal with a button -->
           <button type='button' class='btn btn-raised btn-primary' data-toggle='modal' data-target='#book".$_POST['book_id']."'>Pinjam</button>

           <!-- Modal -->
           <div class='modal fade' id='book".$_POST['book_id']."' role='dialog'>
            <div class='modal-dialog'>

              <!-- Modal content-->
              <div class='modal-content'>
                <div class='modal-header'>
                  <button type='button' class='close' data-dismiss='modal'>&times;</button>
                  <h2 class='modal-title'>Apakah kamu yakin ingin meminjam buku ini?</h2>
                </div>
                <div class='modal-body'>
                  <a href='".$_POST['book_img']."' data-toggle='tooltip' title='Click to See Book Image' ><img data-toggle='modal'
                    data-target='#myModal' src='".$_POST['book_img']."'
                    alt='gambar buku' height='300' width='200' class= 'center-block'/></a>
                    <h4 class='text-center'>".$_POST['book_title']."</h4>
                  </div>
                  <div class='modal-footer'>
                    <form action='listBuku.php' method='post' class= 'form-inline'>
                      <input type='hidden' id='delete-command' name='book_value' value=".$_POST['book_value'].">
                      <input type='hidden' id='delete-userid' name='book_id' value='".$_POST['book_id']."'>
                      <button name='pinjam' type='submit' class='btn btn-raised btn-primary'>PINJAM</button>
                      <button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>
                    </form>
                  </div>
                </div>

              </div>
            </div>";
          }
          }
        } ?>
      </div>
      <div class="col-md-1"></div>
    </div>
    <div>
    </div>
    <?php
    if (isset($_SESSION['user'])) {
      if ($_SESSION['role']= "user") {

          echo '<div class="row">
          <div class="col-md-6 col-md-offset-3">
            <form class="form-horizontal" action="details.php">
              <div class="form-group">
                <h4>Give This Book a Review:</h4>
                <textarea class="form-control well bs-component" rows="5" id="review"></textarea>
                <input id="book_id" type="hidden" name="book_id" value='.$_POST["book_id"].'>
                <button id="reviewButton" name="pinjam" type="button" class="btn btn-raised btn-primary btn-block">Submit Review</button>
              </div>
            </form>
          </div>
          <div class="col-md-3"></div>';

      }
    }
    ?>
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <table id="allReview">
          <caption><h3>Review From User</h3></caption>
          <?php
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
            echo "<tr><td><h4><b>".$username."</b> ".$date."</h4>".$reviews."</td></tr>";
          }
          ?>
        </table>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
</div>

<div class="footer">
  <hr>
  <footer>
    <p class="text-center"> &copy; 2016 PerpusOnline Inc.</p>
  </footer>
</div>
</body>
</html>
