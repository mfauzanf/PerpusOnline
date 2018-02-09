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

function selectAllFromTableBook($table) {
  $conn = connectDB();

  $sql = "SELECT book_id, img_path, title, author, publisher, quantity FROM $table WHERE quantity>0";

  if(!$result = mysqli_query($conn, $sql)) {
    die("Error: $sql");
  }
  mysqli_close($conn);
  return $result;
}

function getDetailBook($src) {
 $conn = connectDB();

 $sql = "SELECT*FROM book WHERE img_path=$src";

 if(!$result = mysqli_query($conn, $sql)) {
   die("Error: $sql");
 }
 mysqli_close($conn);
 return $result;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if($_POST['command'] === 'bookDetail') {
    getDetailBook($_POST['bookDetail']);
  }
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
         <li><a href="#home">Beranda</a></li>
         <?php
         if (isset($_SESSION['role'])) {
           if ($_SESSION['role'] === "admin") {
            echo "<li><a href='admin.php'>Tambah Buku</a></li>";
          }elseif ($_SESSION['role'] === "user") {
            echo "<li><a href='listBuku.php'>Buku Dipinjam</a></li>";
          }
        }
        ?>
        <li><a href="#tabel">Daftar Buku</a></li>
        <?php
        if (isset($_SESSION['role'])) {
          $nama = $_SESSION['user'];
          //echo "$nama";
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

<div class="container" id="home">
  <h1 class="perpus">PerpusOnline.com</h1>
  <p id="descPerpus" class="text-primary">Baca Buku ? Disini aja !</p>

  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <!-- <li data-target="#myCarousel" data-slide-to="0" class="active"></li> -->
      <li data-target="#myCarousel" data-slide-to="1" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      <div class="item active">
        <img class="img-responsive center-block"  src="src/img/perpus2.jpg" alt="perpus2" width="1000" height="500">
        <div class="carousel-caption">
          <h1  >Koleksi Buku Lengkap </h1>
          <p   >Dari Buku Fiksi Sampai Non Fiksi Ada Disini :D</p>
        </div>
      </div>

      <div class="item">
        <img  class="img-responsive center-block"  src="src/img/perpus3.jpg" alt="perpus3" width="1000" height="500">
        <div class="carousel-caption">
          <h1>Koleksi Yang Up to Date</h1>
          <p>Selalu Update List Buku</p>
        </div>
      </div>

      <div class="item">
        <img class="img-responsive center-block"  src="src/img/perpus4.jpg" alt="perpus4" width="1000" height="500">
        <div class="carousel-caption">
          <h1>Langganan Mulai 50 Ribu</h1>
          <p>Langganan 50 Ribu Tiap Bulan !</p>
        </div>
      </div>

    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <br>
  <button type="button" name="button" id="show" class="btn btn-raised btn-primary">Daftar Buku</button>
</div>

<br>
<br>
<br>

<div class="container-fluid">
 <div class="tableBook" id="tabel">
   <table class="table table-striped table-hover table-bordered">
     <thead>
      <tr class="success">
        <th class="head">Buku</th>
        <th class="head">Judul</th>
        <th class="head">Pengarang</th>
        <th class="head">Penerbit</th>
        <th class="head">Jumlah</th>
        <th class="head">Action</th>
      </tr>
    </thead>
    <tbody  >
      <?php
      $books = selectAllFromTableBook("book");
      $borrowedBooks = selectBooksByUserId($_SESSION['user_id']);
      $rows = [];
      while($row = mysqli_fetch_array($borrowedBooks))
      {
        $rows[] = $row[0];
      }
      while ($row = mysqli_fetch_row($books)) {
        echo "<tr class='info'>";
        $book_publisher = null;
        $book_img = null;
        $book_author = null;
        $book_title = null;
        $book_value = null;

        if (in_array($row[0], $rows)) {
          
        }else{
          foreach($row as $key => $value) {
         if ($key == 2) {
           $book_title = $value;
         }else if ($key == 3) {
           $book_author = $value;
         }else if ($key == 4) {
           $book_publisher = $value;
         }
         else if ($key == 5) {
           $book_value = $value;
         }
         if ($key == 0) {
           $book_id = $value;
         }
         else if ($key === 1) {
           $book_img = $value;
           echo "<td>
           <a href='".$value."' data-toggle='tooltip' title='Click to See Book Image' ><img data-toggle='modal'
            data-target='#myModal' src='".$value."'
            alt='gambar buku' height='150' width='100'/></a>
          </td>";
         //echo "<td><img  src='$value' alt='gambar buku' height='150' width='100'/></td>";
        }
        else {
          echo "<td>$value</td>";
        }
      }
      echo "<td>";
      if (isset($_SESSION['role'])) {
       if ($_SESSION['role']==="user") {
         echo "
         <!-- Trigger the modal with a button -->
         <button type='button' class='btn btn-raised btn-primary' data-toggle='modal' data-target='#book".$book_id."'>Pinjam</button>

         <!-- Modal -->
         <div class='modal fade' id='book".$book_id."' role='dialog'>
          <div class='modal-dialog'>

            <!-- Modal content-->
            <div class='modal-content'>
              <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h2 class='modal-title'>Apakah kamu yakin ingin meminjam buku ini?</h2>
              </div>
              <div class='modal-body'>
                <a href='".$book_img."' data-toggle='tooltip' title='Click to See Book Image' ><img data-toggle='modal'
                  data-target='#myModal' src='".$book_img."'
                  alt='gambar buku' height='300' width='200' class= 'center-block'/></a>
                  <h4 class='text-center'>".$book_title."</h4>
                </div>
                <div class='modal-footer'>
                  <form action='listBuku.php' method='post' class= 'form-inline'>
                   <input type='hidden' id='delete-userid' name='book_id' value='".$book_id."'>
                   <input type='hidden' id='delete-command' name='book_value' value=".$book_value.">
                   <button name='pinjam' type='submit' class='btn btn-raised btn-primary'>PINJAM</button>
                   <button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>
                 </form>
               </div>
             </div>

           </div>
         </div>";
       }
     }

     echo "<form action='details.php' method='post'>
     <input type='hidden' id='delete-userid' name='book_id' value='".$book_id."'>
     <input type='hidden' id='delete-userid' name='book_img' value='".$book_img."'>
     <input type='hidden' id='delete-command' name='book_title' value='".$book_title."'>
     <input type='hidden' id='delete-command' name='book_author' value='".$book_author."'>
     <input type='hidden' id='delete-command' name='book_publisher' value='".$book_publisher."'>
     <input type='hidden' id='delete-command' name='book_value' value='".$book_value."'>
     <button type='submit' class='btn btn-raised btn-primary'>DETAILS</button>
   </form>
 </td>
</tr>";
        }
        
}
?>
</tbody>
</table>
<button type="button" name="button" id="hide" class="btn btn-raised btn-primary">Tutup Daftar</button>
<br>
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
