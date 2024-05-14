<?php
// appelé par index.php, renvoi le separateur avec le plus d'occurrences dans le bouton auto

//include 'get-separ-topo-commun.php';

ini_set('display_error', 1);
ini_set('error_reporting', E_ALL | E_STRICT);

$listing = isset($_POST['listing'])?$_POST['listing']:'';
$radio_check = isset($_POST['radio_check'])?$_POST['radio_check']:'';

$listing = utf8_encode($listing);

$PV = explode(";",$listing);
$V = explode(",",$listing);
$TAB = explode("\t",$listing);//tab
$SPC = explode(" ",$listing);

$max=max(count($PV),count($V),count($TAB),count($SPC));

switch ($max) {

	case 1 :
		$separateur = "inconnu";
		$separ_val= "inconnu";
		break;
	case count($PV) :
		$separateur = ";";
		$separ_val= ";";
		break;
	case count($V) :
		$separateur = ",";
		$separ_val= ",";
		break;		
	case count($TAB) :
		$separateur = "tab";
		$separ_val= "\t";
		break;		
	case count($SPC) :
		$separateur = "espace";
		$separ_val= " ";
		break;		
	default :
	

}

$html= '<input type="radio" id="separ_topo_auto" name="separ_topo" value="'.$separ_val.'" onchange="apercuTopo();"  title="auto parmi point-virgule/virgule/espace/tabulation" ';

if ($radio_check==1){
	$html.='  checked';
}

$html.= '>
			<label id="label_separ_topo_auto" for="separ_topo_auto"  title="auto parmi point-virgule/virgule/espace/tabulation" >auto ['.$separateur.']</label>';

echo $html;
?>