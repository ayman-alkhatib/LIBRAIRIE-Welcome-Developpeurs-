<?php 
// appelé par index.php pour génération des PV  à partir de modèle .odt (aussi appelés template)

//-----------RECUPERATION DONNEES FORMULAIRE------------


$doss_num = $_POST['doss_num']?:"dossXXXX";

if($_POST["doss_GE"]!=""){
$doss_ge = substr($_POST['doss_GE'],8);
$doss_genum = substr($_POST['doss_GE'],2,5);
$femge = feminize_GE($_POST['doss_GE']);
} else {
	$doss_ge="XXXXXXXX";
	$doss_genum="XXXXX";
}
$doss_bureau = $_POST['doss_bureau']?:"XXXXXX";

$doss_tech = $_POST['doss_tech']?:"XXXX";


$doss_dept = $_POST['doss_dept']?:"XXXXXXX";

$doss_comm = $_POST['doss_comm']?:"XXXXXXX";


$doss_decomm = de_commune($doss_comm);

$doss_acomm = a_commune($doss_comm);


$doss_lieu = $_POST['doss_lieu']?:"lieuXXX";

$doss_sect = $_POST['doss_sect']?:"sectXXX";

$doss_parc = $_POST['doss_parc']?:"parcXXX";

$doss_date = $_POST['doss_date']?:"dateXXX";


$doss_demandeur = $_POST['doss_demandeur']?:"demandeurXXX";

$doss_voiepub = $_POST['doss_voiepub']?:"voieXXX";

$doss_voieferree = $_POST['doss_voieferree']?:"voieferreeXXX";

$temp_intervenants = $_POST['temp_intervenants']?:"intervXXX";


$pts_init = $_POST['pts_init']?:"";

$septopo = $_POST['separ_topo']?:";";

//---------FONCTIONS----------

function feminize_GE($ge) { //retourne un "e" si le GE est une femme d'après le genre dans l'option : M ou F

	switch (substr($ge,0,1)) {
		case "F" :
			$res="e";
			break;
		default :
			$res="";		
	}

	return $res;
}

//-----------------------------------

function de_commune($decommune) { //retourne "de Commune" en gérant les communes commencant par "LE" "LES"
	switch (strtoupper(substr($decommune,0,3))) {
		case "LE ": // cas "le"
			$res="du ".substr($decommune,3);
			break;
		default : 
			switch (strtoupper(substr($decommune,0,4))) {
				case "LES ": // cas "les"
					$res="des ".substr($decommune,4);
					break;
				default : // cas autres
					//$res="de ".$decommune;
					switch (strtoupper(substr($decommune,0,1))) {
						case "A": // cas 1ere lettre voyelle A E I O U Y
							$res="d'".$decommune;
							break;
						case "E": 
							$res="d'".$decommune;
							break;
						case "I": 
							$res="d'".$decommune;
							break;		
						case "O": 
							$res="d'".$decommune;
							break;								
						case "U": 
							$res="d'".$decommune;
							break;		
						case "Y": 
							$res="d'".$decommune;
							break;									
						default : // cas autres
							$res="de ".$decommune; // commune ne commencant ni par "LE" ni par "LES" ni par une voyelle
					}
					
			}
	}
	return $res;
}

function a_commune($acommune) { //retourne "à Commune" en gérant les communes commencant par "LE" "LES"
	switch (strtoupper(substr($acommune,0,3))) {
		case "LE ": // cas "le"
			$res="au ".substr($acommune,3);
			break;
		default : 
			switch (strtoupper(substr($acommune,0,4))) {
				case "LES ": // cas "les"
					$res="aux ".substr($acommune,4);
					break;
				default : // cas autres
					$res="à ".$acommune;
					
			}
	}
	return $res;
}

//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------

function design_interv($interv) { //retourne le paragraphe désignation, acte ... gère Société M. et Mme, parcelle ou parcelles 
	$champ_temp = explode(";",$interv);
	switch ($champ_temp[5]) { // modif 2023-04-24 (5)
		case "": // cas particulier
			$res=design_interv_part($interv);
			break;
		default : // cas societe
			$res=design_interv_societe($interv);
			break;		
	}
	return $res;
}

function design_interv_societe($interv) { //retourne le paragraphe désignation, acte ... pour une société 
	$champ_temp = explode(";",$interv);
	switch (substr(strtoupper($champ_temp[5]),0,6)) { // REMPLACE MAIRIE PAR COMMUNE -- modif 2023-04-24 (5)
		case "MAIRIE":
			$champ_temp[5]="Commune".substr($champ_temp[5],6); // modif 2023-04-24 (5)
		default :
	}
	
	$res = $champ_temp[5].", représentée par ".$champ_temp[2]." ".$champ_temp[3]." ".$champ_temp[4].", immatriculation SIREN n°XXXXXXXXX, domiciliée ".$champ_temp[58].", ".$champ_temp[57]." ".$champ_temp[7]."\r";//société, représentée par -- // modif 2023-04-24 
	$res .= type_pptr($interv)." ".multi_parc($interv)." ".$champ_temp[8]." n°".$champ_temp[9]." (".$champ_temp[54]."),\r";//proprietaire de section parcelle (commune) --// modif 2023-04-24
	$res .= "au regard de l’acte de ".($champ_temp[28]?:"vente")." reçu le ".($champ_temp[29]?:"XX/XX/XXXX")." par Me ".($champ_temp[30]?:"XXXX").", notaire à ".($champ_temp[31]?:"XXXX").", publié au service de la publicité foncière de ".($champ_temp[34]?:"XXXX").($champ_temp[33]?(" ".$champ_temp[40]):"")." le ".($champ_temp[32]?:"XX/XX/XXXX").", volume ".($champ_temp[35]?:"XXXX")." n°".($champ_temp[36]?:"XXXX").".\r";// // modif 2023-04-24 (5)
	$res .= "OU : en l'absence de formalité publiée, suivant la matrice cadastrale, sans présentation d'acte.\r";//
	return $res;	
}

