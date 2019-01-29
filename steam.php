<?  include("steamapi.php"); 
?>
<html>
    <head>
	</head>
    <body>
	<center>
	<? if($steamid != null) 
	{

	  $steam_name = $json["response"]["players"][0]["personaname"];
	  $steam_avatar = $json["response"]["players"][0]["avatarfull"];
	  $steamID64 = $json["response"]["players"][0]["steamid"];
	  $display_name = $json["response"]["players"][0]["personaname"];
	  $url = $json["response"]["players"][0]["profileurl"];
	  $status = personaState($json['response']['players'][0]['personastate']);
	  $joined = $join_date;
	  
	  if($steamID64 == null)
	  {
		echo "<div>Steam user does not exist!</div>";
	  }
	  else
	  {
		  echo "<h1>$steam_name</h1>";
		  echo "<img src='$steam_avatar'>";
		  echo "<ul>";
		  echo "<div>SteamID64: $steamID64</div>";
		  echo "<div>Display Name: $display_name</div>";
		  echo "<div>URL: $url<div>";
		  echo "<div>Status: $status<div>";
		  echo "<div>Join Date: $joined</div>";
		  
		  $game_counts = game_count("$steamID64");
		  $steam_levels = steam_level("$steamID64");
		  $friend_counts = friend_count("$steamID64");
		  $hour_counts = hour_count("$steamID64");
		  
		  if($game_counts == null)
		  {
			echo "<div>Profile is private. No information available.</div>";
		  }
		  else
		  {
		  	echo "<div>Steam Level: $steam_levels</div>";
			echo "<div>Friends Count: $friend_counts</div>";
			echo "<div>Game Count: $game_counts</div>";
			echo "<div>Hours Played: $hour_counts</div>";
			
			$db_add = db_add($steamID64, $display_name, $game_counts, $steam_levels, $friend_counts, $hour_counts);
			
			echo "Saved to database!";
		  
		  }
		  
		  echo "</ul>";
	  }
	}
	?>
	</center>
    </body>
</html>