<?php
//Includes
include_once('includes/db_connect.php');

//Start Session
session_start();
// If not logged in, return to login
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: index.php");
  exit;
}
?>

<html>

    <head>
        <title><?php echo TITLE; ?></title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <link rel="stylesheet" type="text/css" href="./theme/css/style.css">
        
            <link rel="icon" 
      type="image/x-icon" 
      href="./images/favicon.ico">
            
    </head>
    <body>

        
        <nav class="navbar navbar-inverse navbar-fixed-top" >
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> 
              </button>
            </div>
                  <div class="navbar-header">
      <a class="navbar-brand" href="#"><?php echo TITLE; ?></a>
    </div>
            <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav">
                  
                    <?php 
                    if($_SESSION["role_id"] == 2){
                    echo '<li><a href="./admin">Admin</a></li>';
                    }   
                    ?>
                  <li><a class="active" href="./games.php">Games</a></li>
                  <li><a href="claimedkeys.php">My Keys</a></li>
                  <li><a href="./addgame.php">Add Game</a></li>
                  <li><a href="./addkey.php">Add Key</a></li>
        </div>
      </div>
    </form>
              </ul>
            </div>
          </div>
        </nav>
        
        
        <div class="container-fluid" style="margin-top:50px">
        <div class="jumbotron well">
            <img src="./images/LogoWeb.png" alt="360NoHope" width="137" height="110">
        </div>
            
        
        
        <div class="col-md-2 text-left sidenav"> 
            <div class="well">
                        <h3>User</h3>
                        <b id="welcome">Welcome : <i><?php echo $_SESSION["username"] ?></i></b>
                        <li><a href="claimedkeys.php">Claimed Keys</a></li>
                        <li><a href="sharedkeys.php">Shared Keys</a></li>
                        <li><a href="changepassword.php">Change Password</a></li>
                        
                        <?php 
                            if($_SESSION["role_id"] == 2){
                            echo '<li><a href="./admin">Admin</a></li>';
                            }   
                        ?>
                        
                        <li><a href="logout.php">Log Out</a></li>
            </div>
        </div>
        
        <div class="col-md-10 text-left"> 
            <div class="well">
            <!-- Main Body -->
