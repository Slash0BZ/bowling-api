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
?>

<?php if ($_SESSION['token']): ?>
<body>
Logged In
<a href="./logout.php">logout</a>
<?php if ($_GET['stay'] == NULL) Header("Location: ./welcome.php"); ?>
<br>
Create League
<div>
    <form class="col s12" action="./api.php?type=createLeague" method="post">
      <div class="row">
        <div class="input-field col s12">
          Name
          <input name="leagueName" class="validate">
        </div>
      </div>
     <button class="btn waves-effect waves-light" type="submit" name="action">Create
  	</button>
    </form>
  </div>
<br>
List All Leagues
  <div>
    <form class="col s12" action="./api.php?type=getLeague" method="post">
     <button class="btn waves-effect waves-light" type="submit" name="action">Show
  	</button>
    </form>
  </div>
<br>
Show League Info By ID
<div>
    <form class="col s12" action="./api.php?type=getOneLeague" method="post">
      <div class="row">
        <div class="input-field col s12">
          League ID
          <input name="leagueID" class="validate">
        </div>
      </div>
     <button class="btn waves-effect waves-light" type="submit" name="action">Show
  	</button>
    </form>
  </div>
<br>
Create a Bowler 
<div>
    <form class="col s12" action="./api.php?type=createBowler" method="post">
      <div class="row">
        <div class="input-field col s12">
          Bowler Name
          <input name="bowlerName" class="validate">
        </div>
      </div>
     <button class="btn waves-effect waves-light" type="submit" name="action">Create
  	</button>
    </form>
  </div>
<br>
Show All Bowlers
  <div>
    <form class="col s12" action="./api.php?type=getBowler" method="post">
     <button class="btn waves-effect waves-light" type="submit" name="action">Show
  	</button>
    </form>
  </div>
<br>
Show Bowler Info By ID
<div>
    <form class="col s12" action="./api.php?type=getOneBowler" method="post">
      <div class="row">
        <div class="input-field col s12">
          Bowler ID
          <input name="BowlerID" class="validate">
        </div>
      </div>
     <button class="btn waves-effect waves-light" type="submit" name="action">Show
  	</button>
    </form>
  </div>
<br>
Add a Bowler to League
<div>
    <form class="col s12" action="./api.php?type=addBowler" method="post">
      <div class="row">
        <div class="input-field col s12">
          Bowler ID
          <input name="aBowlerID" class="validate">
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          League ID
          <input name="aLeagueID" class="validate">
        </div>
      </div>
     <button class="btn waves-effect waves-light" type="submit" name="action">Add
  	</button>
    </form>
  </div>
<br>
Show Bowler By League ID
<div>
    <form class="col s12" action="./api.php?type=getOneBowler" method="post">
      <div class="row">
        <div class="input-field col s12">
          League ID
          <input name="sLeagueID" class="validate">
        </div>
      </div>
     <button class="btn waves-effect waves-light" type="submit" name="action">Show
  	</button>
    </form>
  </div>
<br>
Show Lottery by League ID
<div>
    <form class="col s12" action="./api.php?type=showLottery" method="post">
      <div class="row">
        <div class="input-field col s12">
          League ID
          <input name="ssLeagueID" class="validate">
        </div>
      </div>
     <button class="btn waves-effect waves-light" type="submit" name="action">Show
  	</button>
    </form>
  </div>
<br>
Buy Lottery for Bowler
<div>
    <form class="col s12" action="./api.php?type=buyTicket" method="post">
      <div class="row">
        <div class="input-field col s12">
          League ID
          <input name="blid" class="validate">
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          Lottery ID
          <input name="bltid" class="validate">
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          Bowler ID
          <input name="bbid" class="validate">
        </div>
      </div>
     <button class="btn waves-effect waves-light" type="submit" name="action">Buy
  	</button>
    </form>
  </div>
<br>
Show Tickets
<div>
    <form class="col s12" action="./api.php?type=showTicket" method="post">
      <div class="row">
        <div class="input-field col s12">
          League ID
          <input name="sslid" class="validate">
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          Lottery ID
          <input name="ssltid" class="validate">
        </div>
      </div>
     <button class="btn waves-effect waves-light" type="submit" name="action">Show
  	</button>
    </form>
  </div>
<br>
Draw Ticket
<div>
    <form class="col s12" action="./api.php?type=drawTicket" method="post">
      <div class="row">
        <div class="input-field col s12">
          League ID
          <input name="dlid" class="validate">
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          Lottery ID
          <input name="dltid" class="validate">
        </div>
      </div>
     <button class="btn waves-effect waves-light" type="submit" name="action">Draw
  	</button>
    </form>
  </div>
</body>

<?php else: ?>
<body>
Please Log In <br>
<div class="row">
    <form class="col s12" action="./api.php?type=login" method="post">
      <div class="row">
        <div class="input-field col s12">
          Email
          <input id="email" name="email" type="email" class="validate">
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          Password
          <input id="password" name="password" type="password" class="validate">
        </div>
      </div>
     <button class="btn waves-effect waves-light" type="submit" name="action">Submit
  	</button>
    </form>
  </div>
Or Sign up.
<br>
<div class="row">
    <form class="col s12" action="./api.php?type=signup" method="post">
      <div class="row">
        <div class="input-field col s12">
  	  Email
          <input name="semail" type="email" class="validate">
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          Password
          <input name="spassword" type="password" class="validate">
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
		Confirm Password
          <input name="srepassword" type="password" class="validate">
        </div>
      </div>
     <button class="btn waves-effect waves-light" type="submit" name="action">Submit
  	</button>
    </form>
  </div>
</body>

<?php endif ?>
