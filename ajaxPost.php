<?php

session_start();

require_once "DBConnction.php";
require_once "phpFunctions.php";

$connection = new mysqli("localhost", "root", "", "blog");

  if($connection->connect_errno!=0)
      {
        throw new Exception(mysqli_connect_errno());
      }
      else
      {
       $tmp = $_SESSION['postShown'];

       $postTextLong = 500;

       $userQuery = mysqli_query($connection,"SELECT id, tytul, obrazek, LEFT(tresc, $postTextLong), data, autor FROM posts ORDER BY data DESC LIMIT $tmp,10");

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

?>