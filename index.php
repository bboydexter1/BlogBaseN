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
    <script type="text/javascript" src="MobileOnClicks.js"></script>

    <script type="text/javascript">
      $(window).scroll(function() {
         if($(window).scrollTop() + $(window).height() > $(document).height()) 
         {
            if(window.XMLHttpRequest)
            {
                xhr = new XMLHttpRequest();
            }else
            {
                xhr = new ActiveObject('Microsoft.XMLHTTP');
            }
                     
            xhr.onreadystatechange = function()
            {
                if((xhr.readyState==4)&&(xhr.status == 200||xhr.status == 304))
                {
                   var content = xhr.responseText ;
                   var div = document.createElement ("div"); 
                   div.innerHTML = content;
                   document.getElementById("postSpace").append(div) ;

                }   
            
            };     
            
                xhr.open("POST", 'ajaxPost.php', true);

                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                var postShown = <?PHP if (isset($_SESSION['postShown'])) echo $_SESSION['postShown'] ; else echo "0"; ?>
                
                xhr.send("postShown=" + postShown);
         }
      });
    </script>

</head>
<?php

session_start();

require_once "DBConnction.php";
require_once "phpFunctions.php";

saveURL();

function showPosts() 
{
$connection = new mysqli("localhost", "root", "", "blog");

  if($connection->connect_errno!=0)
      {
        throw new Exception(mysqli_connect_errno());
      }
      else
      {
      //  if (!isset($_GET['postShown']) || $_GET['postShown'] < 0)
      /// {
      //      $_GET['postShown'] = 0 ;
      // }
        //$userQuery = mysqli_query($connection,"SELECT * FROM posts ORDER BY data DESC ");// or trigger_error(mysql_error()." "."SELECT * FROM posts");;
        // $userQuery = mysqli_query($connection,"SELECT * FROM posts ORDER BY data ASC");LIMIT 10,$_SESSION['postShown']"

       $tmp = $_SESSION['postShown'];

       $postTextLong = 500;

       $userQuery = mysqli_query($connection,"SELECT id, tytul, obrazek, LEFT(tresc, $postTextLong), data, autor FROM posts ORDER BY data DESC LIMIT $tmp,10");

        //for($i = $_SESSION['postShown']; $i <= $_SESSION['postShown']+10; $i++) 

        for($i = 0; $i <= 10; $i++)
        {
            $row=mysqli_fetch_assoc($userQuery);
            if($row['id'] == "")
            {break;}
            ?>
              <div class="panel panel-default blank_start">
                <div class="panel-body" style="display: flex; height: 50px ;  justify-content: left;">
                <?PHP if ( $row['obrazek'] != "images/.") 
                {;?>
                  <img class="img" onclick="imagePop(this)" src=<?PHP  echo '"'.$row['obrazek'].'"' ;?> style="max-height:  100px;min-height:  100px;min-width:  100px;max-width:   100px;" id="postImg" alt="no image sorry">
          <?PHP };?>
                  <a href="posts.php?post=<?PHP echo $row['tytul'] ;?>"><h3 style="margin-left: 25px;"><?PHP echo $row['tytul'] ;?></h3></a>
                </div>
                <div style="margin-top: 7%;" class="panel-body blank_start">
                  <?PHP echo $row['LEFT(tresc, '.$postTextLong.')'] ;?>
                </div>
                <div style="display: flex ; justify-content: flex-end ;">
                  <?php if(isset($_SESSION['isRed']) && $_SESSION['isRed'] == 1)
                    { ?>
                      <form action="postEdit.php" method="POST">
                        <input type="submit" class="panel-body" name="btnEdit" value="edytuj">
                        <input type="submit" class="panel-body" name="btnDelete" value="usuń">
                        <input type="text" name="id" value="<?PHP echo $row['id'] ;?>" style="visibility: hidden;">
                      </form>
                    <?PHP 
                    }?>
                    <div class="panel-body" style="margin-left: 4%">
                      <?PHP
                      $temp = explode("-",$row['data']) ;
                      print_r($temp[2]."-".$temp[1]."-".$temp[0]);
                      ?>
                    </div>
                </div>
              </div>
             <?PHP 
             $_SESSION['postShown'] += 1 ;
        }
      }
      $connection->close(); 
}

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
?>
  <body onload="loadin()">
    <?PHP 
    showNavBar() ; 
    $_SESSION['postShown'] = 0;
    ?>

    <div class="blank_start"></div>

    <div class="jumbotron" style="margin-bottom: 0px">
      <div class="container">
        <h1>Witam!</h1>
        <p>na moim (hahaha) blogu. gdzie prowadze swoje notatki i trenuje, i sprawdzam jak wygląda pracowanie w technologiach webowych.</p>
        <!--<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>-->
      </div>
    </div>
      
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-8 main" id="postSpace">
            <?PHP showPosts();?>
          <!--<ul class="pager">
            <?PHP if ($_GET['postShown'] != 0 ) {  ?>
            <li class="previous"><a href="index.php?postShown=<?PHP echo $_GET['postShown'] - 10;?>">nowsze</a></li>
            <?PHP }?>
            <li class="next"><a href="index.php?postShown=<?PHP if ($_GET['postShown'] == 0){ echo $_GET['postShown']+10 ;} else  {echo $_GET['postShown'] + 10;} ?>">starsze</a></li>
          </ul>-->
        </div>
        <div class="col-md-3">
          <div class="blank_start" id="jtest"></div>
          <div id="jqtest"></div>

        </div>
    </div>

    <script type="text/javascript">
      
      $(document).click(function() 
        {
            imagePopHid();
        });
      $("#postImg").bind('touchstart click', imagePop(this))  ;
   </script>


    <div class="pop" onclick="imagePop(this)"  id="pop"></div> 
    <img src="" onclick="imagePop(this)" class="popImg" id="popImg">
    <!-- (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   

    </div>
  </body>
</html>