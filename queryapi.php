<?php
	# Includes the autoloader for libraries installed with composer
	require __DIR__ . '/vendor/autoload.php';
	# Imports the Google Cloud client library
	use Google\Cloud\Datastore\DatastoreClient;
	
	# Your Google Cloud Platform project ID
	$projectId = 'cc-steamapi';

	# Instantiates a client
	$datastore = new DatastoreClient(['projectId' => $projectId]);

	$query = $datastore->query();
	$query->kind('SteamDB');

	$result = $datastore->runQuery($query);
?>
<html>
 <body>
 <center>
  <div><h1>Steam Queries:</h1></div>
     <a href="index.php">Home</a>    <a href="steam.php">Steam</a>    <a href="twitch.php">Twitch</a> <a href="queryapi.php">Steam Queries</a>
  <table border="1" cellspacing="5">
  <tr>
  <td><b><center>SteamID64:</center></b></td>
  <td><b><center>Display Name:</center></b></td>
  <td><b><center>Steam Level:</center></b></td>
  <td><b><center>Friends Count:</center></b></td>
  <td><b><center>Game Count:</center></b></td>
  <td><b><center>Hour Count:</center></b></td>
  </tr>
	<?php foreach ($result as $SteamDB): ?>
	<tr>
	<td><center><?php echo $SteamDB['SteamID64']; ?></center></td>
	<td><center><?php echo $SteamDB['Display Name']; ?></center></td>
	<td><center><?php echo $SteamDB['Steam Level']; ?></center></td>
	<td><center><?php echo $SteamDB['Friends Count']; ?></center></td>
	<td><center><?php echo $SteamDB['Game Count']; ?></center></td>
	<td><center><?php echo $SteamDB['Hour Count']; ?></center></td>
	</tr>
	<?php endforeach; ?>
  </center> 
</body>
</html>