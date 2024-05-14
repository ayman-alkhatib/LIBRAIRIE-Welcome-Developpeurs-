<?php
// appelé par index.php

ini_set('display_error', 1);
ini_set('error_reporting', E_ALL | E_STRICT);

$GE = isset($_POST['GE'])?$_POST['GE']:'';

switch(substr($GE,2,5)){
	case "06176"; //Romain
		echo '<option value="M. Romain AUGER">Romain</option>';
		echo '<option value="Mme Elise PERROUAULT">Elise</option>';		
		echo '<option value="M. Gaylord DECARSIN">Gaylord</option>';		
		echo '<option value="M. Julien PETIT">Julien</option>';		
		break;
	case "06177"; //David
		echo '<option value="M. David BACHELLIER">David</option>';
		echo '<option value="M. Antoine VENTROUX">Antoine</option>';		
		echo '<option value="Mme Pauline DEVAUX">Pauline</option>';		
		echo '<option value="M. Louis FOUQUET">Louis</option>';	
		break;		
	case "06155"; //Laurence
		echo '<option value="Mme Laurence BAZANTAY">Laurence</option>';
		echo '<option value="M. Etienne HUCAULT">Etienne</option>';		
		echo '<option value="M. Gaël JOSELON">Gaël</option>';		
		echo '<option value="Mme Mélanie BENOIST">Mélanie</option>';				
		break;				
	case "06283"; // Valentin
		echo '<option value="M. Valentin BODET">Valentin</option>';
		echo '<option value="M. Thibault HENAULT">Thibault</option>';		
		echo '<option value="Mme Mélanie BENOIST">Mélanie</option>';	
		echo '<option value="M. Quentin DUPAS">Quentin</option>';		
		echo '<option value="M. Alexis BOISLIVEAU">Alexis</option>';			
		echo '<option value="M. Raphaël BRUNET">Raphaël</option>';
		break;
	default : // SAUMUR - William et Louis-Marie
	case "05276"; // William
		echo '<option value="M. William BRANLY">William</option>';		
		echo '<option value="Mme Clémence BOCHE">Clémence</option>';	
		echo '<option value="M. Alexis FOUCAULT">Alexis</option>';	
		echo '<option value="M. Jhon CONTANT">Jhon</option>';		
		break;
	case "06564"; // Louis-Marie
		echo '<option value="M. Louis-Marie NAULIN">Louis-Marie</option>';		
		echo '<option value="Mme Clémence BOCHE">Clémence</option>';	
		echo '<option value="M. Alexis FOUCAULT">Alexis</option>';	
		echo '<option value="M. Jhon CONTANT">Jhon</option>';	
		break;				
}

?>