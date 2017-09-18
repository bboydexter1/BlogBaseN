<?php

session_start();

require_once "DBConnction.php";
require_once "phpFunctions.php";


$connection = new mysqli($host, $user, $pass, $DBName);

if($connection->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			if(isset($_POST['new']))
			{
				$curDate = date("Y-m-d");
				$title = $_POST['title'];

				$connection->query("INSERT INTO goals (title, date) VALUES ('$title', '$curDate' )") ;

				$query = mysqli_query($connection,"SELECT id FROM goals WHERE title = '$title' AND  date = '$curDate'");
		      	$row=mysqli_fetch_assoc($query);
		      	$gID = $row['id'];

		      	if (isset($_POST['MOnHorizon']))
		      	{
		      		$MOnHorizon = 1;
		      	}else
		      	$MOnHorizon = 0;
		      	if (isset($_POST['FinishLine']))
		      	{
		      		$FinishLine = 1;
		      	}else
		      	$FinishLine = 0;	
		      	if (isset($_POST['Warmup'])) 
		      	{
		      		$Warmup = 1;
		      	}else
		      	$Warmup = 0;	

		      	$nquery = "INSERT INTO goalscontent (`goalId`, `SContent`, `MWarmUp`, `MOnHorizon`, `MFinishLine`, `MWarmUp-e`, `MOnHorizon-e`, `MFinishLine-e`, `AContent`, `RContent`, `TMustContent`, `TWantContent`) VALUES ($gID, '".$_POST['Scontent']."' , '".$_POST['WarmupText']."'  , '".$_POST['MOnHorizonText']."'  , '".$_POST['FinishLineText']."'  , $Warmup, $MOnHorizon ,  $FinishLine  , '".$_POST['Acontent']."'  , '".$_POST['Rcontent']."'  , '".$_POST['Tmust']."'  , '".$_POST['Twant']."' )" ; 

		      	
				$connection->query($nquery) ;
			}
			if(isset($_POST['delete']))
			{
				$id = $_POST['id'];
				$connection->query("DELETE FROM goals WHERE id = $id");
				$connection->query("DELETE FROM goalscontent WHERE goalId = $id");
			}
			if(isset($_POST['nope']))
			{
				loadLastPage();
			}
			if(isset($_POST['edit']))
			{
				$id = $_POST['id'];
				$title = $_POST['title'];

				$connection->query("UPDATE goals SET title = '$title' WHERE id =$id") ;

		      	if (isset($_POST['MOnHorizon']))
		      	{
		      		$MOnHorizon = 1;
		      	}else
		      	$MOnHorizon = 0;
		      	if (isset($_POST['FinishLine']))
		      	{
		      		$FinishLine = 1;
		      	}else
		      	$FinishLine = 0;	
		      	if (isset($_POST['Warmup'])) 
		      	{
		      		$Warmup = 1;
		      	}else
		      	$Warmup = 0;	

		      	$nquery = "UPDATE goalscontent SET SContent = '".$_POST['Scontent']."' , MWarmUp = '".$_POST['WarmupText']."' , MOnHorizon = '".$_POST['MOnHorizonText']."' , MFinishLine =  '".$_POST['FinishLineText']."' , `MWarmUp-e` =  $Warmup, `MOnHorizon-e` =  $MOnHorizon, `MFinishLine-e` = $FinishLine, AContent = '".$_POST['Acontent']."', RContent = '".$_POST['Rcontent']."'  , TMustContent = '".$_POST['Tmust']."' , TWantContent = '".$_POST['Twant']."' WHERE id =$id "; 

				$connection->query($nquery) ;
			}

			$connection->close() ;
		}

			header('Location: goals.php');

?>