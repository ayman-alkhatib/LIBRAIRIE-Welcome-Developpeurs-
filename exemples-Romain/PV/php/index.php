<!DOCTYPE html>

<html>

<head>
<title>Génération PVs</title>
<link rel="icon" type="image/x-icon" href="../image/favicon.ico">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php include 'style.php';?>
</head>


<body class="w3-light-grey">

<script> // évite l'envoi à nouveau du formulaire en cas de rafraichissement de la page
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<script> 

function apercuTopo(){ 
	var pts_list = escape(document.getElementById("pts_init").value);
	var separ = document.querySelector('input[name="separ_topo"]:checked').value;
	var url = "./func/apercu-ptopo.php";
	
	var xhr = createXHR();
  
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  

	xhr.onreadystatechange  = function() 
    { 
       if(xhr.readyState  == 4)
       {
        if(xhr.status  == 200) {
            document.getElementById("ptopo_apercu").innerHTML = xhr.responseText; 
        } else {
            document.getElementById("ptopo_apercu").innerHTML = "Error code " + xhr.status + "<br>";
		}	
        } else {
			document.getElementById("ptopo_apercu").innerHTML = "..."; 
		}
    }; 
	xhr.send("listing="+pts_list+"&separ="+separ);
}

function apercuInterv(){ 
	var interv_list = escape(document.getElementById("temp_intervenants").value);
	
	var url = "./func/apercu-interv.php";
	var xhr = createXHR();
  
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  

	xhr.onreadystatechange  = function() 
    { 
       if(xhr.readyState  == 4)
       {
        if(xhr.status  == 200) {
            document.getElementById("interv_apercu").innerHTML = xhr.responseText; 
        } else {
            document.getElementById("interv_apercu").innerHTML = "Error code " + xhr.status + "<br>";
		}	
        } else {
			document.getElementById("interv_apercu").innerHTML = "..."; 
		}
    }; 
	xhr.send("listing="+interv_list);
}

function chg_bureau(){ 
	var GE = document.getElementById("doss_GE").value;
	var url = "./func/chg_bureau.php";
	var xhr = createXHR();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  

	xhr.onreadystatechange  = function() 
    { 
       if(xhr.readyState  == 4)
       {
        if(xhr.status  == 200) {
            document.getElementById("doss_bureau").innerHTML = xhr.responseText; } 
			else {  document.getElementById("bureau_log_hidden").innerHTML = "Error code " + xhr.status + "<br>";}	
        } else {document.getElementById("bureau_log_hidden").innerHTML = "Import en cours"; }
    }; 
	xhr.send("GE="+GE);	

}

function chg_tech(){ 
	var GE = document.getElementById("doss_GE").value;
	var url = "./func/chg_tech.php";
	var xhr = createXHR();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  

	xhr.onreadystatechange  = function() 
    { 
       if(xhr.readyState  == 4)
       {
        if(xhr.status  == 200) {
            document.getElementById("doss_tech").innerHTML = xhr.responseText; } 
			else { document.getElementById("tech_log_hidden").innerHTML = "Error code " + xhr.status + "<br>";}	
        } else {document.getElementById("tech_log_hidden").innerHTML = "Import en cours"; }
    }; 
	xhr.send("GE="+GE);	

}

function chg_dept(){ 
	var GE = document.getElementById("doss_GE").value;
	var url = "./func/chg_dept.php";
	var xhr = createXHR();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  

	xhr.onreadystatechange  = function() 
    { 
       if(xhr.readyState  == 4) {
			if(xhr.status  == 200) { document.getElementById("doss_dept").value = xhr.responseText; 
			} else { document.getElementById("dept_log_hidden").innerHTML = "Error code " + xhr.status + "<br>";}	
       } else { document.getElementById("dept_log_hidden").innerHTML = "Import en cours"; }
    }; 
	xhr.send("GE="+GE);	

}


