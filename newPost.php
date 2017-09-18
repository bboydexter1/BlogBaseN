<?php

session_start();

require_once "phpFunctions.php";

if (!isset($_SESSION['player']))
{
  if(isset($_SESSION['lastPage']))
    header('Location: '.$_SESSION['lastPage']);
  else
    header('Location: index.php');
}


function loging() 
{
    if(isset($_SESSION['player']))
    {
        ?>
            <div class="navbar-form navbar-right">
            <?PHP if($_SESSION['isRed']==1) { ?>
            <button type="button" onclick="location.href='nowyPost.php';" class="btn btn-success">write post</button>
            <?PHP } ?>
            <button type="button" onclick="location.href='logout.php';" class="btn btn-success">log out</button>
            </div>
    <?PHP 
    }
}

saveURL();
?>
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Blog początku</title>

    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="dropzone.js"></script>


  </head>
  <body>
    <?PHP showNavBar() ; ?>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-7 ">
        <form  action="newPostHandle.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-3">
              <input type="file" class="form-control" style="height: 100px;" name="img">
            </div>
            <div class="col-md-6">
              <input type="text" style=" vertical-align: middle; margin-top: 7%;" placeholder="tytuł" class="form-control" name="title">
            </div>
          </div>
          <textarea rows="25" placeholder="treść" cols="120" class="form-control" name="content" style="resize: none"></textarea><br>
          <input type="submit" name='new' class="btn btn-success pull-right" value='wyślij'>
          </form>
        </div>
        <div class="col-md-2">
          <?PHP 
              if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']==true)
                echo 'zalogowy';
              else
                echo 'niezalogowany';
           ?>
        </div>
    </div>
    </html>