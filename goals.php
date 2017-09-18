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

</head>

</head>
<?PHP 
session_start();

require_once "DBConnction.php";
require_once "phpFunctions.php";

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

    function showGoals()
    {
        $connection = new mysqli("localhost", "root", "", "blog");

          if($connection->connect_errno!=0)
              {
                throw new Exception(mysqli_connect_errno());
              }
              else
              {
                $query = mysqli_query($connection,"SELECT * FROM goals LEFT JOIN goalscontent ON goals.id=goalscontent.goalid ORDER BY date DESC");

                while ($row = mysqli_fetch_assoc($query)) 
                {
                    ?>

                        <div class="col-md-3 " style="margin-left:  6% ;margin-top:1% ;margin-bottom : 1%;">
                            <h3 onclick="dropDowns(this)" id="goal" style="background-color: #4444ff ; padding: 3% ;border : 1px solid; margin: 0"> <?PHP echo $row['title'] ; ?> 
                                <?PHP if(isset($_SESSION['player']))
                                    {?>
                                     <form action="newGoal.php" method="POST">
                                        <input type="submit" name="btnEdit" value="edytuj">
                                        <input type="submit" name="btnDelete" value="usuń">
                                        <input type="text" name="id" value="<?PHP echo $row['id'] ;?>" style="visibility: hidden;">
                                      </form> 
                             <?PHP }?>
                            </h3>
                            <ul class="goalList" >
                            <li> 
                                <h5> S - Specific (prosty, przejrzysty)</h5>
                                <div ><?PHP echo $row['SContent'] ; ?></div>
                            </li>
                            <li> 
                                <h5>M - Measurable (mierzalny)</h5>
                                <div>
                                    <div style="display: flex;">
                                        <input type="checkbox" <?PHP if (!isset($_SESSION['isRed']) || $_SESSION['isRed']==0) echo 'disabled="true"' ?> <?PHP if($row['MWarmUp-e'] == 1) echo 'checked' ; ?> onchange='check(<?PHP echo $row['id'] ; ?> , 1 , this)' name="Warmup"> 
                                        <p>Rozgrzewka: <?PHP echo $row['MWarmUp'] ; ?></p>
                                    </div>
                                    <div style="display: flex;">
                                        <input type="checkbox" <?PHP if (!isset($_SESSION['isRed']) || $_SESSION['isRed']==0) echo 'disabled="true"' ?> <?PHP if($row['MOnHorizon-e'] == 1) echo 'checked' ; ?> onchange='check(<?PHP echo $row['id'] ; ?> , 2 , this)'  name="MOnHorizon"> 
                                        <p>Meta na horyzoncie: <?PHP echo $row['MOnHorizon'] ; ?></p>
                                    </div>
                                    <div style="display: flex;">
                                        <input type="checkbox" <?PHP if (!isset($_SESSION['isRed']) || $_SESSION['isRed']==0) echo 'disabled="true"' ?> <?PHP if($row['MFinishLine-e'] == 1) echo 'checked' ; ?> onchange='check(<?PHP echo $row['id'] ; ?> , 3 , this)' name="FinishLine"> 
                                        <p>Meta:<?PHP echo $row['MFinishLine'] ; ?> </p>
                                    </div>
                                </div>
                            </li>
                            <li> 
                                <h5>A - Achievable (możliwy do osiągnięcia)</h5>
                                <div><p><?PHP echo $row['AContent'] ; ?></div>
                            </li>
                            <li> 
                                <h5>R - Relevant  (istotny) </h5>
                                <div><p><?PHP echo $row['RContent'] ; ?></div>
                            </li>
                            <li> 
                                <h5>T - Time bound (ograniczony w czasie) </h5>
                                <div>
                                    <p>-Kiedy musze to zrobić: <p><?PHP echo $row['TMustContent'] ; ?></p>
                                    <p>-Kiedy chcem to zrobić: <p><?PHP echo $row['TWantContent'] ; ?></p>
                                </div>
                            </li>
                            </ul>
                       </div>

                    <?PHP
                }
              }
    }

    saveURL(); 
?>
  <body onload="LoadDropDowns()">
    <?PHP showNavBar() ; ?>

    <div class="blank_start"></div>

    <div class="jumbotron" style="margin-bottom: 0px">
      <div class="container">
        <h1>SMART goals</h1>
        <p>To system rozpisywania swoich celów który pozwala na szybsze zrealizowanie i zrozumienie ich.</p>
        <p><a class="btn btn-primary btn-lg" href="https://www.projectsmart.co.uk/smart-goals.php" role="button">Dowiedz się więcej</a></p>
      </div>
    </div>

    <?PHP showGoals();?>

    </body>
    </html>
