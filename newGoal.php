<?php

session_start();

require_once "DBConnction.php";
require_once "phpFunctions.php";

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
    <?PHP showNavBar() ; 
    if(!isset($_POST['btnEdit']) && !isset($_POST['btnDelete'])) 
    {?>

    <form class="col-md-11 " style="margin-left:  6% ;margin-top:3% ; padding:1% "  action="newGoalHandle.php" method="post">
        <p>tytuł</p><input type="text" name="title">
        <ul style="margin: 0; border: solid black 1px;" >
            <li> 
                <p> S - Specific (prosty, przejrzysty)</p>
                <textarea rows="7" placeholder="treść" cols="60" class="form-control" name="Scontent" style="resize: none"></textarea><br>
                <div></div>
            </li>
            <li> 
                <p>M - Measurable (mierzalny)</p>
                <div>
                    <div style="display: flex;">
                        <input type="checkbox"  name="Warmup"> 
                        <p>Rozgrzewka: </p> <input type="text" name="WarmupText" >
                    </div>
                    <div style="display: flex;">
                        <input type="checkbox"  name="MOnHorizon"> 
                        <p>Meta na horyzoncie: </p> <input type="text" name="MOnHorizonText">
                    </div>
                    <div style="display: flex;">
                        <input type="checkbox" name="FinishLine"> 
                        <p>Meta: </p> <input type="text" name="FinishLineText">
                    </div>
                </div>
            </li>
            <li> 
                <p>A - Achievable (możliwy do osiągnięcia)</p>
                <textarea rows="7" placeholder="treść" cols="60" class="form-control" name="Acontent" style="resize: none"></textarea><br>
            </li>
            <li> 
                <p>R - Relevant  (istotny) </p>
                <textarea rows="7" placeholder="treść" cols="60" class="form-control" name="Rcontent" style="resize: none"></textarea><br>
            </li>
            <li> 
                <p>T - Time bound (ograniczony w czasie) </p>
                <div>
                    <p>-Kiedy musze to zrobić: </p> <input type="text" name="Tmust">
                    <p>-Kiedy chcem to zrobić: </p> <input type="text" name="Twant">
                </div>
            </li>
          </ul>

      <button type="submit" name="new" class="btn btn-success">zapisz</button>
      </form>

            <?PHP 
    }
    if(isset($_POST['btnDelete']))
        {
      ?>
        <div class="panel panel-default" style="padding: 10px; margin-top: 30px; padding-top: 25px">
          <p>czy na pewno chcesz usunąć post o id = <?PHP echo $_POST['id'] ?></p>
          <form style="display: flex ; justify-content: center;" method="POST" action="newGoalHandle.php">
            <input type="submit" name="delete" value="TAK">
            <input type="submit" name="nope" value="NIE">
            <input type="text" name="id" value="<?PHP echo $_POST['id'] ;?>" style="visibility: hidden;">
          </form>
        </div>
      <?PHP
        }
    if(isset($_POST['btnEdit']))
        {

             $connection = new mysqli($host, $user, $pass, $DBName);

              if($connection->connect_errno!=0)
                  {
                    throw new Exception(mysqli_connect_errno());
                  }
                  else
                  {
                    $id = $_POST['id'];
                    $query = mysqli_query($connection,"SELECT * FROM goals LEFT JOIN goalscontent ON goals.id=goalscontent.goalid WHERE id = $id");

                    $row = mysqli_fetch_assoc($query) ;
                  }   

        ?>
            <form class="col-md-11 " style="margin-left:  6% ;margin-top:3% ; padding:1% "  action="newGoalHandle.php" method="post">
                <p>tytuł</p><input type="text" value="<?PHP echo $row['title'] ?>" name="title">
                <ul style="margin: 0; border: solid black 1px;" >
                    <li> 
                        <p> S - Specific (prosty, przejrzysty)</p>
                        <textarea rows="7" placeholder="treść" cols="60" class="form-control" name="Scontent" style="resize: none" ><?PHP echo $row['SContent'] ?></textarea><br>
                        <div></div>
                    </li>
                    <li> 
                        <p>M - Measurable (mierzalny)</p>
                        <div>
                            <div style="display: flex;">
                                <input type="checkbox" <?PHP if($row['MWarmUp-e'] == 1) echo 'checked'; ?>  name="Warmup"> 
                                <p>Rozgrzewka: </p> <input type="text" value="<?PHP echo $row['MWarmUp'] ?>" name="WarmupText" >
                            </div>
                            <div style="display: flex;">
                                <input type="checkbox" <?PHP if($row['MOnHorizon-e'] == 1) echo 'checked'; ?>  name="MOnHorizon"> 
                                <p>Meta na horyzoncie: </p> <input type="text" value="<?PHP echo $row['MOnHorizon'] ?>" name="MOnHorizonText">
                            </div>
                            <div style="display: flex;">
                                <input type="checkbox" <?PHP if($row['MFinishLine-e'] == 1) echo 'checked'; ?> name="FinishLine"> 
                                <p>Meta: </p> <input type="text" value="<?PHP echo $row['MFinishLine'] ?>" name="FinishLineText">
                            </div>
                        </div>
                    </li>
                    <li> 
                        <p>A - Achievable (możliwy do osiągnięcia)</p>
                        <textarea rows="7" placeholder="treść" cols="60" class="form-control" name="Acontent"  style="resize: none"><?PHP echo $row['AContent'] ?></textarea><br>
                    </li>
                    <li> 
                        <p>R - Relevant  (istotny) </p>
                        <textarea rows="7" placeholder="treść" cols="60" class="form-control" name="Rcontent"  style="resize: none"><?PHP echo $row['RContent'] ?></textarea><br>
                    </li>
                    <li> 
                        <p>T - Time bound (ograniczony w czasie) </p>
                        <div>
                            <p>-Kiedy musze to zrobić: </p> <input type="text" value="<?PHP echo $row['TMustContent'] ?>" name="Tmust">
                            <p>-Kiedy chcem to zrobić: </p> <input type="text" value="<?PHP echo $row['TWantContent'] ?>" name="Twant">
                        </div>
                    </li>
                  </ul>

                  <button type="submit" name="edit" class="btn btn-success">zapisz</button>
              </form>
        <?PHP } ?>
    </body>
    </html>