function design_interv_part($interv) { //retourne le paragraphe désignation, acte ... pour un particulier
	$champ_temp = explode(";",$interv);

	switch(test_epoux($interv)){ //inutile depuis modif SPDC mai 2022
		case true :
			$res="M.";
			break;
		default :
			$res=$champ_temp[2]; // modif 2023-04-24
	}
	
	$res .= " ".$champ_temp[3]." ".$champ_temp[4].", né".feminize($interv); // modif 2023-04-24
	if ($champ_temp[23]!="") { $res .= " ".$champ_temp[23];} // nom de naissance // modif 2023-04-24
	$res .=" le ".$champ_temp[15]." ".a_commune($champ_temp[16]).",\r"; // modif 2023-04-24
	
	if ($champ_temp[26]!=""){$res .= "et Mme ".$champ_temp[26].", née ".$champ_temp[23]." le ".$champ_temp[24]." ".a_commune($champ_temp[25]).",\r";} // champ[28] NE MARCHE PLUS DEPUIS MAJ SPDC EN MAI 2022, modif 12-11-2022, avant : " à ".$champ_temp[31]." // modif 2023-04-24
	
	$res .= "demeurant ".$champ_temp[58].", ".$champ_temp[57]." ".$champ_temp[7].",\r";//adresse // modif 2023-04-24
	$res .= type_pptr($interv)." ".multi_parc($interv)." ".$champ_temp[8]." n°".$champ_temp[9]." (".$champ_temp[54]."),\r";//proprietaire de section parcelle (commune) // modif 2023-04-24
	$res .= "au regard de l’acte de ".($champ_temp[28]?:"vente")." reçu le ".($champ_temp[29]?:"XX/XX/XXXX")." par Me ".($champ_temp[30]?:"XXXX").", notaire à ".($champ_temp[31]?:"XXXX").", publié au service de la publicité foncière de ".($champ_temp[34]?:"XXXX").($champ_temp[33]?(" ".$champ_temp[33]):"")." le ".($champ_temp[32]?:"XX/XX/XXXX").", volume ".($champ_temp[35]?:"XXXX")." n°".($champ_temp[36]?:"XXXX").".\r";// // modif 2023-04-24
	$res .= "OU : en l'absence de formalité publiée, suivant la matrice cadastrale, sans présentation d'acte.\r";//
	
	return $res;
}

//NOUVEAU 18/06/2022 Nom en gras, acte en italique

function interv_nom($interv) { //retourne le nom ... gère Société M. et Mme, parcelle ou parcelles 
	$champ_temp = explode(";",$interv);
	switch ($champ_temp[5]) { // modif 2023-04-24
		case "": // cas particulier
			$res=interv_nom_part($interv);
			break;
		default : // cas societe
			$res=interv_nom_societe($interv);
			break;		
	}
	return $res;
}

//-------

function interv_nom_societe($interv) { //retourne le nom ... pour une société 
	$champ_temp = explode(";",$interv);
	switch (substr(strtoupper($champ_temp[5]),0,6)) { // REMPLACE MAIRIE PAR COMMUNE // modif 2023-04-24
		case "MAIRIE":
			$champ_temp[5]="Commune".substr($champ_temp[5],6); // modif 2023-04-24
		default :
	}
	$res = $champ_temp[5].", "; //société,  // modif 2023-04-24
	return $res;	
}

//-------

function interv_nom_part($interv) { //retourne le nom ... pour un particulier
	$champ_temp = explode(";",$interv);

	$res=$champ_temp[2]; // modif 2023-04-24
	$res .= " ".$champ_temp[3]." ".$champ_temp[4].", "; // modif 2023-04-24
	
	return $res;
}

//--------

function interv_details($interv) { //retourne les détails ... gère Société M. et Mme, parcelle ou parcelles 
	$champ_temp = explode(";",$interv);
	switch ($champ_temp[5]) { // modif 2023-04-24
		case "": // cas particulier
			$res=interv_details_part($interv);
			break;
		default : // cas societe
			$res=interv_details_societe($interv);
			break;		
	}
	return $res;
}

//------------

function interv_details_societe($interv) { //retourne les détails ... pour une société 
	$champ_temp = explode(";",$interv);
	$res = "représentée par ".$champ_temp[2]." ".$champ_temp[3]." ".$champ_temp[4].", immatriculation SIREN n°XXXXXXXXX, domiciliée ".$champ_temp[58].", ".$champ_temp[57]." ".$champ_temp[7]."\r";//société, représentée par // modif 2023-04-24
	$res .= type_pptr($interv)." ".multi_parc($interv)." ".$champ_temp[8]." n°".$champ_temp[9]." (".$champ_temp[54]."),";//proprietaire de section parcelle (commune)  // modif 2023-04-24
	return $res;	
}

//-----------

function interv_details_part($interv) { //retourne détails ... pour un particulier
	$champ_temp = explode(";",$interv);

	$res ="né".feminize($interv);
	if ($champ_temp[13]!="") { $res .= " ".$champ_temp[13];} // nom de naissance // modif 2023-04-24
	$res .=" le ".$champ_temp[15]." à ".$champ_temp[16].",\r"; // modif 2023-04-24
	$res .= "demeurant ".$champ_temp[58].", ".$champ_temp[57]." ".$champ_temp[7].",\r";//adresse  // modif 2023-04-24
	$res .= type_pptr($interv)." ".multi_parc($interv)." ".$champ_temp[8]." n°".$champ_temp[9]." (".$champ_temp[54]."),";//proprietaire de section parcelle (commune) // modif 2023-04-24
	
	return $res;
}





