<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>League</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/js/materialize.min.js"></script>
  </head>
<?php
	session_start();
	include './class.php';
	?>
<?php if (!$_SESSION['token']): ?>

<body>
	<div class="valign-wrapper">
  		<h5 class="valign">Please Log in before using.</h5>
	</div>
</body>

<?php else: ?>

<div class="navbar-fixed">
    <nav>
      <div class="nav-wrapper">
        <a href="#!" class="brand-logo">Bowling Jackpot</a>
        <ul class="right hide-on-med-and-down">
          <li><a href="./index.php?stay=true">Beta Version</a></li>
          <li><a href="./logout.php">Logout</a></li>
        </ul>
      </div>
    </nav>
  </div>

<?php if (!$_SESSION['leagueID']): ?>
	<div>
		 <form action="./setapi.php?type=setleagueID" method='post'>
		 <h4>Select from Existing Leagues</h4>
		 <br>
		 <?php 
		 	$retList = user::showLeague($_SESSION['token']);
		 	foreach ($retList as $retItem){
		 		echo "<p><input name='league' type='radio' value='"
		 				.$retItem->id."' id='"
		 				.$retItem->id."'/> <label for='"
		 				.$retItem->id."'>"
		 				.$retItem->name."</label></p>";
		 	}
		 ?>
		 <h4>Or Create a New One</h4>
		 <br>
   		 <div>
      	 <div class="row">
         	<div class="input-field col s12">
          		Name
          		<input name="leagueName" class="validate">
        	</div>
      	 </div>
     	<button class="btn waves-effect waves-light" type="submit" name="action">Select
  		</button>
    	</form>
  	</div>
<br>

<?php else: ?>

	<?php if($_GET['winning_id'] == NULL): ?>

	CURRENT LEAGUE: 
	<?php 
		$info = user::getOneLeague($_SESSION['token'], $_SESSION['leagueID']);
		echo $info->name;
	?>
	<br>
	<a href="./logout.php?type=leagueID">Choose Another League</a>
	<br>
	<div class="row">
        <div class="col s12 m6">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <span class="card-title">Current League Info</span>
              <p>Users:</p>
              <form action="./setapi.php?type=buyTicket" method='post'>
              <?php
              	$info = user::showBowler($_SESSION['token'], $_SESSION['leagueID']);
              	foreach ($info as $infoItem){
		 				echo "<p><input name='bowlerL' type='radio' value='"
		 				.$infoItem->id."' id='"
		 				.$infoItem->id."'/> <label for='"
		 				.$infoItem->id."'>"
		 				.$infoItem->name."</label></p>";
		 		}
              ?>
               <button class="btn waves-effect waves-light" type="submit" name="action">Buy him a ticket
  				</button>
  			  </form>
            </div>
            <div class="card-action">
              <a href="./show.php">Jackpot History</a>
             </div>
          </div>
        </div>
      </div>

      </br>
      <div class="row">
        <div class="col s12 m6">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <span class="card-title">Current Bowler Info</span>
              <p>Bowlers:</p>
              <form action="./setapi.php?type=addBowler" method='post'>
              <?php
              	$info = user::getBowler($_SESSION['token']);
              	foreach ($info as $infoItem){
		 				echo "<p><input name='bowlerN' type='radio' value='"
		 				.$infoItem->id."' id='"
		 				.$infoItem->id."'/> <label for='"
		 				.$infoItem->id."'>"
		 				.$infoItem->name."</label></p>";
		 		}
              ?>
              <button class="btn waves-effect waves-light" type="submit" name="action">Add to League
  				</button>
  				</form>
            </div>
            <div class="card-action">
            	<div>
    			<form class="col s12" action="./setapi.php?type=createBowler" method="post">
     				 <div class="row">
        				<div class="input-field col s12">
          				Bowler Name
          				<input name="bowlerName" class="validate">
        				</div>
      				 </div>
     				<button class="btn waves-effect waves-light" type="submit" name="action">Create
  					</button>
  					<br>
    			</form>
  				</div>
            </div>
            </div>

            <div class="row">
        		<div class="col s12 m6">
          			<div class="card blue-grey darken-1">
           				 <div class="card-content white-text">
              			<span class="card-title">Ticket Info</span>
              			<?php
              				$lotteryID = user::showLottery($_SESSION['token'], $_SESSION['leagueID']);
							$lotteryID = end($lotteryID)->id;
              				$info = user::showTicket($_SESSION['token'], $_SESSION['leagueID'], $lotteryID);
              				foreach ($info as $infoItem){
              					$bowlerName = user::getOneBowler($_SESSION['token'], $infoItem->bowler_id);
              					$bowlerName = $bowlerName->name;
              					$price = $infoItem->price;
              					echo "<p>".$bowlerName.": ".$price."</p>";
              				}
              			?>
            			</div>
            		<div class="card-action">
              			<form action="./setapi.php?type=draw" method="post">
              				<button class="btn waves-effect waves-light" type="submit" name="action">Draw!
  							</button>
  						</form>
            		</div>
          			</div>
        		</div>
      		</div>
            
        </div>
      </div>

  <?php else: ?>
  	<?php 
  		if ($_GET['error'] == NULL){
  			$winnerInfo = user::getOneBowler($_SESSION['token'], $_GET['winning_id']);
  			echo "<h2>Bowler <stong>".$winnerInfo->name."</strong> won this Jackpot!</h2>";
  			$ltInfo = user::drawTicket($_SESSION['token'], $_SESSION['leagueID'], $_GET['lottery_id']);
  			echo "<h2>Payout: ".$ltInfo->payout."</h2>";
  		}
  		else {
  			echo $_GET['error'];
  		}
  	?>
  	<a href="./welcome.php"><h2> OK </h2></a>
<?php endif ?>
<?php endif ?>
<?php endif ?>
</html>
