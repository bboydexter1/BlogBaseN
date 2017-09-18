<?PHP

function siteHead()
{
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

          <script type="text/javascript" src="baseFunctions.js"></script>

      </head>
  <?PHP
}

function showNavBar() 
{
	?>

	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Blog początku</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="https://github.com/bboydexter1">projekty (git)</a></li>
            <li><a href="https://www.facebook.com/sebastian.b.dyjeta">facebook</a></li>
            <li><a href="https://keep.google.com/u/0/">zadania</a></li>
            <li><a href="goals.php">cele</a></li>
          </ul>
          <?PHP logginBar() ?>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="blank_start"></div>

    <?php
}

function saveURL()
{
  $_SESSION['lastPage'] = $_SERVER['REQUEST_URI'];
}

function loadLastPage()
{
  if(isset($_SESSION['lastPage']))
    header('Location: '.$_SESSION['lastPage']);
  else
    header('Location: index.php');
}

function logginBar() 
{
	  if(!isset($_SESSION['player']))
  {
     ?>
    <form class="navbar-form navbar-right" action="loging.php" method="post">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control" name="mail">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
            <button type="button" onclick="location.href='register.php';" class="btn btn-success">Sign up</button>
    </form>
    <?PHP 
  }
    if(isset($_SESSION['player']))
    {
        ?>
            <div class="navbar-form navbar-right">
            <?PHP if($_SESSION['isRed']==1) { ?>
            <button type="button" onclick="location.href='newPost.php';" class="btn btn-success">write post</button>
            <button type="button" onclick="location.href='newGoal.php';" class="btn btn-success">write goal</button>
            <?PHP } ?>
            <button type="button" onclick="location.href='logout.php';" class="btn btn-success">log out</button>
            </div>
    <?PHP 
    }
}

?>