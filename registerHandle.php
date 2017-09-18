<?php

session_start();

  $key = "6LfUzyETAAAAAM8tMRCjlgrHlr4nzTj1H7ZNPMWZ";
    
    $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$key.'&response='.$_POST['g-recaptcha-response']);
    
    $ans = json_decode($check);
    
    if ($ans->success==false)
    {
    $_SESSION['captcha']=true;
    }else
    {$_SESSION['captcha']=false;}


require_once "DBConnction.php";
require_once "phpFunctions.php";

$connection = new mysqli($host, $user, $pass, $DBName);

$_SESSION['RegisterFailiture']=false;
unset($_SESSION['RegisterError']);

//validacja

function test_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (!preg_match("/^[a-zA-Z ]*$/",test_input($_POST["name"]))) 
{
  $_SESSION['RegisterError'].='<br>'."nazwa musi zawierać tylko litery"; 
  $_SESSION['RegisterFailiture']=true;
}

if (!filter_var(test_input($_POST["mail"]), FILTER_VALIDATE_EMAIL)) 
{
  $_SESSION['RegisterError'].='<br>'."podałeś nieprawidłowy e-mail"; 
  $_SESSION['RegisterFailiture']=true;
}

if ($_POST["pwd"]!=$_POST["pwd2"]) 
{
  $_SESSION['RegisterError'].='<br>'."podane chasła nie są takie same"; 
  $_SESSION['RegisterFailiture']=true;
}

if (strlen($_POST["pwd"]) < 9) 
{
  $_SESSION['RegisterError'].='<br>'."hasło musi mieć więcej niż 8 znaków"; 
  $_SESSION['RegisterFailiture']=true;
}


if($_SESSION['captcha']==true)
{
  $_SESSION['RegisterError'].='<br>'."nie udowodniłeś że nie jesteś botem !!!"; 
  $_SESSION['RegisterFailiture']=true;
}

//koniec validacji

//sprawdzanie czy rekord istnieje

if($connection->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			$mail = $_POST['mail'] ;
			$name = $_POST['usr'] ;

			if($mail != "" && $name != "")
			{
			$userQuery = mysqli_query($connection,"SELECT mail, nazwa FROM users WHERE mail = '$mail' OR nazwa = '$name'");
			$row=mysqli_fetch_assoc($userQuery);

		  	if ($row['mail'] == $mail)
		  		{
		  			$_SESSION['RegisterError'].='<br>'."taki e-mail już istnieje"; 
		  			$_SESSION['RegisterFailiture']=true;
		  		}
		  	if ($row['nazwa'] == $name)
		  		{
		  			$_SESSION['RegisterError'].='<br>'."taki użytkownik już istnieje"; 
		  			$_SESSION['RegisterFailiture']=true;
		  		}
		  	}else
		  	{
		  		$_SESSION['RegisterError'].='<br>'."wypełnij wszystkie pola"; 
		  		$_SESSION['RegisterFailiture']=true;
		  	}
		}

//koniec sprawdzania

if($_SESSION['RegisterFailiture']==false)
{
		if($connection->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			$haslo_hash = md5($_POST['pwd']);
			$mail = $_POST['mail'];
			$name = $_POST['usr'];
			$news = $_POST['news'];

			$connection->query(" INSERT INTO users (mail, password, nazwa, czyRedaktor, czyNewsletter) VALUES ('$mail','$haslo_hash','$name',0,'$news')") ;

			$connection->close();
		}
			loadLastPage();
}else
{

	header('Location: rejestracja.php');
}
?>