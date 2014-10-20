<?php 
#   Copyright by: FeTTsack
#   Support: gfa / gcc


defined ('main') or die ( 'no direct access' );
defined ('admin') or die ( 'only admin access' );

$design = new design ( 'Admins Area', 'Admins Area', 2 );
$design->header();

/*
* Ermöglicht die Vorschau
*/
$js = <<<end_of_quote
<script type="text/javascript">
<!--//
	function getsig(info){
		if(info == 'steam'){
			document.getElementById('sig_anzeige_steam').innerHTML = '<img src="' + document.getElementById('s_steams').value + '"/>';
		}
		if(info == 'xfire'){
			var strall_x = document.getElementById('s_xfires').value;
			var height_x = strall_x.substring(strall_x.lastIndexOf('__'));
			strall_x = strall_x.replace(height_x, '');
			height_x = height_x.replace('__', '');
			var width_x = strall_x.substring(strall_x.lastIndexOf('__'));
			var imglink = strall_x.replace(width_x, '');
			width_x = width_x.replace('__', '');
			document.getElementById('sig_anzeige_xfire').innerHTML = '<img src="http://de.miniprofile.xfire.com/bg/' + document.getElementById('s_xfirez').value + '' + imglink + '" width="' + width_x + '" height="' + height_x + '"/>';		
		}
	}			
//-->
</script>
end_of_quote;
echo $js;


/*
* Rechte festlegen ab wann angezeigt wird.
*/
if(isset($_POST['sub_recht'])){
	$recht = $_POST['s_recht'];
	db_query("UPDATE prefix_pronetconfig SET pc_active = '$recht' WHERE pc_str = 'add_recht'");
}

/*
* Auswahl von Steam speichern
*/
if(isset($_POST['sub_insert_steam'])){
	if(isset($_POST['check_add_steam'])){
		$adds = 1;
	}else{
		$adds = 0;
	}
	$select = $_POST['s_steams'];
	if($_POST['t_imglinksteam'] == 'hier den link zum xFire-Banner einf&uuml;gen.'){
		$banner = 0;
	}else{
		$banner = $_POST['t_imglinksteam'];
	}
	db_query("UPDATE prefix_pronetsignatur SET ps_active = 0 WHERE ps_art = 'steam'");
	db_query("UPDATE prefix_pronetsignatur SET ps_active = 1 WHERE ps_imglink = '$select'");
	db_query("UPDATE prefix_pronetconfig SET pc_active = '$adds' WHERE pc_str = 'add_steam'");
	db_query("UPDATE prefix_pronetconfig SET pc_active = '$banner' WHERE pc_str = 'img_steam'");
}

/*
* Auswahl von xfire speichern
*/
if(isset($_POST['sub_insert_xfire'])){
	if(isset($_POST['check_add_xfire'])){
		$adds = 1;
	}else{
		$adds = 0;
	}
	$select = $_POST['s_xfires'];
	$style = $_POST['s_xfirez'];
	if($_POST['t_imglinkxfire'] == 'hier den link zum xFire-Banner einf&uuml;gen.'){
		$banner = 0;
	}else{
		$banner = $_POST['t_imglinkxfire'];
	}	
	db_query("UPDATE prefix_pronetsignatur SET ps_active = 0 WHERE ps_art = 'xfire'");
	db_query("UPDATE prefix_pronetsignatur SET ps_active = 1, ps_zusatz = '$style' WHERE ps_imglink = '$select'");
	db_query("UPDATE prefix_pronetconfig SET pc_active = '$adds' WHERE pc_str = 'add_xfire'");
	db_query("UPDATE prefix_pronetconfig SET pc_active = '$banner' WHERE pc_str = 'img_xfire'");
}

echo '<form action="?pronetlist" method="post" name="form1"><input type="submit" name="sub_steam" value="Steam Konfiguaration"/>&nbsp;&nbsp;&nbsp;<input type="submit" name="sub_xfire" value="xFire Konfiguaration"/><hr/>';

$erecht = db_query("SELECT * FROM prefix_grundrechte ORDER BY id DESC");
$erechtcfg = db_fetch_assoc(db_query("SELECT * FROM prefix_pronetconfig WHERE pc_str = 'add_recht'"));
echo '<select name="s_recht">';
while($row = db_fetch_assoc($erecht)){
	if($row['id'] == $erechtcfg['pc_active']){
		echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
	}else{
		echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
	}
}
echo '</select><input type="submit" name="sub_recht" value="Rang festlegen"/></form>';


$x = 1;

