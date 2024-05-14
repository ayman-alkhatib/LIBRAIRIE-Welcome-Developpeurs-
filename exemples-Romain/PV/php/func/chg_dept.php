<?php
// appelé par index.php

ini_set('display_error', 1);
ini_set('error_reporting', E_ALL | E_STRICT);

$GE = isset($_POST['GE'])?$_POST['GE']:'';

switch(substr($GE,2,5)){
	case "06176"; //Romain
		echo "d'INDRE-ET-LOIRE";
		break;
	case "06177"; //David
		echo "d'INDRE-ET-LOIRE";
		break;		
	case "06155"; //Laurence
		echo "des DEUX-SEVRES";
		break;				
	case "06283"; // Valentin
		echo "de la VIENNE";
		break;
	case "05276"; // William
		echo "de MAINE-ET-LOIRE";
		break;
	case "06564"; // Louis-Marie
		echo "de MAINE-ET-LOIRE";
		break;				
}

?>