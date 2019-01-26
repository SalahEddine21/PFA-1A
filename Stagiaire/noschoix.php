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

 	 $query=$bdd->prepare("SELECT * FROM $table_choix WHERE idb=?");
 	 $query->execute(array($_SESSION['idb']));
 	 $ligne=$query->fetch();
 	 if(empty($ligne)){
 	 	 $value='Enregistrer';
 	 	 $affecter=-1;
 	 }
 	 else $value='Modifier';
 	 //-------------------------Affichage des choix pour ceux qui l'ont déjà fait------------------------//
 	 $choix=array();
 	 if(strcmp($value, 'Modifier')==0){
 	 //---------------------------------------------------------------------//
	$query=$bdd->prepare('SELECT titre FROM stages WHERE idstage= ?');
	$query->execute(array($ligne['choix1']));
	$ligne1=$query->fetch();
	$choix[0]=$ligne1['titre'];
 	 //---------------------------------------------------------------------//
	$query=$bdd->prepare('SELECT titre FROM stages WHERE idstage= ?');
	$query->execute(array($ligne['choix2']));
	$ligne1=$query->fetch();
	$choix[1]=$ligne1['titre'];
 	 //---------------------------------------------------------------------//
	$query=$bdd->prepare('SELECT titre FROM stages WHERE idstage= ?');
	$query->execute(array($ligne['choix3']));
	$ligne1=$query->fetch();
	$choix[2]=$ligne1['titre'];
 	 //---------------------------------------------------------------------//
	$query=$bdd->prepare('SELECT titre FROM stages WHERE idstage= ?');
	$query->execute(array($ligne['choix4']));
	$ligne1=$query->fetch();
	$choix[3]=$ligne1['titre'];
 	 //---------------------------------------------------------------------//
	$query=$bdd->prepare('SELECT titre FROM stages WHERE idstage= ?');
	$query->execute(array($ligne['choix5']));
	$ligne1=$query->fetch();
	$choix[4]=$ligne1['titre'];
	//----------------------------------------------------------------------//
	$entre=$bdd->prepare("SELECT affecter FROM $table_choix WHERE idb=?");
	$entre->execute(array($_SESSION['idb']));
	$etat=$entre->fetch();
	$affecter=$etat['affecter'];

 	}
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
			 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px;">
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
						<button id="ensemble" class="list-group-item active" onclick="document.location.href='noschoix.php'">Nos Choix</button>
						<button id="mesnotes" class="list-group-item" onclick="document.location.href='nosnotes.php'">Nos Notes</button>
					</ul>
			 	</div>

			 	<div class="col-sm-12 col-md-8 col-lg-8" style="margin-top:40px;">
			 		<?php if(strcmp($value, 'Modifier')==0){ ?>
			 		<div id="meschoix">
			 		
			 			<table class="table table-bordered table-striped table-condensed">
			 				<caption>Vos Choix</caption>
			 				<head>
			 					<tr>
				 					<th>Prioritè</th>
				 					<th>Stage</th>
			 					</tr>
			 				</head>
			 				<tbody>
			 					<?php
			 							for($i=0 ;$i<=4; $i++) 
			 							{
			 								$j=$i+1;
			 								echo "<tr class='active' >";
				 								echo "<td>$j</td>";
				 								echo "<td>$choix[$i]</td>";
				 							echo "</tr>";
			 							}
			 					?>			
			 				</tbody>
			 			</table>
			 		</div>	

			 		<?php }else{ ?>
				 		<div id="vide" class="starter-template">
				 				<h1 align="pull-left">Oops..</h1>
				 				<p class="lead">Pensser à faire vos Choix<strong style="color:red;"> le plus vite possible</strong> </p>
				 				<h3><small class="pull-right" style="color:gray;" >Bonne Chance</small></h3>
				 				</br>
				 		</div>
			 		<?php } ?>			 					 				
			 	</div>	
		</section>			
		<footer id="footer">

		</footer>
	</div>
	<script>
		var affecter='<?php echo $affecter ?>';
		var vue='<?php echo $_SESSION['vue'] ?>';
		var vue1='<?php echo $_SESSION['vue1'] ?>';
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
 	  	}
	</script>
</body>
</html>