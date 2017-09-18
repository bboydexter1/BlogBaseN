<?php

require_once "DBConnction.php";
require_once "phpFunctions.php";

$connection = new mysqli($host, $user, $pass, $DBName);

              if($connection->connect_errno!=0)
                  {
                    throw new Exception(mysqli_connect_errno());
                  }
                  else
                  {
                    $id = $_POST['id'];
                    $boxDestiny = $_POST['boxDestiny'];

                    switch ($_POST['checkboxID']) 
                    {
				    case 1:
				        $query = mysqli_query($connection,"UPDATE  goalscontent SET `MWarmUp-e` = $boxDestiny WHERE goalid = $id");
				        break;
				    case 2:
				        $query = mysqli_query($connection,"UPDATE  goalscontent SET `MOnHorizon-e` = $boxDestiny  WHERE goalid = $id");
				        break;
				    case 3:
				        $query = mysqli_query($connection,"UPDATE  goalscontent SET `MFinishLine-e` = $boxDestiny  WHERE goalid = $id");
				        break;	
				    default:
        				break;
					}

                    $connection->query($query);
                  }

$connection->close() ;

?>