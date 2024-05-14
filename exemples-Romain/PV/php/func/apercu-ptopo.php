<?php
// appelé par index.php

ini_set('display_error', 1);
ini_set('error_reporting', E_ALL | E_STRICT);

$listing = isset($_POST['listing'])?$_POST['listing']:'';
$separ = isset($_POST['separ'])?$_POST['separ']:'';

$listing = utf8_encode($listing);

$L = explode("\n",$listing);

$apercu="<table id='apercu' style='border-width:1px;margin-left:auto;margin-right:auto'>
<tr><td>Point</td><td>X</td><td>Y</td><td>désignation</td></tr>";

$ktmax=min(5,count($L));


for($i=0;$i<$ktmax-1;$i++){
	if ($L[$i]!=''){

		$champ = explode($separ,$L[$i]);
		$apercu .= '<tr><td>'.substr($champ[0],0,6).'</td><td ';
		if (!$champ[1]){$apercu .= "style=\"background-color:#FF8D8D\"";}
		$apercu .= ' >';
		if (!$champ[1]){ $apercu .= "<strong>probème séparateur !</strong>";} else {$apercu .=number_format($champ[1],2,".","");}
		$apercu .='</td><td ';
		if (!$champ[2]){$apercu .= "style=\"background-color:#FF8D8D\"";}
		$apercu .=' >';
		if (!$champ[2]){ $apercu .= "<strong>probème séparateur !</strong>";} else {$apercu .= number_format($champ[2],2,".","");}
		$apercu .='</td><td ';
		if (!$champ[3]){ $apercu .= "style=\"background-color:#FF8D8D\"";}
		$apercu .=' >';
		if (!$champ[3]){ $apercu .= "<strong>probème séparateur !</strong>";} else {$apercu .= substr($champ[3],0,14);}
		$apercu .='</td></tr>';
		$k++;

	}
}

$k=0;

for($i=0;$i<count($L);$i++){
	if ($L[$i]!=''){
		$k++;
	
	}
}

$apercu .= '<tr><td>...</td><td>...</td><td>...</td><td>...</td></tr>';
$apercu.="</table>";

echo "<hr>Aperçu : <br /><br />";
echo $apercu;
echo "<br />(".$k." points topo)<br />";

?>