<?php

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
	

?>
<html>
 <body>
 <center>
  <div><h1>Enter Steam URL name or steam ID:</h1></div>
   <a href="index.php">Home</a>    <a href="steam.php">Steam</a>    <a href="twitch.php">Twitch</a> 
 <form method="POST">
  <div><input name="steam_ID"></input> <input type="submit" value="Submit"></div>
 </form>
  </center> 
</body>
</html>