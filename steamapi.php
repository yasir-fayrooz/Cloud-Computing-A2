<?php

	if(array_key_exists('steam_ID',$_POST)){
	$api_key = "C1476CC9F0AF0F5FB1AD5C07975B8E8A";
	
	$steamid = $_POST['steam_ID'];
	
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

?>
<html>
 <body>
 <center>
  <div><h1>Enter Steam ID 64:</h1></div>
   <a href="index.php">Home</a>    <a href="steam.php">Steam</a>    <a href="twitch.php">Twitch</a> 
 <form method="POST">
  <div><input name="steam_ID"></input> <input type="submit" value="Submit"></div>
 </form>
  </center> 
</body>
</html>