if(isset($_POST['sub_steam']) OR isset($_POST['sub_insert_steam'])){
	$erg_s = db_query("SELECT distinct * FROM prefix_pronetsignatur WHERE ps_art = 'steam' ORDER BY ps_pk");
	$erg_sa = db_fetch_assoc(db_query("SELECT * FROM prefix_pronetsignatur WHERE ps_active = 1 AND ps_art = 'steam'"));
	$erg_c = db_query("SELECT * FROM prefix_pronetconfig");
	echo '<form action="?pronetlist" method="post" name="form_steam">';
	echo '<table width="100%" height="175px" border="1"><tr><th>Auswahl</th><th>Vorschau</th><th>Aktiv</th></tr><tr><td align="left" width="75px">';

	//-- Dropdown aus der DB um die Signatur auszuwählen.
	echo '<select id="s_steams" name="s_steams" onchange="javascript:getsig(\'steam\');"><option value="-" selected>-</option>';
	while($row = db_fetch_assoc($erg_s)){
		$y[$x] = $row['ps_code'];
		if($y[$x-1] != $row['ps_code']){
			//echo '<option value="'.$row['ps_imglink'].'__'.$row['ps_zusatz'].'__'.$row['ps_code'].'">'.$row['ps_code'].'</option>';
			echo '<option value="'.$row['ps_imglink'].'">'.$row['ps_code'].'</option>';
		}
		$x++;
	}
	echo '</select></td><td width="400px" align="left">';

	//-- Vorschau Ausgabe
	echo '<div id="sig_anzeige_steam" name="sig_anzeige_steam"></div></td>';

	//-- Anzeige was Aktiv ist
	echo '<td align="right" width="400px">';
	if($erg_sa['ps_imglink'] != ''){
		echo '<img src="'.$erg_sa['ps_imglink'].'"/>';
	}
	echo '</td></tr></table>';

	//-- Checkbox welche Prüft ob Addfunktion aktiv ist oder nicht.
	while($row = db_fetch_assoc($erg_c)){
		if($row['pc_str'] == 'add_steam'){
			if($row['pc_active'] == 1){
				echo '<input type="checkbox" name="check_add_steam" value="1" checked/>Add Funktion';
			}else{
				echo '<input type="checkbox" name="check_add_steam" value="0"/>Add Funktion';
			}
		}
		
	}
	//echo '<br/><input size="60" type="text" name="t_imglinksteam" value="hier den link zum Steam-Banner einf&uuml;gen." onFocus="if(this.value==\'hier den link zum Steam-Banner einf&uuml;gen.\') this.value=\'\'"/><br/><input type="submit" name="sub_insert_steam" value="Speichern"/></form>';
	echo '<br/><input type="submit" name="sub_insert_steam" value="Speichern"/></form>';
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_POST['sub_xfire']) OR isset($_POST['sub_insert_xfire'])){
	$erg_x = db_query("SELECT distinct * FROM prefix_pronetsignatur WHERE ps_art = 'xfire' ORDER BY ps_pk");
	$erg_xa = db_fetch_assoc(db_query("SELECT * FROM prefix_pronetsignatur WHERE ps_active = 1 AND ps_art = 'xfire'"));
	$erg_c = db_query("SELECT * FROM prefix_pronetconfig");
	echo '<form action="?pronetlist" method="post" name="form_xfire">';
	echo '<table width="100%" height="175px" border="1"><tr><th width="75px">Auswahl</th><th>Vorschau</th><th>Aktiv</th></tr><tr><td align="left" width="75px"><table><tr><td>';

	//-- Dropdown aus der DB um die Signatur auszuwählen.
	echo '<select id="s_xfires" name="s_xfires" onchange="javascript:getsig(\'xfire\');"><option value="-" selected>-</option>';
	while($row = db_fetch_assoc($erg_x)){
		$y[$x] = $row['ps_code'];
		if($y[$x-1] != $row['ps_code']){
			echo '<option value="'.$row['ps_imglink'].'">'.$row['ps_code'].'</option>';
		}
		$x++;
	}
	echo '</select></td></tr><tr><td>';

	//-- Dropdownbox um die Farbe zu bestimmen.
	echo '<select id="s_xfirez" name="s_xfirez" onchange="javascript:getsig(\'xfire\');"><option value="sh">Shadow</option><option value="co">Kampf</option><option value="sf">Sci-Fi</option><option value="os">Fantasy</option><option value="wow">World of Warcraft</option><option value="bg">Standart</option></select>';
	echo '</td></tr></table></td><td width="400px" align="left">';

	//-- Vorschau Ausgabe
	echo '<div id="sig_anzeige_xfire" name="sig_anzeige_xfire"></div></td>';

	//-- Anzeige was Aktiv ist
	echo '<td align="right" valign="top" width="400px">';
	if($erg_xa['ps_imglink'] != ''){
		$strimg = explode('__', $erg_xa['ps_imglink']);
		echo '<img src="http://de.miniprofile.xfire.com/bg/'.$erg_xa['ps_zusatz'].''.$strimg[0].'" width="'.$strimg[1].'" height="'.$strimg[2].'"/>';
	}
	echo '</td></tr></table>';

	//-- Checkbox welche Prüft ob Addfunktion aktiv ist oder nicht.
	while($row = db_fetch_assoc($erg_c)){
		if($row['pc_str'] == 'add_xfire'){
			if($row['pc_active'] == 1){
				echo '<input type="checkbox" name="check_add_xfire" value="1" checked/>Add Funktion';
			}else{
				echo '<input type="checkbox" name="check_add_xfire" value="0"/>Add Funktion';
			}
		}
		
	}
	//echo '<br/><input size="60" type="text" name="t_imglinkxfire" value="hier den link zum xFire-Banner einf&uuml;gen." onFocus="if(this.value==\'hier den link zum xFire-Banner einf&uuml;gen.\') this.value=\'\'"/><br/><input type="submit" name="sub_insert_xfire" value="Speichern"/></form>';
	echo '<br/><input type="submit" name="sub_insert_xfire" value="Speichern"/></form>';
}

$design->footer();
?>