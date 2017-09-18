<?php
  session_start();

  require_once "phpFunctions.php";

  function loging() 
{
  if(!isset($_SESSION['player']))
  {
     ?>
    <form class="navbar-form navbar-right" action="logowanie.php" method="post">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control" name="mail">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
            <button type="button" onclick="location.href='rejestracja.php';" class="btn btn-success">Sign up</button>
    </form>
    <?PHP 
  }
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
    <script src='https://www.google.com/recaptcha/api.js'></script>

  </head>
  <body>
     <?PHP showNavBar() ; ?>

    <div class="blank_start"></div>

    <div class="row"> 
    <div class="col-md-2"></div>
    <div class="col-md-8 panel panel-default" style="padding: 10px; margin-top: 20px;">
      <form action="registerHandle.php" method="post">
                <div class="col-md-6">
            <div class="form-group">
              <label for="usr">nazwa użytkownika:</label>
              <input type="text" class="form-control" name="usr">
            </div>
            <div class="form-group">
              <label for="pwd">hasło:</label>
              <input type="password" class="form-control" name="pwd">
            </div>
            <div class="form-group">
              <label for="pwd">potwierdz hasło:</label>
              <input type="password" class="form-control" name="pwd2">
            </div>
            <div class="g-recaptcha form-group" data-sitekey="6LfUzyETAAAAAHRs6_aFZSyXpFAk9s3BNi0ZNVq-"></div> 
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="mail">e-mail:</label>
              <input type="mail" class="form-control" name="mail">
            </div>
            <div class="form-group">
              <label for="news">zapis na newsletter:</label>
              <input type="checkbox" class="form-control" value="1" name="news">
            </div>
            <button type="submit" class="form-control btn btn-success" style="margin-top: 20px;">Zarejestruj sie</button>
          </div>
      </form>
      <div>
      <div  style="padding: 10px; margin: 20px; ">
        <?php if (isset($_SESSION['RegisterError']))
         {
          echo $_SESSION['RegisterError'] ;
          unset($_SESSION['RegisterError']);
         }
         ?>
      </div>
    <div class="col-md-1"></div>
    </div>

  </body>
</html>