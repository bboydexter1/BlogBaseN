<?php

session_start();

require_once "phpFunctions.php";
require_once "DBConnction.php";

siteHead();

if(isset($_POST['btnEdit']))
{
    showNavBar() ;

  $connection = new mysqli($host, $user, $pass, $DBName);

    if($connection->connect_errno!=0)
        {
          throw new Exception(mysqli_connect_errno());
        }
        else
        {
            $id = $_POST['id'];
            $doQuery = mysqli_query($connection,"SELECT tytul, tresc , obrazek FROM posts WHERE id = $id ");

            $row=mysqli_fetch_assoc($doQuery);

            $connection->close(); 
        }

  ?>

  <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-7 ">
          <form  action="newPostHandle.php" method="post" enctype="multipart/form-data">
          <input type="text" name="id" value="<?PHP echo $_POST['id'] ;?>" style="visibility: hidden;">
            <div class="row">
              <div class="col-md-3">
                <input type="file" class="form-control" style="height: 100px;" name="img" value="<?PHP echo $row['obrazek'] ?>">
              </div>
              <div class="col-md-6">
                <input type="text" style=" vertical-align: middle; margin-top: 7%;" placeholder="tytuł" class="form-control" name="title" value="<?PHP echo $row['tytul'] ?>">
              </div>
            </div>
            <textarea rows="25" cols="120" class="form-control" name="content" style="resize: none" ><?PHP echo $row['tresc'] ?></textarea><br>
            <input type="submit" class="btn btn-success pull-right" name="edit" value='edytuj'>
            </form>
          </div>
      </div>
  <?PHP

}
  elseif (isset($_POST['btnDelete']))
{
    showNavBar() ;
  ?>
      <div class="panel panel-default" style="padding: 10px; margin-top: 30px; padding-top: 25px">
          <p>czy na pewno chcesz usunąć post o id = <?PHP echo $_POST['id'] ?></p>
          <form style="display: flex ; justify-content: center;" method="POST" action="newPostHandle.php">
            <input type="submit" name="yes" value="TAK">
            <input type="submit" name="nope" value="NIE">
            <input type="text" name="id" value="<?PHP echo $_POST['id'] ;?>" style="visibility: hidden;">
          </form>
      </div>
  <?PHP
}else
{
  loadLastPage();
}

?>