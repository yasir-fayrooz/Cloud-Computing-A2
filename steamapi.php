<?php
	
	# Includes the autoloader for libraries installed with composer
	require __DIR__ . '/vendor/autoload.php';
	# Imports the Google Cloud client library
	use Google\Cloud\Datastore\DatastoreClient;
	
	
	if(array_key_exists('steam_ID',$_POST)){
	$api_key = "C1476CC9F0AF0F5FB1AD5C07975B8E8A";
	
	$steamid = $_POST['steam_ID'];
	
	$api_url2 = "http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=$api_key&vanityurl=$steamid";
	$json2 = json_decode(file_get_contents($api_url2), true);
	
	$steam64id = $json2["response"]["steamid"];
	
	if($steam64id != null)
	{
		$steamid = $steam64id;
	}
	
	$api_url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$api_key&steamids=$steamid";
	
	$json = json_decode(file_get_contents($api_url), true);
	
	$join_date = date("D, M j, Y", $json["response"]["players"][0]["timecreated"]);

    function personaState($state)
    {
        if ($state == 1)
        {
            return "Online";
        }
        elseif ($state == 2)
        {
            return "Busy";
        }
        elseif ($state == 3)
        {
            return "Away";
        }
        elseif ($state == 4)
        {
            return "Snooze";
        }
        elseif ($state == 5)
        {
            return "Looking to trade";
        }
        elseif ($state == 6)
        {
            return "Looking to play";
        }
        else
        {
            return "Offline";
        }
    }
	}
	
	function friend_count($steam64)
{
	$api_key = "C1476CC9F0AF0F5FB1AD5C07975B8E8A";
    $data = json_decode(file_get_contents("https://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=$api_key&steamid=$steam64&relationship=friend"));
    $friends_count = count($data->friendslist->friends);
    return $friends_count;
}

	function game_count($steam64)
{
	$api_key = "C1476CC9F0AF0F5FB1AD5C07975B8E8A";
    $data = json_decode(file_get_contents("https://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=$api_key&steamid=$steam64&include_played_free_games=0&include_appinfo=1"));
    $games_count = $data->response->game_count;
    return $games_count;
}

	function hour_count($steam64)
{
	$api_key = "C1476CC9F0AF0F5FB1AD5C07975B8E8A";
    $data = json_decode(file_get_contents("https://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=$api_key&steamid=$steam64&include_played_free_games=0&include_appinfo=1"));
	$total = 0;
	foreach($data->response->games as $mygames)
	{
		$total = $total + $mygames->playtime_forever;
	}
	$hours_count = number_format((float)$total / 60, 2, '.', '');
	
    return $hours_count;
}

	function steam_level($steam64)
{
	$api_key = "C1476CC9F0AF0F5FB1AD5C07975B8E8A";
    $data = json_decode(file_get_contents("https://api.steampowered.com/IPlayerService/GetSteamLevel/v1/?key=$api_key&steamid=$steam64"));
	$steam_lvl = $data->response->player_level;
    
	return $steam_lvl;
}

	function db_add($steamID64, $display_name, $game_counts, $steam_levels, $friend_counts, $hour_counts)
		{	
		# Your Google Cloud Platform project ID
		$projectId = 'cc-steamapi';
	
		# Instantiates a client
		$datastore = new DatastoreClient(['projectId' => $projectId]);

		# The kind for the new entity
		$kind = 'SteamDB';
	
		# The name/ID for the new entity
		$id64 = "$steamID64";

		# The Cloud Datastore key for the new entity
		$taskKey = $datastore->key($kind,$steamID64);

		# Prepares the new entity
		$task = $datastore->entity($taskKey, [
		'SteamID64' => $steamID64,
		'Display Name' => "$display_name",
		'Steam Level' => $steam_levels,
		'Friends Count' => $friend_counts,
		'Game Count' => $game_counts,
		'Hour Count' => (float)$hour_counts
		]);

		# Saves the entity
		$datastore->insert($task);
	}

?>
<!DOCTYPE html>
<html>
    <link rel = "stylesheet" type="text/css" href = "/bootstrap/css/stylesheet.css">
    <link href='https://fonts.googleapis.com/css?family=Fredoka One' rel='stylesheet'>
    <!-- We will cover style later. Skip down to the body tag -->
  <link />
    <link href='https://fonts.googleapis.com/css?family=Asap' rel='stylesheet'>
 <body>
 <center>
  <body bgcolor="242b37">
<div id="Logo">
    <img src="img/steam-logo-png-8.png" height="50%s">
    </div>
 <main>

     <nav>
    <ul class ="nav">
  <li><a class="" href="index.php">Home</a></li>
  <li><a href="steam.php">Steam</a></li>
  <li><a href="http://cc-assinment2.appspot.com/">Game charts</a></li>
  <li><a href="queryapi.php">SteamQuery</a></li>

</ul>
  </nav>
     <div class="gap">
         <form method="POST">
         <h1 id="heading">Search for Steam ID : </h1>
           <input  name="steam_ID" class="input2" > 
   <br>
   <br>
   <br>
   <br>
   <br>
            <input type="submit" name="submit" class="login" placeholder="Enter">
         </form>
   
     </div>
  </center> 
</body>
</html>