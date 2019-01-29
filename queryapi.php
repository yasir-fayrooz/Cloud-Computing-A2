<?php
	
	# Includes the autoloader for libraries installed with composer
	require __DIR__ . '/vendor/autoload.php';
	# Imports the Google Cloud client library
	use Google\Cloud\Datastore\DatastoreClient;
	
	$datastore = new DatastoreClient([
    'projectId' => 'my_project'
	]);


	$query = $datastore->query();
	$query->kind('Notes');
	$query->filter('name ', '=', 'test1');

	$res = $datastore->runQuery($query);
	foreach ($res as $notes) {
		echo $notes['name']; // test1
	}
?>
<html>
 <body>
 <center>
  <div><h1>Steam Queries:</h1></div>
     <a href="index.php">Home</a>    <a href="steam.php">Steam</a>    <a href="twitch.php">Twitch</a> <a href="queryapi.php">Steam Queries</a> 
  </center> 
</body>
</html>