//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------

function type_pptr($interv) { // retourne le paragraphe désignation, acte ... gère Société M. et Mme, parcelle ou parcelles 
	$champ_temp = explode(";",$interv);

	switch (substr($champ_temp[6],-4)) { // regarde les 4 dernieres lettres du statut  // modif 2023-04-24
			case "(Nu)" : // nu-pptr
				$res = "Nu".feminize($interv).multi_pptr($interv)."-propriétaire".multi_pptr($interv);
				break;
			case "suf)" : // usufruitier		
				$res= "Usufruiti".feminize_usuf($interv).multi_pptr($interv);
				break;
			case "ivis" : // indivis
				$res= "Propriétaire".multi_pptr($interv)." indivis".feminize($interv); 
				break;
			default : // propriétaire TP
				$res= "Propriétaire".multi_pptr($interv);
	}

  return $res;
}

function multi_parc($interv) { // retourne "de la parcelle" ou "des parcelles" 
	$champ_temp = explode(";",$interv);
	$champ_parc = explode(" ",$champ_temp[9]);// crée une array avec les parcelles puis les compte // modif 2023-04-24
	switch (count($champ_parc)) { 
			case 0 : // liste parcelle vide
				$res = "LISTE PARCELLES VIDE !!!";
				break;
			case 1 : // liste parcelle vide
				$res = "de la parcelle";
				break;
			default : // propriétaire TP
				$res= "des parcelles";
	}
	return $res;
}

function multi_pptr($interv) { // retourne un "s" si plusieurs propriétaires d'après $champ_temp[28]
	$champ_temp = explode(";",$interv);
	switch ($champ_temp[26]) { // champ[28] NE MARCHE PLUS DEPUIS MAJ SPDC EN MAI 2022 // modif 2023-04-24
			case "" : // personne dans le $champ_temp[28]
				$res="";
				break;
			default : // quelqu'un dans le $champ_temp[28]
				$res="s";		
	}
	return $res;
}

//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------

function feminize($interv) { //retourne un "e" si l'intervenant est une femme d'après le genre dans champ_temp[1] (hors société)
	$champ_temp = explode(";",$interv);
	if (!test_societe($interv)) { //pas de féminisation si société représentée par une femme 
		switch ($champ_temp[2]) { // modif 2023-04-24
			case "Mme" :
				$res="e";
				break;
			default :
				$res="";		
		}
	} else {
		$res="";	
	}
	return $res;
}

function feminize_usuf($interv) { //retourne un "ère" si l'intervenant est une femme d'après le genre dans champ_temp[1] (hors société), "er" sinon
	$champ_temp = explode(";",$interv);
	if (!test_societe($interv)) { //pas de féminisation si société représentée par une femme
		switch ($champ_temp[2]) { // modif 2023-04-24
			case "Mme" :
				$res="ère";
				break;
			default :
				$res="er";		
		}
	} else {
		$res="er";	
	}
	return $res;
}

function test_societe($interv) { //retourne "true" si intervenant = société, false sinon, d'après $champ_temp[0]
	$champ_temp = explode(";",$interv);
	switch ($champ_temp[5]) { // modif 2023-04-24
			case "" :
				$res=false;
				break;
			default :
				$res=true;		
	}
	return $res;
}

function test_epoux($interv) { //retourne "true" si qqn dans $champ_temp[28]
	$champ_temp = explode(";",$interv);
	switch ($champ_temp[26]) { // champ[28] NE MARCHE PLUS DEPUIS MAJ SPDC EN MAI 2022 // modif 2023-04-24
			case "" :
				$res=false;
				break;
			default :
				$res=true;		
	}
	return $res;
}

function convoc($interv) { //retourne la ligne de convocation, gère société, M. et Mme 
	$champ_temp = explode(";",$interv);
	switch ($champ_temp[5]) { // modif 2023-04-24
		case "": // cas particulier
			$res="- ".$champ_temp[2]." ".$champ_temp[3]." ".$champ_temp[4]."\r";// M et Mme XXXX // modif 2023-04-24
			break;
		default : // cas societe
			switch (substr(strtoupper($champ_temp[5]),0,6)) { // REMPLACE MAIRIE PAR COMMUNE // modif 2023-04-24
				case "MAIRIE":
					$champ_temp[5]="Commune".substr($champ_temp[5],6); // modif 2023-04-24
				default :
			}
			$res="- ".$champ_temp[5]."\r";// - société // modif 2023-04-24
			break;		
	}
	return $res;
}

//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------

function bloc_pptr($interv) { //retourne un string pptr 
	$champ_temp = explode(";",$interv);
	switch ($champ_temp[5]) { // modif 2023-04-24
		case "": // cas particulier
			$res=bloc_pptr_part($interv);
			break;
		default : // cas societe
			$res=bloc_pptr_societe($interv);
			break;		
	}
	return $res;
}

function bloc_pptr_societe($interv) { //retourne le nom pptr ... pour une société 
	$champ_temp = explode(";",$interv);
	switch (substr(strtoupper($champ_temp[5]),0,6)) { // REMPLACE MAIRIE PAR COMMUNE  // modif 2023-04-24
		case "MAIRIE":
			$champ_temp[5]="Commune".substr($champ_temp[5],6); // modif 2023-04-24
		default :
	}
	$res = $champ_temp[5];// - société  // modif 2023-04-24
	return $res;	
}

