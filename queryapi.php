<?php
	# Includes the autoloader for libraries installed with composer
	require __DIR__ . '/vendor/autoload.php';
	# Imports the Google Cloud client library
	use Google\Cloud\Datastore\DatastoreClient;
	use Google\Cloud\Datastore\Query\Query;

		
	$selectOption = $_POST['Orderby'];
	
	if (isset($_POST["cleardata"]))
	{
		# Your Google Cloud Platform project ID
		$projectId = 'cc-steamapi';
		
		# Instantiates a client
		$datastore = new DatastoreClient(['projectId' => $projectId]);
		
		$query = $datastore->query()
		->kind('SteamDB');

		$results = $datastore->runQuery($query);
		
		foreach($results as $SteamDB)
		{
			$key = $datastore->key("SteamDB", $SteamDB['SteamID64']);
			$datastore->delete($key);
		}
	}
	
	function results($option)
	{
	# Your Google Cloud Platform project ID
	$projectId = 'cc-steamapi';
	
	# Instantiates a client
	$datastore = new DatastoreClient(['projectId' => $projectId]);

	$query = $datastore->query()
    ->kind('SteamDB')
    ->order($option, Query::ORDER_DESCENDING);

	$result = $datastore->runQuery($query);
	
	return $result;
	}
?>
<html>
     <link rel = "stylesheet" type="text/css" href = "/bootstrap/css/stylesheet.css">
    <link href='https://fonts.googleapis.com/css?family=Fredoka One' rel='stylesheet'>
    <!-- We will cover style later. Skip down to the body tag -->
  <link />
    <link href='https://fonts.googleapis.com/css?family=Asap' rel='stylesheet'>
 <body bgcolor="242b37">
 <center>
  
     <nav>
    <ul class ="nav">
  <li><a class="" href="index.php">Home</a></li>
  <li><a href="steam.php">Steam</a></li>
  <li><a href="twitch.php">Twitch</a></li>
  <li><a href="queryapi.php">SteamQuery</a></li>

</ul>
  </nav>
     
     
    <br>
    <br>
    <br>
     
     <header class="steamError"> Steam Table </header>
    <br> 
    <br> 
    <br> 
  <form method="POST">
  <center><p class="labelThing">Order by:</p> <?php echo $selectOption; ?></center>
  <select class=" selection "name="Orderby">
  <option name = "Display Name">Display Name</option>
  <option name = "Steam Level">Steam Level</option>
  <option name = "Friends Count">Friends Count</option>
  <option name = "Game Count">Game Count</option>
  <option name = "Hour Count">Hour Count</option>
 
  </select>
       <input class="selectionSub" type="submit" value="submit">
  </form>
  <form method="POST">
  <input class="selectionSub"type="submit" value="clear all data" name="cleardata" id="cleardata">
  </form>
 
    
    <table class="blueTable">
  <tr>
  <td><b><center>SteamID64:</center></b></td>
  <td><b><center>Display Name:</center></b></td>
  <td><b><center>Steam Level:</center></b></td>
  <td><b><center>Friends Count:</center></b></td>
  <td><b><center>Game Count:</center></b></td>
  <td><b><center>Hour Count:</center></b></td>
  </tr>
	<?php 
	if($selectOption == null)
	{
		$selectOption = "Display Name";
	}
	foreach (results($selectOption) as $SteamDB): 
	$steamIds[] = $SteamDB['SteamID64']; ?>
	<tr>
	<td><center><?php echo $SteamDB['SteamID64']; ?></center></td>
	<td><center><?php echo $SteamDB['Display Name']; ?></center></td>
	<td><center><?php echo $SteamDB['Steam Level']; ?></center></td>
	<td><center><?php echo $SteamDB['Friends Count']; ?></center></td>
	<td><center><?php echo $SteamDB['Game Count']; ?></center></td>
	<td><center><?php echo $SteamDB['Hour Count']; ?></center></td>
	</tr>
	<?php endforeach;?>
	</table>
  </center> 
</body>
</html>