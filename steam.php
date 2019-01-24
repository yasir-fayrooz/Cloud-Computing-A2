<? include("steamapi.php");?>
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
		  
		  $profile_private = game_count("$steamID64");
		  
		  if($profile_private == null)
		  {
			echo "<div>Profile is private. No information available.</div>";
		  }
		  else
		  {
			echo "<div>Friends Count: "; echo friend_count("$steamID64"); echo "</div>";
			echo "<div>Game Count: "; echo game_count("$steamID64"); echo "</div>";
			echo "<div>Hours Played: "; echo hour_count("$steamID64"); echo "</div>";
		  }
		  echo "</ul>";
	  }
	}
	?>
	</center>
    </body>
</html>