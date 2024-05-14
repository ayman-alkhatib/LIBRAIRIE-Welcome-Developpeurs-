<?php
// appelé par index.php

ini_set('display_error', 1);
ini_set('error_reporting', E_ALL | E_STRICT);

$GE = isset($_POST['GE'])?$_POST['GE']:'';

switch(substr($GE,2,5)){
	case "06176"; //Romain
		echo '<option value="LOCHES">LOCHES</option>';
		echo '<option value="MONTLOUIS-SUR-LOIRE">MONTLOUIS</option>';
		break;
	case "06177"; //David
		echo '<option value="CHINON">CHINON</option>';
		break;		
	case "06155"; //Laurence
		echo '<option value="BRESSUIRE">BRESSUIRE</option>';
		break;				
	case "06283"; // Valentin
		echo '<option value="POITIERS">POITIERS</option>';
		break;
	case "05276"; // William
		echo '<option value="SAUMUR">SAUMUR</option>';
		break;
	case "06564"; // Louis-Marie
		echo '<option value="SAUMUR">SAUMUR</option>';
		break;				
}

?>