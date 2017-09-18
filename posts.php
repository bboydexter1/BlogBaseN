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

  function showPost()
  {

  $postTitle = $_GET['post'];
  $postTitle = explode("%20",$postTitle) ;

  $connection = new mysqli($host, $user, $pass, $DBName);

  if($connection->connect_errno!=0)
      {
        throw new Exception(mysqli_connect_errno());
      }
      else
      {
         $userQuery = mysqli_query($connection,"SELECT * FROM posts WHERE tytul = '$postTitle[0]' ");

            $row=mysqli_fetch_assoc($userQuery);

             $_SESSION['postID'] = $row['id'];

            ?>
              <div class="panel panel-default ">
                <div class="panel-body" style="display: flex; height: 50px ; width: 1000px; justify-content: left;">
                <?PHP if ( $row['obrazek'] != "images/.") 
                {;?>
                  <img class="img" onclick="imagePop(this)" src=<?PHP  echo '"'.$row['obrazek'].'"' ;?> style="max-height:  100px;min-height:  100px;min-width:  100px;max-width:  100px;"  alt="no image sorry">
          <?PHP };?>
                  <h3 style="margin-left: 25px"><?PHP echo $row['tytul'] ;?></h3>
                </div>
                <div class="panel-body blank_start" style="margin-top: 7%">
                  <?PHP echo $row['tresc'] ;?>
                </div>
                <div class="panel-body blank_start" style='text-align:  right;'>
                  <?PHP 
                  $temp = explode("-",$row['data']) ;
                  print_r($temp[2]."-".$temp[1]."-".$temp[0]);
                  ?>
                </div>
              </div>
             <?PHP
        }
      $connection->close();
  }

      function SetCommentInput()
      {
        
        if (isset($_SESSION['player']) && $_SESSION['player'] != '')
        {
          ?>
              <div class="panel panel-default">
                 <h3 style="padding-left: 3%;"><?PHP echo $_SESSION['player'] ; ?></h3>
                 <form style="display: flex; margin-bottom: 2%" action="commentHandle.php" method="post">
                  <input style="margin-left:  2%; width: 87% ; " type="text" placeholder="Napisz swój komentarz" class="form-control" name="text">
                  <button style="" type="submit" class="btn btn-success">opublikuj</button>
                </form>
              </div>
          <?PHP
        }
        }

      function ShowComments()
      {
        $connection = new mysqli("localhost", "root", "", "blog");

          if($connection->connect_errno!=0)
              {
                throw new Exception(mysqli_connect_errno());
              }
              else
              { 
                $pID = $_SESSION['postID'];

                $userQuery = mysqli_query($connection,"SELECT * FROM comments LEFT JOIN users ON comments.id_user = users.id WHERE id_post = $pID ORDER BY date DESC ");  

                for($i = 0; $i <= 10; $i++)
                  {
                    $row=mysqli_fetch_assoc($userQuery);

                    if($row['id_post'] == "")
                      break;
                    else
                    {
                      ?>
                          <div class="panel panel-default">
                              <h3 style="padding-left: 3%;"><?PHP echo $row['nazwa'] ; ?></h3>
                              <p style="padding-left: 2% ; padding-top: 2%; margin-bottom: 2% "><?PHP echo $row['tresc'] ; ?></p>
                          </div>
                      <?PHP
                    } 
                  }
              }
                    $connection->close();
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
    <script type="text/javascript" src="baseFunctions.js"></script>

  </head>
  <body  onload="imagePop(this)">
     <?PHP showNavBar() ; ?>

    <div class="blank_start"></div>

    <div class="row"> 
    <div class="col-md-2"></div>
    <div class="col-md-8 ">
      <div class="panel panel-default" style="padding: 10px; margin-top: 30px; padding-top: 25px">
          <?PHP showPost() ?>
      </div>
      
        <?PHP SetCommentInput() ?>

        <?PHP ShowComments() ?>
  
    </div>
    </div>
    <div class="col-md-1"></div>
    </div>
        <div class="pop" onclick="imagePop(this)"  id="pop"></div> 
    <img src="" onclick="imagePop(this)" class="popImg" id="popImg">

  </body>
</html>