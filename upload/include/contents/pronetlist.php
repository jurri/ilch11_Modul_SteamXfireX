<?php 
#   Copyright by: FeTTsack/Blazer
#   Support: gfa
defined ('main') or die ( 'no direct access' );

$title = $allgAr['title'].' :: Banner';
$hmenu = 'Banner';
$design = new design ( $title , $hmenu, 1);
$design->header();
?>

<script type="text/javascript">
    var boxes = 7;
    var chosenBox = 1;
    function toggleBoxes (toShow) {
        toShow = isNaN(toShow) ? 0 : toShow;
        if (toShow < 1 || toShow > boxes) {
            toShow = (chosenBox < boxes) ? chosenBox + 1 : 1;
        }
        document.getElementById('box_'+chosenBox).style.display = 'none';
        document.getElementById('box_'+toShow).style.display = '';
        chosenBox = toShow;
    }
</script>

<body onload="javascript: document.getElementById('box_2').style.display = 'none';">

<!-- Ausgabe der Buttons zum Wechseln zwischen xfire und steam -->
<div align="center">
	<a href="javascript:void(0);" onclick="toggleBoxes(1);">
		<img src="include/images/icons/steambutton_norm.png" alt="Steam" border="0" onmouseover="this.src='include/images/icons/steambutton.png'"  onmouseout="this.src='include/images/icons/steambutton_norm.png'">
	</a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:void(0);" onclick="toggleBoxes(2);">
		<img src="include/images/icons/xfirebutton_norm.png" alt="Xfire" border="0" onmouseover="this.src='include/images/icons/xfirebutton.png'"  onmouseout="this.src='include/images/icons/xfirebutton_norm.png'">
	</a>
</div>
<br />

<?php

$erg_s = db_query("SELECT * FROM prefix_user, prefix_pronetconfig WHERE steam != '' AND recht <= pc_active AND pc_str = 'add_recht' order by recht");
$erg_x = db_query("SELECT * FROM prefix_user, prefix_pronetconfig WHERE xfire != '' AND recht <= pc_active AND pc_str = 'add_recht' order by recht");
$erg_ps_steam = db_fetch_assoc(db_query("SELECT * FROM prefix_pronetsignatur WHERE ps_active = 1 AND ps_art = 'steam'"));
$erg_ps_xfire = db_fetch_assoc(db_query("SELECT * FROM prefix_pronetsignatur WHERE ps_active = 1 AND ps_art = 'xfire'"));
$erg_pc_steam = db_fetch_assoc(db_query("SELECT * FROM prefix_pronetconfig WHERE pc_active = 1 AND pc_str = 'add_steam'"));
$erg_pc_xfire = db_fetch_assoc(db_query("SELECT * FROM prefix_pronetconfig WHERE pc_active = 1 AND pc_str = 'add_xfire'"));

$link_steam = str_replace('76561198103624909.png', "", $erg_ps_steam['ps_imglink']);

//-- Ausgabe des Steam-Banner über den Signaturen
echo '<div id="box_1"><div align="center"><br/>';
echo '<a href="http://steamcommunity.com/groups/nobackup" target="_new"><img alt="Steam_Gruppe" src="include/images/bilder/Steam_Gruppe.png" style="border: 0px solid; margin: 0px;"></a><br/><br/><br/>';

while($row = db_fetch_assoc($erg_s)){
	echo '<table width="600" height="80" border="1" align="center" cellpadding="3" cellspacing="3"><tr><td width="100" class="Cnorm">';
	//-- Ausgabe des Avatars
	echo '<center><a href="index.php?user-details-'.$row['id'].'" target="_blank"><img src="'.$row['avatar'].'" alt="'.$row['name'].'" width="65" height="80" style="border: 0px solid; margin: 0px;" /></a><br/>'.$row['name'].'</center>';
	echo '</td><td width="500" class="Cnorm">';
	//-- Ausgabe der Steam-Signatur passend zum User, um die Richtige ausgabe zu ermöglichen sind paar abfragen notwendig...
	if(strlen($row['steam']) == 17 AND preg_match("/[0-9]+/", $row['steam']) == 1 AND preg_match("/[a-z]+/", strtolower($row['steam'])) == 0){
		echo '<center><a href="http://steamcommunity.com/profiles/'.$row['steam'].'" target="_new"><img src="'.$link_steam.''.$row['steam'].'.png" alt="" border="0" title="" width="440" height="111"/></a>';
	}else{
		echo '<center><a href="http://steamcommunity.com/id/'.$row['steam'].'" target="_new"><img src="'.$link_steam.''.$row['steam'].'.png" alt="" border="0" title="" width="440" height="111"/></a>';	
	}	
	//-- Ausgabe des Add-Buttons
	if($erg_pc_steam['pc_str'] == 'add_steam'){
		echo '<a href="steam://friends/add/'.$row['steam'].'"><img src="http://steamsignature.com/AddFriend.png" border="0" /></a></center>';
	}
	echo '</td></tr></table>';
}
echo '</div></div>';



//-- Ausgabe des Steam-Banner über den Signaturen
echo '<div id="box_2"><div align="center"><br/>';
echo '<a href="http://de.xfire.com/communities/nobackup" target="_new"><img alt="Xfire_Gruppe" src="include/images/bilder/Xfire_Gruppe.png" style="border: 0px solid; margin: 0px;"></a><br/><br/><br/>';
while($row = db_fetch_assoc($erg_x)){
	echo '<table width="600" height="80" border="1" align="center" cellpadding="3" cellspacing="3"><tr><td width="100" class="Cnorm">';
	//-- Ausgabe des Avatars
	echo '<center><a href="index.php?user-details-'.$row['id'].'" target="_blank"><img src="'.$row['avatar'].'" alt="'.$row['name'].'" width="65" height="80" style="border: 0px solid; margin: 0px;" /></a><br/>'.$row['name'].'</center>';
	echo '</td><td width="500" class="Cnorm">';
	//-- Ausgabe der Steam-Signatur passend zum User
	echo '<center><a href="http://profile.xfire.com/'.$row['xfire'].'" target="_new"><img src="http://de.miniprofile.xfire.com/bg/sh/type/0/'.$row['xfire'].'.png" width="440" height="111" /></a>';
	//-- Ausgabe des Add-Buttons
	echo '<a href="xfire://add_friend?user='.$row['xfire'].'"><img src="http://steamsignature.com/AddFriend.png" border="0" /></a></center>';
	echo '</td></tr></table>';
}
echo '</div></div>';

//-- Copyrigt darf nicht entfernt oder verändert werden...
echo "<br/><br/><center>&copy; by Blazer/FeTTsack &middot; Support: <a href='http://graphics-for-all.de' target='_blank'>Graphics-For-All</a></center>";
$design->footer();
?>