function bloc_pptr_part($interv) { //retourne le nom pptr ... pour un particulier (cas époux géré au niveau supérieur)
	$champ_temp = explode(";",$interv);
	//switch ($champ_temp[26]) { // retourne genre ou M. seulement si epoux // champ[28] NE MARCHE PLUS DEPUIS MAJ SPDC EN MAI 2022  // modif 2023-04-24
	//		case "" :
	//			$res=$champ_temp[2]." ".$champ_temp[3]." ".$champ_temp[4]; // modif 2023-04-24
	//			break;
	//		default :
	//			$res="M. ".$champ_temp[3]." ".$champ_temp[4];	// modif 2023-04-24
	//}	
	$res=$champ_temp[2]." ".$champ_temp[3]." ".$champ_temp[4];
	return $res;	
}

//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------

function is_soc($interv) { //retourne true ou false si societe / particulier
	$champ_temp = explode(";",$interv);
	switch ($champ_temp[5]) {  // modif 2023-04-24
		case "": // cas particulier
			$res=false;
			break;
		default : // cas societe
			$res=true;
			break;		
	}
	return $res;
}



function bloc_parc($interv) { //retourne un string pptr 
	$champ_temp = explode(";",$interv);
	switch ($champ_temp[5]) {  // modif 2023-04-24
		case "": // cas particulier
			$res=bloc_parc_part($interv);
			break;
		default : // cas societe
			$res=bloc_parc_societe($interv);
			break;		
	}
	return $res;
}

function bloc_parc_societe($interv) { //retourne array comm section parc lieudit pptr ... pour une société 
	$champ_temp = explode(";",$interv);
	switch (substr(strtoupper($champ_temp[5]),0,6)) { // REMPLACE MAIRIE PAR COMMUNE  // modif 2023-04-24
		case "MAIRIE":
			$champ_temp[5]="Commune".substr($champ_temp[5],6); // modif 2023-04-24
		default :
	}
	$res = array('commune'=>$champ_temp[54],'section'=>$champ_temp[8], 'parcelle'=>$champ_temp[9], 'lieudit'=>$champ_temp[60], 'pptr'=>$champ_temp[5]);//pour tableau de parcelles // modif 2023-04-24
	return $res;	
}

function bloc_parc_part($interv) { //retourne array comm section parc lieudit pptr ... pour un particulier
	$champ_temp = explode(";",$interv);
	if ($champ_temp[26]!=""){ // champ[28] NE MARCHE PLUS DEPUIS MAJ SPDC EN MAI 2022  // modif 2023-04-24
		$mme=" et Mme";
	} else {
		$mme="";
	}
	$res = array('commune'=>$champ_temp[54],'section'=>$champ_temp[8], 'parcelle'=>$champ_temp[9], 'lieudit'=>$champ_temp[60], 'pptr'=>$champ_temp[2].$mme." ".$champ_temp[3]." ".$champ_temp[4]); // modif 2023-04-24
	return $res;	
}


function existence_parc($comm,$sect,$parc,$liste_parc) { // recherche dans bloc_parc[] si la parcelle existe déjà
	$knt=0;
	for($i=0;$i<count($liste_parc);$i++){
		if ($liste_parc[$i]['commune']==$comm && $liste_parc[$i]['section']==$sect && $liste_parc[$i]['parcelle']==$parc ) {
			$knt++;
		}
	}
	if ($knt!=0) {
		$res = true;
	} else {
		$res = false;
	}
	return $res;	
}

function index_parc($comm,$sect,$parc,$liste_parc) { // retourne l'index de bloc_parc[] correspondant à cette parcelle
	for($i=0;$i<count($liste_parc);$i++){
		if ($liste_parc[$i]['commune']==$comm && $liste_parc[$i]['section']==$sect && $liste_parc[$i]['parcelle']==$parc ) {
			return $i;
		}
	}
}

//-------------------------------------------------------------------------------------
//         FONCTIONS  POUR  TABLEAU DES DISTANCES
//-------------------------------------------------------------------------------------

function DisTopo($xa,$ya,$xb,$yb) { 
	$xa=floatval($xa); // convertit les arguments en nombre décimaux
	$ya=floatval($ya);	
	$xb=floatval($xb);	
	$yb=floatval($yb);	
	
	$res = sqrt( pow($xa-$xb,2) + pow($ya-$yb,2) );// distance de A à B
	return number_format($res,2,".","");	// resultat sous la forme 1000.00
}

function m_de($dist) {
	list($int,$dec)=explode('.', $dist);
	$a = new NumberFormatter("fr", NumberFormatter::SPELLOUT);
	$res = $a->format($int);
	switch ($res){
		case "zéro" :
			$res .= " mètre";
			break;
		case "un" :
			$res .= " mètre";
			break;
		default :
			$res .= " mètres";
	}
	return $res;
}

function cm_de($dist) {
	list($int,$dec)=explode('.', $dist);
	$a = new NumberFormatter("fr", NumberFormatter::SPELLOUT);
	$res = $a->format($dec);
	switch ($res){
		case "zéro" :
			$res .= " centimètre";
			break;
		case "un" :
			$res .= " centimètre";
			break;
		default :
			$res .= " centimètres";
	}	
	return $res;
}
//----------------------------------

$Ptappui= array();
$PtappuiLignes= array();

$blk_termes_nouv = array(); //termes de limite nouveaux
$blk_termes_reco = array(); //termes de limite anciens
$limite = ""; // limite sous la forme A (borne nouvelle) - B (borne ancienne) - C ()

$PtappuiLignesInit = explode("\r\n",$pts_init); //
$PtAppuiDesign ="";

