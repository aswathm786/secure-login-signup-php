<?
require_once __DIR__ . '/config/config.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>NINJA</title>
  <link rel="stylesheet" href="index.css">
  <!-- <link rel="icon" type="image/png" sizes="32x32" href="ninjafavicon.png"> -->
  <link rel="icon" type="image/png" sizes="64x64" href="ninjafavicon.png">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

  <?
  //Checking token exists in cookie, if not logout the user
  if (isset($_SESSION['remember']) && isset($_COOKIE['PHPSESSID']) && !isset($_COOKIE['Token'])) {
    Session::logout();
  }
  //Login user if Token exists, validate the token whether it is belon to that user
  if (isset($_SESSION['Token']) or isset($_COOKIE['Token'])) {
    if (isset($_SESSION['Token'])) {
      $token = $_SESSION['Token'];
    } else if (isset($_COOKIE['Token'])) {
      $token = $_COOKIE['Token'];
    }
    //Authorize the user
    $login = Usersession::authorize($token);
  } else {
    $login = false;
  }

  if ($login) {
    //If authorization success login the user
    Session::set('login', 1);
    $username = Usersession::retrieveusername($token);
    $name = Usersession::retrievename($username);
    $greeting = $_SESSION['Greeting'];
    Session::unset('Greeting');
  ?>
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand" href="/">NINJA</a>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $name ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#"><?php echo $username ?></a>
              <a class="dropdown-item" href="change-password/">Change Password</a>
              <a class="dropdown-item" href="process/logout.php">Logout</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <div class="center-box">
      <div class="greeting-box">
        <h2><?php echo "$greeting...$name"; ?></h2>
      </div>
    </div>
  <?php } else {
    Session::unset('login');
    //Authorization unsuccess ask user for login or signup
  ?>
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand" href="/">NINJA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="app/signup.php">Sign Up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="app/login.php">Login</a>
          </li>
        </ul>
      </div>
    </nav>
  <?php } ?>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>