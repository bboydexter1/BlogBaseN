<?php

session_start();

require_once "DBConnction.php";
require_once "phpFunctions.php";

if(isset($_POST['new']))
{

	$connection = @new mysqli($host, $user, $pass, $DBName);


			if($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				/////////////////////debug prupose 
				///	$_SESSION['player'] = "Archer";
				////////////////////
				$curDate = date("Y-m-d");
				if (isset($_FILES["img"]["name"]) && $_FILES["img"]["name"] != '')
				{
					$imageFileType = pathinfo($_FILES["img"]["name"],PATHINFO_EXTENSION);
					$time = date("h:i:sa");
					$dir = "images/" . $curDate . "_" . $_SESSION['player'] . "_" . $time . "." . $imageFileType ;
					move_uploaded_file($_FILES["img"]['tmp_name'],$dir);
				}else
				{
					$dir = "images/.";
				}

				//$connection->query("INSERT INTO posty (tytul, obrazek, tresc, data, autor) VALUES ($_POST[title],$dir,$_POST[content],$curDate,$_SESSION[player])");
				$connection->query("INSERT INTO posts (tytul, obrazek, tresc, data, autor) VALUES ('$_POST[title]','$dir','$_POST[content]','$curDate','$_SESSION[player]')");

				/*
				$userQuery = mysqli_query($connection,"SELECT * FROM users WHERE czyNewsletter=1");
				$row=mysqli_fetch_assoc($userQuery);
				while($row['id'] != "")
				{
					mail($row['mail'],"Nowy post na Blogu Początku !!!	" + $_POST[title],"na stronie jest dostępny nowy post więc właź i sprawdz !!!");
				}*/

				$connection->close();
			}
				header('Location: index.php');
}

if(isset($_POST['edit']))
{

	$connection = new mysqli($host, $user, $pass, $DBName);


			if($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$id = $_POST['id'];
				if (isset($_FILES["img"]["name"]) && $_FILES["img"]["name"] != '')
				{
					$curDate = date("Y-m-d");
					$time = date("h:i:sa");
					$imageFileType = pathinfo($_FILES["img"]["name"],PATHINFO_EXTENSION);
					$dir = "images/" . "edited_" . $curDate . "_" . $_SESSION['player'] "_" . $time . "." . $imageFileType ;
					move_uploaded_file($_FILES["img"]['tmp_name'],$dir);
					$connection->query("UPDATE posts SET tytul = '$_POST[title]', obrazek = '$dir', tresc ='$_POST[content]' WHERE id = $id");
				}else
				{
					$connection->query("UPDATE posts SET tytul = '$_POST[title]', tresc ='$_POST[content]' WHERE id = $id");
				}

				$connection->close();
			}
				header('Location: index.php');
}

if(isset($_POST['yes']))
{
		$connection = new mysqli($host, $user, $pass, $DBName);


			if($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$id = $_POST['id'];
				$connection->query("DELETE FROM posts WHERE id = $id");

				$connection->close();
			}
				header('Location: index.php');
}

if(isset($_POST['nope']))
{
	loadLastPage();
}

?>