function get_separ_topo(){ 
	var topo_list = escape(document.getElementById("pts_init").value);
	
	if(document.getElementById('separ_topo_auto').checked ==true){
		var radio_check = 1;
	}
	if(document.getElementById('separ_topo_auto').checked ==false){
		var radio_check = 0;
	}
	
	var url = "./func/get-separ-topo.php";
	
	var xhr = createXHR();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  

	xhr.onreadystatechange  = function() 
    { 
       if(xhr.readyState  == 4)
       {
        if(xhr.status  == 200) {
            //document.getElementById("separ_topo_auto").value = xhr.responseText;
			document.getElementById("span_separ_topo_auto").innerHTML = xhr.responseText;
			
        } else {  document.getElementById("span_separ_topo_auto").innerHTML = "Error code " + xhr.status + "<br>";
		}	
        } else {	document.getElementById("span_separ_topo_auto").innerHTML = "..."; 
		}
    }; 
	xhr.send("listing="+topo_list+"&radio_check="+radio_check);	

}

</script> 

<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1600px;">
<form action="template-save.php" method="post">
  <!-- The Grid -->
  <div class="w3-row-padding">
  
    <!-- Left Column -->
    <div class="w3-third">
	
			<!-- 1ere Case -->	
      <div class="w3-container w3-card w3-white w3-margin-bottom">

        <div class="w3-container"  style="color:black;text-align:center"><!--w3-large w3-text-teal-->
		  <p><i class="fas fa-folder-open w3-margin-right"></i><big><strong>INFORMATIONS DOSSIER</strong></big></p>
		  <hr>
		  <p><label for="doss_num">Num. dossier - Resp. : </label>
		  <input type="text" id="doss_num" name="doss_num" onchange="setTimeout(function() {liste_gen('../export/pv/');}, 500);"></p>
		  
		  <p><label for="doss_GE">Géomètre-Expert :</label>
			<select name="doss_GE" id="doss_GE" onchange="chg_bureau();chg_tech();chg_dept()">
				<option value="M-06176-M. Romain AUGER">AUGER Romain</option>
				<option value="M-06177-M. David BACHELLIER">BACHELLIER David</option>
				<option value="F-06155-Mme Laurence BAZANTAY">BAZANTAY Laurence</option>
				<option value="M-06283-M. Valentin BODET">BODET Valentin</option>
				<option value="M-05276-M. William BRANLY">BRANLY William</option>
				<option value="M-06564-M. Louis-Marie NAULIN">NAULIN Louis-Marie</option>				
			</select></p>			  
		  <p><label for="doss_bureau">Bureau :</label>
			<select name="doss_bureau" id="doss_bureau">
				<option value="LOCHES">LOCHES</option>
				<option value="MONTLOUIS-SUR-LOIRE">MONTLOUIS</option>
			</select><div id="bureau_log_hidden" hidden></div></p>
				
		  <p><label for="doss_tech">Technicien sur place :</label>
			<select name="doss_tech" id="doss_tech">
				<option value="M. Romain AUGER">Romain</option>
				<option value="Mme Elise PERROUAULT">Elise</option>
				<option value="M. Gaylord DECARSIN">Gaylord</option>
				<option value="M. Julien PETIT">Julien</option>
			</select><div id="tech_log_hidden" hidden></div></p>
			
          <p><label for="doss_dept">Département : </label>
		  <input type="text" id="doss_dept" name="doss_dept" value="d'INDRE-ET-LOIRE"><div id="dept_log_hidden" hidden></div></p>
          <p><label for="doss_comm">Commune : </label>
		  <input type="text" id="doss_comm" name="doss_comm" oninput="this.value = this.value.toUpperCase()">&nbsp;&nbsp;<i class="fas fa-city fa-sm"></i></p>
          <p><label for="doss_lieu">Adresse ou lieu-dit : </label>
		  <input type="text" id="doss_lieu" name="doss_lieu" onkeyup='this.value=this.value.replace(/"/g,"")'>&nbsp;&nbsp;<i class="fas fa-location-crosshairs fa-sm"></i></p>
          <p><label for="doss_sect">Section : </label>
		  <input type="text" id="doss_sect" name="doss_sect" oninput="this.value = this.value.toUpperCase()"></p>
		  <p><label for="doss_parc">Parcelle(s) n° : </label>
		  <input type="text" id="doss_parc" name="doss_parc"></p>
		  <p><label for="doss_demandeur">Demandeur : </label>
		  <input type="text" id="doss_demandeur" name="doss_demandeur">&nbsp;&nbsp;<i class="fas fa-user fa-sm"></i></p>		  
		  <p><label for="doss_date">Date Bornage / Délim. : </label>
		  <input type="text" id="doss_date" name="doss_date">&nbsp;&nbsp;<i class="fas fa-calendar fa-sm"></i></p>
		  <p><label for="doss_voiepub">Voie Publique : </label>
		  <input type="text" id="doss_voiepub" name="doss_voiepub">&nbsp;&nbsp;<i class="fas fa-road fa-sm"></i></p>
		  <p><label for="doss_voieferree">Voie SNCF : </label>
		  <input type="text" id="doss_voieferree" name="doss_voieferree">&nbsp;&nbsp;<i class="fas fa-train-subway fa-sm"></i></p>		  
		  <br>
        </div>
      </div>
			<!-- Fin 1ere Case -->	

    
    </div><!-- End Left Column -->

	
    <!-- Center Column -->
    <div class="w3-third">
    
      <div class="w3-white w3-text-grey w3-card-4">
       

        <div class="w3-container"  style="color:black;text-align:center">
		  <p><i class="fas fa-users w3-margin-right"></i><big><strong>INTERVENANTS</strong></big></p>

          <p style="text-align:center"></p>
		  <textarea name="temp_intervenants" id="temp_intervenants" style="border-style:groove; width:280px" placeholder="copiez liste intervenants ici, sans l'entête (A partir de Geoprod, onglet Propriétaires > Menu Scripts > Exporter > Proprios > Propriétaires.xlsx, ouvrir puis Enregistrer en CSV point-virg.)" rows="6" oninput='this.value=this.value.replace(/"/g,"");apercuInterv();'></textarea>

			<p>séparateur :&nbsp;&nbsp;&nbsp;<input type="radio" id="separ_interv_point-virgule" name="separ_interv" value=";" checked onchange="">
			<label for="separ_interv_point-virgule">point-virg.</label>&nbsp;&nbsp;&nbsp;
			
			
		  <div id="interv_apercu"></div>		  
		  <div id="interv_log"></div>	
		  
		  <p style="text-align:center"></p>
		  <br>
		  </div>
       </div><br>
		  
		  
      <div class="w3-white w3-text-grey w3-card-4">
       

        <div class="w3-container"  style="color:black;text-align:center">		  


		  <p><i class="fa fa-compass-drafting w3-margin-right"></i><big><strong>LISTING PTS TOPO</strong></big></p>
  
		  <textarea name="pts_init" id="pts_init" style="border-style:groove; width:280px" placeholder="copiez votre listing ici Numero;X;Y;designation (X et Y avec 3 décimales pour calcul exact distances / 3ème décimale cachée dans le tableau), sans entête (export csv depuis tableau du dwg, ouvrir avec bloc-note)" rows="6" oninput='this.value=this.value.replace(/"/g,"");apercuTopo();get_separ_topo();'></textarea>
		  
			<p>séparateur :&nbsp;&nbsp;&nbsp;<input type="radio" id="separ_topo_point-virgule" name="separ_topo" value=";" onchange="apercuTopo();" checked>
			<label for="separ_topo_point-virgule">point-virg.</label>&nbsp;&nbsp;&nbsp;
			<span id="span_separ_topo_auto">
			<input type="radio" id="separ_topo_auto" name="separ_topo" value="," onchange="apercuTopo();" title="auto parmi point-virgule/virgule/espace/tabulation">
			<label id="label_separ_topo_auto" for="separ_topo_auto" title="auto parmi point-virgule/virgule/espace/tabulation">auto</label>
			</span>
			&nbsp;&nbsp;&nbsp;
			<input type="radio" id="separ_topo_autre" name="separ_topo" value=" " hidden>
			<label for="separ_topo_autre" hidden>autre</label></p>
		  
		  <div id="ptopo_apercu"></div>	
		  <div id="ptopo_log"></div>
		  <p style="text-align:center"></p>		
		  <br>
        </div>
       </div><br>
	   


    
    </div><!-- End Center Column -->	
		
    <!-- Right Column -->
    <div class="w3-third">
    
      <div class="w3-container w3-card w3-white w3-margin-bottom">
		<div class="w3-container"  style="color:black;text-align:center">
          <p><i class="fas fa-file-alt w3-margin-right <!--w3-large w3-text-teal-->"></i><big><strong>GENERATION DOCS</strong></big></p>
		  <hr>
		  <p style="text-align:center"><i class="fas fa-table-list fa-lg"></i> <strong><input type="submit" name="gen_action" value="Feuille Présence .docx"/></strong></p>
		  <hr>
		  <p style="text-align:center"><i class="fas fa-file-signature fa-lg"></i> <strong><input type="submit" name="gen_action" value="PVB .docx"/></strong>&nbsp;&nbsp;&nbsp;&nbsp;<strong><input type="submit" name="gen_action" value="PVB signature élec.docx" /></strong></p>
		  <p style="text-align:center"><i class="fas fa-file-circle-xmark fa-lg"></i> <strong><input type="submit" name="gen_action" value="PV Carence .docx" /></strong></p>
		  <hr>
		  <p style="text-align:center"><i class="fas fa-road fa-lg"></i> <strong><input type="submit" name="gen_action" value="PV3P .docx"/></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-train-subway fa-lg"></i> <strong><input type="submit" name="gen_action" value="PVDelim SNCF .docx" /></strong></p>
		  <hr>
		  <p style="text-align:center"><i class="fas fa-file-circle-plus fa-lg"></i> <strong><input type="submit" name="gen_action" value="PVRetab .docx" title="limite certaine mais matérialisation disparue à remettre"/></strong></p>
		  <p style="text-align:center"><i class="fas fa-file-circle-check fa-lg"></i> <strong><input type="submit" name="gen_action" value="Rapport intervention .docx" title="limite certaine / pose d'un point intermédiaire"/></strong></p>
		  <hr>
		  <p style="text-align:center"><i class="fas fa-file-signature fa-lg"></i> <strong><input type="submit" name="gen_action" value="Pouvoir DA .docx"/></strong>&nbsp;&nbsp;&nbsp;&nbsp;<strong><input type="submit" name="gen_action" value="Pouvoir DA sign élec .docx"/></strong></p>
			<p style="text-align:center"><i class="fas fa-book fa-lg"></i> <strong><input type="submit" name="gen_action" value="PG Livret Division .docx"  title="page de garde du livret de division"/></strong></p>
		  <hr>
		  <p style="text-align:center"><i class="fas fa-link fa-lg"></i> <strong><input type="submit" name="gen_action" value="Rapport servitudes .docx" disabled/></strong></p>
			<p style="text-align:center"><i class="fas fa-link fa-lg"></i><i class="fas fa-bolt fa-lg"></i> <strong><input type="submit" name="gen_action" value="Notice servitudes succincte .docx"  title="(1 page)" /></strong></p>			
		  </div> 
		  <br>	
		  
	  </div>
  
    </div><!-- End Right Column -->
    
  
  </div><!-- End Grid -->
  
  </form><!-- End Form -->
  
</div><!-- End Page Container -->


<footer style="text-align:center" >
  <p>w3.css</p>
</footer>

<?php  exit(); ?>

</body>
</html>