for($i=0;$i<count($PtappuiLignesInit);$i++){
	
		$champAppui = explode($septopo,$PtappuiLignesInit[$i]);//
			if( !is_numeric($champAppui[0]) && strpos($champAppui[0],".")==false && count($champAppui)!=1 ){  // test Lettres seuls et pas C.1 S.1 R.1
				$PtappuiLignes[]=$PtappuiLignesInit[$i];
				$limite .= " ".$champAppui[0]." (".str_replace('\r', '', $champAppui[3])."),";  //pour description LIMITE
				//pour description points de limite et LIMITE
				$PtAppuiDesign = str_replace('\r', '', $champAppui[3]); // ajout 03/03/2023

				if (str_contains($PtAppuiDesign,'nouv') || str_contains($PtAppuiDesign,'clou') || str_contains($PtAppuiDesign,'spit') ){ // ajout 03/03/2023

					if (str_contains($PtAppuiDesign,'ancien')){
						$blk_termes_reco[] = array('nom'=>"- ".$champAppui[0]." : ".$PtAppuiDesign.","); // exemple "clou ancien"
					} else {
						$blk_termes_nouv[] = array('nom'=>"- ".$champAppui[0]." : ".$PtAppuiDesign.",");
					}
					
				} else {
					$blk_termes_reco[] = array('nom'=>"- ".$champAppui[0]." : ".$PtAppuiDesign.",");
				}
				//$blk_termes_nouv[] = array('nom'=>"- ".$champAppui[0]." : ".str_replace('\r', '', $champAppui[3]).","); 
				//$blk_termes_reco[] = array('nom'=>"- ".$champAppui[0]." : ".str_replace('\r', '', $champAppui[3]).","); 			
			} 
	
}

//--------------AJOUT INTRO SUR TERMES DE LIMITES---------------

$introNouv = ""; // mention "Le repère nouveau suivant OU Les repères nouveaux suivants
$introReco = ""; // mention "Le repère ancien ou le terme de limite suivant OU Les repères anciens ou les termes de limite suivants

switch (count($blk_termes_nouv)) {
	case 0 : // aucun repère nouveau
		$introNouv="Aucun repère nouveau n'a été implanté."; 
		break;
	case 1 : // cas d'un repère nouveau
		$introNouv="Le repère nouveau suivant a été implanté :"; 
		break;
	default : // cas de plusieurs repères nouveaux
		$introNouv="Les repères nouveaux suivants ont été implantés :"; 
		break;
}

switch (count($blk_termes_reco)) {
	case 0 : // aucun repère ancien
		break;
	case 1 : // cas d'un repère ancien - terme de limite
		$introReco ="Le repère ancien / le terme de limite suivant a été reconnu :"; 
		break;
	default : // cas de plusieurs repères anciens - termes de limite
		$introReco ="Les repères anciens / les termes de limite suivants ont été reconnus :"; 
		break;
}




//------------

switch (count($PtappuiLignes)){ //FIN description LIMITE
	case 1:
		$limite = "le point ".$limite;
		break;
	case 2:
		$limite = "le segment ".$limite;
		break;
	default :
		$limite = "la ligne brisée ".$limite;		
}

//------------- TABLEAU DES DISTANCES

if (count($PtappuiLignes)<2) {
		$ListeAppuis[]=array('nom'=>"",'distance'=>"",'distm'=>"",'distcm'=>""); // cas d'un seul point de limite
		$ListeClotures[]=array('designation'=>"- La clôture ...... est rattachée à la propriété de ".$doss_demandeur." (".$doss_sect." n°".$doss_parc.")");
		
} else {
	for($i=0;$i<count($PtappuiLignes);$i++){
		$champAppui = explode($septopo,$PtappuiLignes[$i]); //   MODIF 08/06/2022          $champAppui = explode(";",$PtappuiLignes[$i]);
	
// test point ni un numéro ni ref du type C.1, S.1, R.1
		$Ptappui[]=array('point'=>$champAppui[0], 'coordx'=>$champAppui[1], 'coordy'=>$champAppui[2], 'designation'=>$champAppui[3]);
	}
}

if (count($PtappuiLignes)>1) {
	for($i=0;$i<count($PtappuiLignes);$i++){	

		switch ($i){
			case count($PtappuiLignes)-1: // boucle entre le dernier point et le premier point
				if (count($PtappuiLignes)>2) {
					$distance=DisTopo($Ptappui[0]['coordx'],$Ptappui[0]['coordy'],$Ptappui[$i]['coordx'],$Ptappui[$i]['coordy']);
					$ListeAppuis[]=array('nom'=>$Ptappui[$i]['point']." - ".$Ptappui[0]['point'],'distance'=>$distance,'distm'=>m_de($distance),'distcm'=>cm_de($distance));
					$ListeClotures[]=array('designation'=>"- La clôture qui existe sur le tronçon ".$Ptappui[$i]['point']."-".$Ptappui[0]['point']." est rattachée à la propriété de ".$doss_demandeur." (".$doss_sect." n°".$doss_parc.")");
				}
				break;
			default : // tous les autres cas
				$distance=DisTopo($Ptappui[$i]['coordx'],$Ptappui[$i]['coordy'],$Ptappui[$i+1]['coordx'],$Ptappui[$i+1]['coordy']);
				$ListeAppuis[]=array('nom'=>$Ptappui[$i]['point']." - ".$Ptappui[$i+1]['point'],'distance'=>$distance,'distm'=>m_de($distance),'distcm'=>cm_de($distance));
										// 'nom' : résultats "A - B", "B - C"
										//  'distance' :  distance appelle fonction DisTopo(xA,yA,xB,yB)
				$ListeClotures[]=array('designation'=>"- La clôture qui existe sur le tronçon ".$Ptappui[$i]['point']."-".$Ptappui[$i+1]['point']." est rattachée à la propriété de ".$doss_demandeur." (".$doss_sect." n°".$doss_parc.")");			
			
		}
	}
}


//--------------TRAITEMENT DE LA LISTE DES INTERVENANTS---------------

$L = explode("\r\n",$temp_intervenants);
$k=0;

$doss_convoc ="";
$blk_parc= array();

