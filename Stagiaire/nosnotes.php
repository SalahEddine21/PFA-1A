<?php
	 session_start();

	 if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');
 	 try
 	 {
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	 }catch(Exception $e)
 	 {
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	 }

 	if(strcmp($_SESSION['niveau'], '1A')==0){
 		 $table='binomes1A';
 		 $table_choix='binomes1a_choix';
 	}
 	else{
 		 $table='Binomes2A';
 		 $table_choix='binomes2a_choix';
 	}
 	//---------------------------------------Affichage des notes-------------------------------------//
 	if(strcmp($_SESSION['niveau'], '1A')==0)
 	{
 		$query1=$bdd->prepare('SELECT * FROM import1A WHERE codeEtudiant= ?');
 		$query2=$bdd->prepare('SELECT * FROM import1A WHERE codeEtudiant= ? ');
 	}
 	else{
 	  	$query1=$bdd->prepare('SELECT * FROM import2A WHERE codeEtudiant= ?');
 	  	$query2=$bdd->prepare('SELECT * FROM import2A WHERE codeEtudiant= ? ');
 	}

 	$query1->execute(array($_SESSION['code1'] ));
 	$query2->execute(array($_SESSION['code2'] ));

 	$entre1=$query1->fetch();
 	$entre2=$query2->fetch();


 	$notes=array('M1'=>0,'M2'=>0,'M3'=>0,'M4'=>0,'M5'=>0,'M6'=>0,'M7'=>0,'M8'=>0);	
 	foreach ($notes as $key => $valeur) {
 		$m=$entre1[$key];
 		$m1=$entre2[$key];
 		$notes[$key]=($m+$m1)/2;
 	}
 	//----------------------------------------------------------------------------------------------//
 	$affecter=$_SESSION['affecter'];
 	$_SESSION['vue2']=1;
 	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Stagiaire</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
	 <div class="container">
			<div class="row">
				<nav class="navbar navbar-inverse col-md-12 col-sm-12">
					<ul class="nav navbar-nav">
						<li><a href="profil.php">Accueil</a></li>						
					</ul> 
					<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
				</nav>
			 </div>  
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em;">
			 		<h1>AGS</h1>
			 		<p>Bonjour <?php echo $_SESSION['nomb']?></p>
			 	</div>
			 </header>

		<section class="row">
			 	<div class="col-sm-12 col-md-4 col-lg-4">
  					<h4 class="w3-bar-item"><b>Menu</b></h4>
			 		<ul class="list-group">
						<button id="profil" class="list-group-item" onclick="document.location.href='profil.php'">Annonce</button>
						<button id="choix" class="list-group-item" onclick="document.location.href='fiche-choix.php'">Fiche des Choix</button>
						<button id="resultat" class="list-group-item" onclick="document.location.href='resultats.php'">Resultats d'Affectation</button>						
						<button id="stages_detail" class="list-group-item" onclick="document.location.href='list-stages.php'">Stages</button>
						<button id="ensemble" class="list-group-item " onclick="document.location.href='noschoix.php'">Nos Choix</button>
						<button id="mesnotes" class="list-group-item active" onclick="document.location.href='nosnotes.php'">Nos Notes</button>
					</ul>
			 	</div>

			 	<div class="col-sm-12 col-md-8 col-lg-8" style="margin-top:40px;">
			 		<div id="modules">
			 		
			 			<table class="table table-bordered table-striped table-condensed">
			 				<caption>Vos Notes</caption>
			 				<head>
			 					<tr>
				 					<th>Modules</th>
				 					<th>Note</th>
			 					</tr>
			 				</head>
			 				<tbody>
			 					<?php
			 							foreach ($notes as $key => $valeur)
			 							{
			 								echo "<tr class='active'>";
				 								echo "<td>$key</td>";
				 								echo "<td>$notes[$key]</td>";
				 							echo "</tr>";
			 							}
			 					?>		
			 				</tbody>
			 			</table>
			 		</div>			 					 					 				
			 	</div>	
		</section>			

	</div>
	<script>
		var affecter='<?php echo $affecter ?>';
		var vue='<?php echo $_SESSION['vue'] ?>';
		var vue1='<?php echo $_SESSION['vue1'] ?>';
		var exited='<?php echo $_SESSION['exited'] ?>';

		if(affecter==1){
				document.getElementById('choix').disabled=true;
				document.getElementById('stages_detail').disabled=true;	

				if(vue==0){
					var bouton=document.getElementById('resultat');
					bouton.className='list-group-item list-group-item-success';
					span=document.createElement('span');
					span.className='badge';
					span.appendChild(document.createTextNode('1'));
					bouton.appendChild(span);
				}		
		}else if(affecter==0 && vue1==0){
 	  				var fiche_but=document.getElementById('choix');
					fiche_but.className='list-group-item list-group-item-danger';
					span=document.createElement('span');
					span.className='badge';
					span.appendChild(document.createTextNode('1'));
					fiche_but.appendChild(span); 	  			
 	  	}else if(affecter==-1 && exited=='true'){
 	  				document.getElementById('choix').disabled=true;
 	  				document.getElementById('resultat').disabled=true;
 	  				document.getElementById('stages_detail').disabled=true;
 	  				document.getElementById('ensemble').disabled=true;
 	  	}
	</script>
</body>
</html>