<?php
// appelé par index.php

ini_set('display_error', 1);
ini_set('error_reporting', E_ALL | E_STRICT);

$listing = isset($_POST['listing'])?$_POST['listing']:'';
//$separ = isset($_POST['separ'])?$_POST['separ']:'';
$separ = ";";

$listing = utf8_encode($listing);

$L = explode("\n",$listing);

$apercu="<table id='apercu' style='width:450px;border-width:1px;margin-left:auto;margin-right:auto'>
<tr><td>Société</td><td>Nom</td><td>Section</td><td>Numéro</td><td>Statut</td></tr>"; // new 12-11-2022 Statut


//for($i=0;$i<count($L);$i++){
//	if ($L[$i]!=''){
//
//		$champ = explode(";",$L[$i]);
//		if (strlen($champ[0])>12){$pppsoc="...";} else {$pppsoc="";}
//		if (strlen($champ[2])>10){$pppnom="...";} else {$pppnom="";}
//		$apercu .= '<tr><td>'.substr($champ[0],0,12).$pppsoc.'</td><td>'.substr($champ[2],0,10).$pppnom.'</td><td>'.$champ[14].'</td><td>'.$champ[15].'</td></tr>';
//
//	}
//}

$k=0;

for($i=0;$i<count($L);$i++){
	if ($L[$i]!=''){
		$k++;
		$champ = explode($separ,$L[$i]);
		
		if (count($champ)<48) {
			$champ2 = explode($separ,$L[$i+1]);
			$champ3 = explode($separ,$L[$i+2]);
			if (count($champ)+count($champ2)==49) { //cas d'une adresse scindée en 2
				$M=array();
				$M[]=$L[$i];
				$M[]=$L[$i+1];
				$N=implode("- ",$M); //champs réassociés scindés par virgule
				$champ = explode($separ,$N);
				$i++; // pour sauter la ligne suivante
			}
			if (count($champ)+count($champ2)+count($champ3)==50) { //cas d'une adresse scindée en 3
				$M=array();
				$M[]=$L[$i];
				$M[]=$L[$i+1];
				$M[]=$L[$i+2];				
				$N=implode("- ",$M); //champs réassociés scindés par virgule
				$champ = explode($separ,$N);
				$i++; // pour sauter la ligne suivante
				$i++; // pour sauter la 2eme ligne suivante
			}			
		
		}
		
		if (strlen($champ[0])>12){$pppsoc="...";} else {$pppsoc="";}
		if (strlen($champ[2])>10){$pppnom="...";} else {$pppnom="";}
		$apercu .= '<tr><td>'.substr($champ[0],0,12).$pppsoc.'</td><td ';
		if (!$champ[2]){$apercu .= "style=\"background-color:#FF8D8D\"";}
		$apercu .= ' >';
		if (!$champ[2]){ $apercu .= "<strong>vide !</strong>";} else {$apercu .= substr($champ[2],0,10).$pppnom;}
		$apercu .= '</td><td ';
		if (!$champ[14]){$apercu .= "style=\"background-color:#FF8D8D\"";}
		$apercu .= ' >';
		if (!$champ[14]){ $apercu .= "<strong>vide !</strong>";} else {$apercu .= $champ[14];}		
		$apercu .= '</td><td ';
		if (!$champ[15]){$apercu .= "style=\"background-color:#FF8D8D\"";}
		$apercu .= ' >';
		if (!$champ[15]){ $apercu .= "<strong>vide !</strong>";} else {$apercu .= $champ[15];}
		$apercu .= '</td><td '; //new 12-11-2022
		if (!$champ[10]){$apercu .= "style=\"background-color:#FF8D8D\"";}//new 12-11-2022
		$apercu .= ' >';//new 12-11-2022
		if (!$champ[10]){ $apercu .= "<strong>vide !</strong>";} else {$apercu .= $champ[10];}		//new 12-11-2022
		$apercu .= '</td></tr>';
		
	}
}


$apercu.="</table>";

echo "<hr>Aperçu : <br /><br />";
echo $apercu;
echo "<br />(".($k)." intervenants) <br />";


?>