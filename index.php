<?php
session_start();
if (isset($_COOKIE['login'])) {
  if ($_COOKIE['login'] == 'true') {
    $_SESSION['username'] = $_COOKIE['username'];
    if ($_COOKIE['level'] == 'admin') {
      $_SESSION['status'] = 'login';
      $_SESSION['login'] = 'admin';
      header("location:menu-utama.php");
    } elseif ($_COOKIE['level'] == 'user') {
      $_SESSION['status'] = 'login';
      $_SESSION['login'] = 'user';
      header("location:menu-utama.php");
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Masuya Bandung</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <br>
    <div class="container">

        <div class="panel panel-primary">
            <div align="center" class="panel-heading">Login Masuya Bandung</div>
            <div class="panel-body">
                <div id="header">
                    <br>
                    <img src="asset/masuya.png" alt="" class="img-">
                </div>
            </div>
        </div>

        <div class="card-body">


            <form action="login.php" class="inner-login" method="post">
                <div class="form-group">
                    <label for="username">User Name</label>
                    <input type="username" maxlength="10" name="username" class="form-control" id="username"
                        placeholder="username" required="required" style="text-transform:uppercase"
                        autofocus="autofocus">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" maxlength="10" name="password" class="form-control" id="password"
                        placeholder="Password" required="required">
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
                <div class="text-center forget">
                    <marquee style="font-size:10px;" behavior="alternate" onmouseover="this.stop()"
                        onmouseout="this.start()">Copyright @2022 EDP Bandung</marquee>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="controller/jQuery.min.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</body>

</html>