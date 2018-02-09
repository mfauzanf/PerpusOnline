<?php
$userID = null;
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

function selectAllFromTable($table) {
  $conn = connectDB();

  $sql = "SELECT * FROM $table";

  if(!$result = mysqli_query($conn, $sql)) {
    die("Error: $sql");
  }
  mysqli_close($conn);
  return $result;
}

// function kembalikanBuku($userID,$bookID,$quantity) {
//   $conn = connectDB();
//
//   $sql = "DELETE FROM loan WHERE user_id =$userID, book_id=$bookID";
//   $sql2 = "UPDATE book SET quantity=$quantity+1 WHERE book_id=$bookID"
//
//
//   if(!$result = mysqli_query($conn, $sql)) {
//     die("Error: $sql");
//   }
//   if(!$result2 = mysqli_query($conn, $sql2)) {
//     die("Error: $sql");
//   }
//   mysqli_close($conn);
//
// }


function addBookQuantity() {

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

function getBookDetailById($id) {
 $conn = connectDB();

 $sql = "SELECT book_id,img_path,title,author,publisher,quantity FROM book WHERE book_id = $id";

 if(!$result = mysqli_query($conn, $sql)) {
  die("Error: $sql");
}
mysqli_close($conn);
return $result;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['book_value'] > 0) {
      $command1 = "UPDATE book SET quantity = quantity-1 WHERE book_id =".$_POST['book_id'];
      $command2 = "INSERT INTO loan (book_id, user_id) VALUES (".$_POST['book_id'].",".$_SESSION['user_id'].")";
      $conn = connectDB();
      if(!$result1 = mysqli_query($conn, $command1)) {
        die("Error: $command1");
      }
      if(!$result2 = mysqli_query($conn, $command2)) {
        die("Error: $command2");
      }
      echo "<script>alert('Berhasil Meminjam Buku');</script>";
      mysqli_close($conn);
    }else{
      echo "<script>alert('buku tidak tersedia, gagal meminjam');</script>";
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

<div class="container" id="home">


 <?php
 if (isset($_SESSION['role'])) {
   $nama = $_SESSION['user'];
     //echo "$nama";
   echo "  <h1 class='perpus'>Welcome $nama !</h1>
   <p id='descPerpus' class='text-primary'>Klik Tombol Dibawah Untuk Melihat Daftar Bukumu !</p>

   ";
 }
 ?>

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
      $tessst = selectBooksByUserId($_SESSION['user_id']);
      while ($row = mysqli_fetch_row($tessst)) {
        foreach ($row as $keys => $idBuku) {
          $bookDetails = getBookDetailById($idBuku);
          while ($barisData = mysqli_fetch_row($bookDetails)) {
            $book_publisher = null;
            $book_img = null;
            $book_author = null;
            $book_title = null;
            $book_value = null;
            foreach ($barisData as $key => $value) {
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
             <button type='button' class='btn btn-raised btn-primary' data-toggle='modal' data-target='#book".$book_id."'>kembalikan</button>

             <!-- Modal -->
             <div class='modal fade' id='book".$book_id."' role='dialog'>
              <div class='modal-dialog'>

                <!-- Modal content-->
                <div class='modal-content'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    <h2 class='modal-title'>Apakah kamu yakin ingin mengembalikan buku ini?</h2>
                  </div>
                  <div class='modal-body'>
                    <a href='".$book_img."' data-toggle='tooltip' title='Click to See Book Image' ><img data-toggle='modal'
                      data-target='#myModal' src='".$book_img."'
                      alt='gambar buku' height='300' width='200' class= 'center-block'/></a>
                      <h4 class='text-center'>".$book_title."</h4>
                    </div>
                    <div class='modal-footer'>
                      <form action='kembalikanBuku.php' method='post' class= 'form-inline'>
                       <input type='hidden' id='delete-userid' name='book_id' value='".$book_id."'>
                       <input type='hidden' id='delete-command' name='book_value' value='".$book_value."'>
                       <button name='kembalikan' type='submit' class='btn btn-raised btn-primary'>kembalikan</button>
                       <button type='kembalikan' class='btn btn-default' data-dismiss='modal'>Batal</button>
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
         <input type='hidden' id='delete-command' name='book_value' value='".$barisData[5]."'>
         <button type='submit' class='btn btn-raised btn-primary'>DETAILS</button>
       </form>
     </td>
   </tr>";
 }
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
