<?php 

switch ($doss_tech){
	case "M. Romain AUGER":
		$controle_responsable = "j'ai" ;  //GE
		break;
	case "M. David BACHELLIER":
		$controle_responsable = "j'ai" ;  //GE
		break;		
	case "Mme Laurence BAZANTAY":
		$controle_responsable = "j'ai" ;  //GE
		break;		
	case "M. Valentin BODET":
		$controle_responsable = "j'ai" ;  //GE
		break;		
	case "M. William BRANLY":
		$controle_responsable = "j'ai" ;  //GE
		break;		
	case "M. Louis-Marie NAULIN":
		$controle_responsable = "j'ai" ;  //GE
		break;		
	case "Mme Elise PERROUAULT":
		$controle_responsable = "sous mon contrôle et ma responsabilité, ".$doss_tech.", technicienne géomètre, a";
		break;
	case "Mme Pauline DEVAUX":
		$controle_responsable = "sous mon contrôle et ma responsabilité, ".$doss_tech.", ingénieure, Géomètre-Experte stagiaire, a";
		break;
	case "Mme Mélanie BENOIST":
		$controle_responsable = "sous mon contrôle et ma responsabilité, ".$doss_tech.", technicienne géomètre, a";
		break;
	case "Mme Clémence BOCHE":
		$controle_responsable = "sous mon contrôle et ma responsabilité, ".$doss_tech.", technicienne géomètre, a";
		break;		
	default:
		$controle_responsable = "sous mon contrôle et ma responsabilité, ".$doss_tech.", technicien géomètre, a";  // par défaut : technicien homme
}

?>