<?php
	# Includes the autoloader for libraries installed with composer
	require __DIR__ . '/vendor/autoload.php';
	# Imports the Google Cloud client library
	use Google\Cloud\Datastore\DatastoreClient;
	use Google\Cloud\Datastore\Query\Query;

		
	$selectOption = $_POST['Orderby'];
	
	$steamIds = array();
	
	if (isset($_POST["cleardata"]))
	{
		# Your Google Cloud Platform project ID
		$projectId = 'cc-steamapi';
		
		# Instantiates a client
		$datastore = new DatastoreClient(['projectId' => $projectId]);
		
		foreach($steamIds as $id)
		{
			#$key = $datastore->key("SteamDB", $id);
			#$datastore->delete($key);
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
 <body>
 <center>
  <div><h1>Steam Queries:</h1></div>
     <a href="index.php">Home</a>    <a href="steam.php">Steam</a>    <a href="twitch.php">Twitch</a> <a href="queryapi.php">Steam Queries</a>
  <form method="POST">
  <center><b>Order by:</b> <?php echo $selectOption; ?></center>
  <select name="Orderby">
  <option name = "Display Name">Display Name</option>
  <option name = "Steam Level">Steam Level</option>
  <option name = "Friends Count">Friends Count</option>
  <option name = "Game Count">Game Count</option>
  <option name = "Hour Count">Hour Count</option>
  <input type="submit" value="submit"></input>
  </select>
  </form>
  <form method="POST">
  <input type="submit" value="clear all data" name="cleardata" id="cleardata"></input>
  </form>
  <table border="1" cellspacing="5">
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