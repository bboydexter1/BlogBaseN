<?PHP

session_start();

require_once "phpFunctions.php";

if (!isset($_POST["mail"]))
{
  if(isset($_SESSION['lastPage']))
    header('Location: '.$_SESSION['lastPage']);
  else
    header('Location: index.php');
}

$mail = $_POST["mail"];
$password = md5($_POST["password"]);

require_once "DBConnction.php";

$connection = new mysqli($host, $user, $pass, $DBName);

if($connection->connect_errno!=0)
{
	throw new Exception(mysqli_connect_errno());
}
else
{
	$userQuery = mysqli_query($connection,"SELECT * FROM users WHERE mail = '$mail'")	;//	$connection->query("SELECT * FROM users WHERE mail = $mail") ;
  	$row=mysqli_fetch_assoc($userQuery);
  	//printf ("%s %s\n",$row["mail"],$row["password"]);
  	if ($row["password"] == $password)
  		{
  			$_SESSION['player']=$row["nazwa"];
        if($row["czyRedaktor"] == "1")
        {
        $_SESSION['isRed'] = 1 ;
        }else
        $_SESSION['isRed'] = 0 ;
  		}
	$connection->close();
   loadLastPage();
}


?>