$blk_parc_pptr= "";
$blk_design= array();
$blk_design_pptr= array();
$blk_design_riv= array();
$blk_design_acqu= array();
$blk_design_autres= array();
$blk_details_pptr= array();

$blk_pouv_pptr= "";

$voie = "";

// ----------REMPLISSAGE désignations, tableaux de parcelles et tableaux de propriétaires

for($i=0;$i<count($L);$i++){
	if ($L[$i]!=''){

		$champ = explode(";",$L[$i]);
		$voie .= $champ[11]; // recupere le nom de la voie entrée dans geoprod, STATUT à voir  // modif 2023-04-24
		
		$T=$L[$i]; // ligne intervenant
		
		if (count($champ)<71) { // modif 2023-04-24
			$champ2 = explode(";",$L[$i+1]);
			$champ3 = explode(";",$L[$i+2]);
			if (count($champ)+count($champ2)==72) { //cas d'une adresse scindée en 2  // modif 2023-04-24
				$M=array();
				$M[]=$L[$i];
				$M[]=$L[$i+1];
				$N=implode(", ",$M); //champs réassociés scindés par virgule
				$T=$N; // ligne intervenant
				$champ = explode(";",$N);
				$i++; // pour sauter la ligne suivante
			}
			if (count($champ)+count($champ2)+count($champ3)==73) { //cas d'une adresse scindée en 3   // modif 2023-04-24
				$M=array();
				$M[]=$L[$i];
				$M[]=$L[$i+1];
				$M[]=$L[$i+2];				
				$N=implode(", ",$M); //champs réassociés scindés par virgule
				$T=$N; // ligne intervenant
				$champ = explode(";",$N);
				$i++; // pour sauter la ligne suivante
				$i++; // pour sauter la 2eme ligne suivante
			}			
		
		}
		
		
		switch (substr($champ[6],0,4)){  // switch en fonction du statut (gére indivis, usuf, nupptr)   // modif 2023-04-24
			case "Prop": //propriétaires

				foreach(explode("\r",design_interv($T)) as $value){
					$blk_design_pptr[] = array('ligne'=>$value);

				}

				$blk_pptr[] = array('nom'=>bloc_pptr($T),'section'=>$champ[8], 'parcelle'=>$champ[9], 'dom_adr'=>$champ[58], 'dom_cpville'=>$champ[57]." ".$champ[7], 'naiss_le'=>$champ[15], 'naiss_a'=>$champ[16]); //ajoute case Société ou personne solo ou mari seulement   // modif 2023-04-24
				if ($champ[26]!="") {$blk_pptr[] = array('nom'=>"Mme ".$champ[26],'section'=>$champ[8], 'parcelle'=>$champ[9], 'dom_adr'=>$champ[58], 'dom_cpville'=>$champ[57]." ".$champ[7], 'naiss_le'=>$champ[24], 'naiss_a'=>$champ[25]);} //ajoute case Mme si épouse // champ[28] NE MARCHE PLUS DEPUIS MAJ SPDC EN MAI 2022  // modif 2023-04-24

				if ($blk_parc_pptr!=""){$blk_parc_pptr = $blk_parc_pptr."\r\n";}
				$blk_parc_pptr = $blk_parc_pptr.$champ[2]." ".$champ[3]." ".$champ[4]; // remplit une liste des propriétaires pour mettre dans le tableau de parcelle - Nouveau 12-11-2022  // modif 2023-04-24
				
				if ($blk_pouv_pptr!=""){$blk_pouv_pptr = $blk_pouv_pptr.", ";}
				$blk_pouv_pptr = $blk_pouv_pptr.bloc_pptr($T); // remplit une liste des propriétaires pour mettre dans le pouvoir DA - Nouveau 22-11-2022
				
				break;				
				
			
			case "Rive": // riverains

				foreach(explode("\r",design_interv($T)) as $value){//répartie la désignation dans un array pour permettre affichage sous forme de paragraphe
					$blk_design_riv[] = array('ligne'=>$value);
				}

				if (!existence_parc($champ[54],$champ[8],$champ[9],$blk_parc) && $champ[9]!="") { //incrémente le tableau, ajoute une ligne parcelle  // modif 2023-04-24
					$blk_parc[]=bloc_parc($T);
				} else { // dans le tableau de parcelle, ajoute un propriétaire à la parcelle si elle existait déjà
					if ($champ[9]!=""){ // modif 2023-04-24
						$ind = index_parc($champ[54],$champ[8],$champ[9],$blk_parc); // modif 2023-04-24
						$blk_parc[$ind]['pptr'] = $blk_parc[$ind]['pptr']."\r\n".$champ[2]." ".$champ[3]." ".$champ[4]; // modif 2023-04-24
					}
				
				}	
				
				
				$blk_pptr[] = array('nom'=>bloc_pptr($T),'section'=>$champ[8], 'parcelle'=>$champ[9], 'dom_adr'=>$champ[58], 'dom_cpville'=>$champ[57]." ".$champ[7], 'naiss_le'=>$champ[15], 'naiss_a'=>$champ[16]); //ajoute case Société ou personne solo ou mari seulement  // modif 2023-04-24
				if ($champ[26]!="") {$blk_pptr[] = array('nom'=>"Mme ".$champ[26],'section'=>$champ[8], 'parcelle'=>$champ[9], 'dom_adr'=>$champ[58], 'dom_cpville'=>$champ[57]." ".$champ[7], 'naiss_le'=>$champ[24], 'naiss_a'=>$champ[25]);} //ajoute case Mme si épouse // champ[28] NE MARCHE PLUS DEPUIS MAJ SPDC EN MAI 2022  // modif 2023-04-24
				
				break;

			case "Acqu": // acquéreurs
				switch ($champ[5]) { // modif 2023-04-24
					case "": // cas personne physique

						$blk_design_acqu[] = array('ligne'=>$champ[2]." ".$champ[3]." ".$champ[4].", demeurant ".$champ[58].", ".$champ[57]." ".$champ[7].".");//Nom adresse  // modif 2023-04-24
						$blk_design_acqu[] = array('ligne'=>"");//Saut de ligne
						break;
					default : // cas société

						$blk_design_acqu[] = array('ligne'=>$champ[5].", représentée par ".$champ[2]." ".$champ[3]." ".$champ[4].", domiciliée ".$champ[58].", ".$champ[57]." ".$champ[7].".");
						$blk_design_acqu[] = array('ligne'=>"");//Saut de ligne
				}
				$blk_pptr[] = array('nom'=>bloc_pptr($T),'section'=>$champ[8], 'parcelle'=>$champ[9], 'dom_adr'=>$champ[58], 'dom_cpville'=>$champ[57]." ".$champ[7], 'naiss_le'=>$champ[15], 'naiss_a'=>$champ[16]);  // modif 2023-04-24
				break;
				
				
			default : // autres
				switch ($champ[5]) { // modif 2023-04-24
					case "": // cas personne physique

						$blk_design_autres[] = array('ligne'=>$champ[2]." ".$champ[3]." ".$champ[4].", demeurant ".$champ[58].", ".$champ[57]." ".$champ[7].".");//Nom adresse  // modif 2023-04-24
						$blk_design_autres[] = array('ligne'=>""); //Saut de ligne

						break;
					default : // cas société
						//$doss_intervenants_autres .= $champ[0].", représentée par ".$champ[1]." ".$champ[2].", domiciliée ".$champ[3].", ".$champ[4]." ".$champ[5].".\r\r";
						$blk_design_autres[] = array('ligne'=>$champ[5].", représentée par ".$champ[2]." ".$champ[3]." ".$champ[4].", domiciliée ".$champ[58].", ".$champ[57]." ".$champ[7].".");  // modif 2023-04-24
						$blk_design_autres[] = array('ligne'=>""); //Saut de ligne

				}
				$blk_pptr[] = array('nom'=>bloc_pptr($T),'section'=>$champ[8], 'parcelle'=>$champ[9], 'dom_adr'=>$champ[58], 'dom_cpville'=>$champ[57]." ".$champ[7], 'naiss_le'=>$champ[15], 'naiss_a'=>$champ[16]);  // modif 2023-04-24
				break;
				
		}
		
		$doss_convoc .= convoc($T);

	}
}


