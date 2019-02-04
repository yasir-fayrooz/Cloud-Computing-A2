<? include("steamapi.php");?>
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
	<center>
	<?if($steamid != null) 
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
		?>
        <p class="steamError"> Steam Account not found! </p>
 <?php
	  }
	  else
	  {
         ?>
    <div class="steamContent1"> 
        <?php  echo "<img src='$steam_avatar'>"; ?>
        <h1 class="steamName"> <?php echo $steam_name ?> </h1>
        <p> <b>Joined :</b><?php echo $joined ?></p> 
        <p> <b>Steam ID :</b><?php echo $steamID64 ?></p> 
        <p> <b>Steam URL :</b><?php echo $url ?></p> 
        <p> <b>Steam Status :</b><?php echo $status ?></p> 
        </div> 
        
     
 <?php
$game_counts = game_count("$steamID64");
		  $steam_levels = steam_level("$steamID64");
		  $friend_counts = friend_count("$steamID64");
		  $hour_counts = hour_count("$steamID64");             
//             
       
//		  echo "<h1>$steam_name</h1>";
//		  echo "<img src='$steam_avatar'>";
//		  echo "<ul>";
//		  echo "<div>SteamID64: $steamID64</div>";
//		  echo "<div>Display Name: $display_name</div>";
//		  echo "<div>URL: $url<div>";
//		  echo "<div>Status: $status<div>";
//		  echo "<div>Join Date: $joined</div>";
             
		  
		  $profile_private = game_count("$steamID64");
		  
		  if($profile_private == null)
		  {
 ?>   
        <div class="steamContent2">
        <header class="steamHeading">Profile is Private. No extra gaming information is available</header> 
        </div>
        <?php
		  }
		  else
		  {
               
              
              ?>   
        <div class="steamContent2">
            <header class="steamHeading"> Gaming Information </header>

        <p class="steamDescrip"> <b>Steam Level :</b> <?php echo $steam_levels ?></p>
        <p class="steamDescrip"> <b>Friends Count :</b> <?php echo $friend_counts ?></p>
        <p class="steamDescrip "> <b>Game Count :</b> <?php echo $game_counts ?> </p>
        
        <p class="steamDescrip "> <b>Total Hours Played :</b> <?php echo $hour_counts ?> </p>
              
        </div>
        
        <?php
        $db_add = db_add($steamID64, $display_name, $game_counts, $steam_levels, $friend_counts, $hour_counts);
              
        ?>
        <p class="steamError"> Added to Database! </p>
 <?php     
                 
//			echo "<div>Friends Count: "; echo friend_count("$steamID64"); echo "</div>";
//			echo "<div>Game Count: "; echo game_count("$steamID64"); echo "</div>";
//			echo "<div>Hours Played: "; echo hour_count("$steamID64"); echo "</div>";
		  }
//		  echo "</ul>";
	  }
	}
	?>
        
  
   
	</center>
   
    </body>
</html>