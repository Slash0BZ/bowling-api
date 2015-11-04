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
<?php if (!$_SESSION['token'] || !$_SESSION['leagueID']): ?>

<body>
	<div class="valign-wrapper">
  		<h5 class="valign">Please Log in and choose League before using.</h5>
	</div>
</body>

<?php else: ?>

<div class="navbar-fixed">
    <nav>
      <div class="nav-wrapper">
        <a href="#!" class="brand-logo">Bowling Jackpot History</a>
        <ul class="right hide-on-med-and-down">
          <li><a href="./index.php?stay=true">Beta Version</a></li>
          <li><a href="./logout.php">Logout</a></li>
        </ul>
      </div>
    </nav>
  </div>

  <table>
        <thead>
          <tr>
              <th data-field="id">Lottery</th>
              <th data-field="name">Balance</th>
              <th data-field="price">Payout</th>
          </tr>
        </thead>

        <tbody>
           <?php 
          $info = user::showLottery($_SESSION['token'], $_SESSION['leagueID']);
          foreach($info as $infoItem){
              echo "<tr><td>".$infoItem->id."</td><td>".$infoItem->balance."</td><td>".$infoItem->payout."</td></tr>";
          }
?>

        </tbody>
      </table>
<a href="welcome.php"><h2>Go Back </h2></a>


<?php endif ?>