if ($blk_pouv_pptr==""){$blk_pouv_pptr = "XXXXXXXXX";} // cas d'une liste de propriétaires vide

//--------------TRAITEMENT DES PTS TOPO---------------

$Mt = explode("\r\n",$pts_init);

for($i=0;$i<count($Mt);$i++){
	if ($Mt[$i]!=''){
		$champM = explode($septopo,$Mt[$i]);  //   MODIF   08/06/2022   $champM = explode(";",$Mt[$i]);      
		$topo[]=array('point'=>$champM[0], 'coordx'=>number_format($champM[1],2,".",""), 'coordy'=>number_format($champM[2],2,".",""), 'designation'=>$champM[3]);
	}
}


//--------------TRAITEMENT SOUS MON CONTROLE TECHNICIEN---------------


include './func/incl_sous-mon-controle.php';


//--------------TRAITEMENT BUREAU---------------


include './func/incl_bureaux.php';


//---------------SELECTION DU MODELE DE PV     et   du    chemin    --------------------

if (!file_exists('./export/pv/')) {
    mkdir('./export/pv/', 0777, true);
}

switch ($_POST['gen_action']){
	case "PVB .docx":
		//$output_save_path = './export/pv/'.$doss_num.'_PVB_'.date('Y-m-d_His').'.docx';  // modif 28-04-2023
		$output_file_name = $doss_num.'_PVB_'.date('Y-m-d_His').'.docx';
		$modele="PVB.docx";
		break;	
	case "PVB signature élec.docx":
		//$output_save_path = './export/pv/'.$doss_num.'_PVB_sign_elec_'.date('Y-m-d_His').'.docx';  // modif 28-04-2023
		$output_file_name = $doss_num.'_PVB_sign_elec_'.date('Y-m-d_His').'.docx';
		$modele="PVB sign elec.docx";
		break;			
	case "PV Carence .docx":
		//$output_save_path = './export/pv/'.$doss_num.'_PVcarence_'.date('Y-m-d_His').'.docx';  // modif 28-04-2023
		$output_file_name = $doss_num.'_PVcarence_'.date('Y-m-d_His').'.docx';
		$modele="PV-carence.docx";
		break;
	case "PV3P .docx":
		//$output_save_path = './export/pv/'.$doss_num.'_PV3P_'.date('Y-m-d_His').'.docx';  // modif 28-04-2023
		$output_file_name = $doss_num.'_PV3P_'.date('Y-m-d_His').'.docx';
		$modele="PV3P.docx";
		break;		
	case "PVDelim SNCF .docx":
		//$output_save_path = './export/pv/'.$doss_num.'_PVDelim-SNCF_'.date('Y-m-d_His').'.docx';  // modif 28-04-2023
		$output_file_name = $doss_num.'_PVDelim-SNCF_'.date('Y-m-d_His').'.docx';
		$modele="PV3P-SNCF.docx";
		break;	
	case "PVRetab .docx":
		//$output_save_path = './export/pv/'.$doss_num.'_PVRetab_'.date('Y-m-d_His').'.docx';  // modif 28-04-2023
		$output_file_name = $doss_num.'_PVRetab_'.date('Y-m-d_His').'.docx';
		$modele="PVRetab.docx";
		break;			
	case "Feuille Présence .docx":
		//$output_save_path = './export/pv/'.$doss_num.'_Feuille-presence_'.date('Y-m-d_His').'.docx';  // modif 28-04-2023
		$output_file_name = $doss_num.'_Feuille-presence_'.date('Y-m-d_His').'.docx';
		$modele="feuille-présence.docx";
		break;	
	case "Rapport intervention .docx":
		//$output_save_path = './export/pv/'.$doss_num.'_Rapport-intervention_'.date('Y-m-d_His').'.docx';  // modif 28-04-2023
		$output_file_name = $doss_num.'_Rapport-intervention_'.date('Y-m-d_His').'.docx';
		$modele="RapportInterv.docx";
		break;
	case "Pouvoir DA .docx":
		//$output_save_path = './export/pv/'.$doss_num.'_Pouvoir-DA_'.date('Y-m-d_His').'.docx';  // modif 28-04-2023
		$output_file_name = $doss_num.'_Pouvoir-DA_'.date('Y-m-d_His').'.docx';
		$modele="Pouvoir DA.docx";
		break;
	case "Pouvoir DA sign élec .docx":
		//$output_save_path = './export/pv/'.$doss_num.'_Pouvoir-DA-elec_'.date('Y-m-d_His').'.docx';  // modif 28-04-2023
		$output_file_name = $doss_num.'_Pouvoir-DA-elec_'.date('Y-m-d_His').'.docx';
		$modele="Pouvoir DA sign-élec.docx";
		break;
	case "PG Livret Division .docx":
		//$output_save_path = './export/pv/'.$doss_num.'_PG-livret-division_'.date('Y-m-d_His').'.docx';  // modif 28-04-2023
		$output_file_name = $doss_num.'_PG-livret-division_'.date('Y-m-d_His').'.docx';
		$modele="PG-livret-Division.docx";
		break;
	case "Notice servitudes succincte .docx":
		//$output_save_path = './export/pv/'.$doss_num.'_Notice-Serv-succincte_'.date('Y-m-d_His').'.docx';   // modif 28-04-2023
		$output_file_name = $doss_num.'_Notice-Serv-succincte_'.date('Y-m-d_His').'.docx';
		$modele="Notice-servitudes-succincte.docx";
		break;		
	default:
		break;
		
}


