<?PHP

session_start();

require_once "phpFunctions.php";
require_once "DBConnction.php";


if (!isset($_SESSION['postID']))
{
  if(isset($_SESSION['lastPage']))
    header('Location: '.$_SESSION['lastPage']);
  else
    header('Location: index.php');
}

$connection = new mysqli($host, $user, $pass, $DBName);

  if($connection->connect_errno!=0)
      {
        throw new Exception(mysqli_connect_errno());
      }
      else
      {
      	 $pID =  $_SESSION['postID'];
      	 $comText = $_POST['text'];
      	 $uID = $_SESSION['player'];
      	 $curDate = date("Y-m-d");
      	 unset( $_SESSION['postID']) ;

      	 $userQuery = mysqli_query($connection,"SELECT id FROM users WHERE nazwa = '$uID'");

      	 $row=mysqli_fetch_assoc($userQuery);
      	 $uID = $row['id'];

      	 $userQuery = mysqli_query($connection,"INSERT INTO comments (id_post, id_user, tresc, date) VALUES ($pID, $uID, '$comText', '$curDate')");
      }
      $connection->close();

     loadLastPage();

?>