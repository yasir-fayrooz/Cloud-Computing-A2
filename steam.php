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
	  
	  echo "<h1>$steam_name</h1>";
      echo "<img src='$steam_avatar'>";
	  echo "<ul>";
	  echo "<div>SteamID64: $steamID64</div>";
	  echo "<div>Display Name: $display_name</div>";
	  echo "<div>URL: $url<div>";
	  echo "<div>Status: $status<div>";
	  echo "<div>Join Date: $joined</div>";
	  echo "</ul>";
	}
	?>
	</center>
    </body>
</html>