include_once('./tbs/tbs_class.php');
include_once('./tbs/tbs_plugin_opentbs.php');

$TBS = new clsTinyButStrong;
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

$template = './template/'.$modele;

// --------------- pour DOWNLOAD ----------

$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

if(isset($blk_parc)){$TBS->MergeBlock('blk_parc',$blk_parc);}
if(isset($topo)){$TBS->MergeBlock('blk_topo',$topo);}
if(isset($ListeAppuis)){$TBS->MergeBlock('ListeAppuis',$ListeAppuis);}
if(isset($Ptappui)){$TBS->MergeBlock('Ptappui',$Ptappui);}
if(isset($ListeClotures)){$TBS->MergeBlock('ListeClotures',$ListeClotures);}


if(isset($blk_pptr)){$TBS->MergeBlock('blk_pptr',$blk_pptr);}
if(isset($blk_design_pptr)){$TBS->MergeBlock('blk_design_pptr',$blk_design_pptr);}
if(isset($blk_design_riv)){$TBS->MergeBlock('blk_design_riv',$blk_design_riv);}
if(isset($blk_design_acqu)){$TBS->MergeBlock('blk_design_acqu',$blk_design_acqu);}
if(isset($blk_design_autres)){$TBS->MergeBlock('blk_design_autres',$blk_design_autres);}
if(isset($blk_termes_nouv)){$TBS->MergeBlock('blk_termes_nouv',$blk_termes_nouv);}
if(isset($blk_termes_reco)){$TBS->MergeBlock('blk_termes_reco',$blk_termes_reco);}

$TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // téléchargement direct


// --------------- pour ENREGISTREMENT ----------

//$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);  // modif 28-04-2023

//if(isset($blk_parc)){$TBS->MergeBlock('blk_parc',$blk_parc);}  // modif 28-04-2023
//if(isset($topo)){$TBS->MergeBlock('blk_topo',$topo);}  // modif 28-04-2023
//if(isset($ListeAppuis)){$TBS->MergeBlock('ListeAppuis',$ListeAppuis);}  // modif 28-04-2023
//if(isset($Ptappui)){$TBS->MergeBlock('Ptappui',$Ptappui);}  // modif 28-04-2023
//if(isset($ListeClotures)){$TBS->MergeBlock('ListeClotures',$ListeClotures);}  // modif 28-04-2023

//if(isset($blk_pptr)){$TBS->MergeBlock('blk_pptr',$blk_pptr);}  // modif 28-04-2023
//if(isset($blk_design_pptr)){$TBS->MergeBlock('blk_design_pptr',$blk_design_pptr);}  // modif 28-04-2023
//if(isset($blk_design_riv)){$TBS->MergeBlock('blk_design_riv',$blk_design_riv);}  // modif 28-04-2023
//if(isset($blk_design_acqu)){$TBS->MergeBlock('blk_design_acqu',$blk_design_acqu);}  // modif 28-04-2023
//if(isset($blk_design_autres)){$TBS->MergeBlock('blk_design_autres',$blk_design_autres);}  // modif 28-04-2023
//if(isset($blk_termes_nouv)){$TBS->MergeBlock('blk_termes_nouv',$blk_termes_nouv);} // modif 28-04-2023
//if(isset($blk_termes_reco)){$TBS->MergeBlock('blk_termes_reco',$blk_termes_reco);}  // modif 28-04-2023

//$TBS->Show(OPENTBS_FILE, $output_save_path); // enregistrement sur le serveur  // modif 28-04-2023

exit();
?>
