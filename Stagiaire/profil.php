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

 	//include_once('classes.php');
	class Choix
	{
		public $node;

		function __construct()
		{
				$this->node=array('stage'=>0,'Note'=>0);
		}

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
 	 if(empty($ligne['idb'])){
 	 	 $value='Enregistrer';
 	 	 $affecter=-1;
 	 	 $choix_v=0;
 	 }
 	 else $value='Modifier';

 	//-------------------------Affichage des choix pour ceux qui l'ont déjà fait------------------------//

 	$choix=array();
 	if(strcmp($value, 'Modifier')==0){
	$entre=$bdd->prepare("SELECT affecter FROM $table_choix WHERE idb=?");
	$entre->execute(array($_SESSION['idb']));
	$etat=$entre->fetch();
	$affecter=$etat['affecter'];
	$choix_v=1;

		if($affecter==0){
			$entre=$bdd->prepare("SELECT COUNT(idb) as nombre from $table_choix where affecter=1 and idb in (select idb from $table where formation=?) ");
			$entre->execute(array($_SESSION['formation'] ));
			$ligne_n=$entre->fetch();
			if(empty($ligne_n['nombre'])) $affecter=-1;
		}
 	}

 	$ligne2=$bdd->prepare("SELECT * FROM $table WHERE id_binome=? ");
 	$ligne2->execute(array($_SESSION['idb']));
 	$aff=$ligne2->fetch();

 	if(empty($aff['affectation'])){
 		$aff_ind='Vide'; //affectation indice
 	}else{
 		 $aff_ind='VideBar';
 		 $ligne3=$bdd->prepare('SELECT titre,description FROM stages WHERE idstage= ?');
 		 $ligne3->execute(array($aff['affectation']));
 		 $stage=$ligne3->fetch();
 	}
 	//----------------------------------extraction des annonces selon le niveau du binôme----------------------------------//
  	$annonce=$bdd->prepare('SELECT * FROM annonce_admin WHERE niveau= ?');
 	$annonce->execute(array($_SESSION['niveau']));
 	$ann_row=$annonce->fetch();

 	if(empty($ann_row)) $ann_ind='Vide';
 	else{

 		$ann_ind='VideBar';
	 	$date = date("j, n, Y");
	 	$parts = explode(",", $date); // date du jour
	 	$exited='false';
	 	$parts1=explode("-",$ann_row['expiration']); // date d'expiration
	 	if($parts[2] > $parts1[0]) $exited='true';
	 	else if($parts[1] > $parts1[1]){

	 		$exited='true';
	 	}
	 	else if($parts[0]>$parts1[2]){
	 		 $exited='true';
	 	}

	 	if(strcmp($exited, 'true')!=0){
	 		if($parts[1] < $parts1[1] ){
		 		$m=intval($parts1[1]) - intval($parts[1]);
		 		$d=31- intval($parts[0]);
		 		$d=$d+ intval($parts1[2]);

		 		$delai='il vous reste: '.$m.' mois et '.$d.' jours';
	 		}else if( $parts[1] == $parts1[1] ){
	 				$d= intval($parts1[2]) - intval($parts[0]);
		 		 	$delai='il vous reste '.$d.' jours';
		 	}
	 	}
 	}
 	
 	$_SESSION['affecter']=$affecter;
 	$_SESSION['exited']='false';

 	?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Stagiaire</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
 	  <div class="container">
			<div class="row">
				<nav class="navbar navbar-inverse col-md-12 col-sm-12">
					<ul class="nav navbar-nav">
						<li class="active"><a href="profil.php">Accueil</a></li>						
					</ul> 
					<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
				</nav>
			 </div>  
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px;">
			 		<h1>AGS</h1>
			 		<h3 style="color:red;" ><p>Bonjour <?php echo $_SESSION['nomb']?></p></h3>
			 	</div>
			 </header>
			 <section class="row">
			 	<div class="col-sm-12 col-md-4 col-lg-4">
  					<h4 class="w3-bar-item"><b>Menu</b></h4>
			 		<ul class="list-group">
						  <button id="profil" class="list-group-item active" onclick=onclick="document.location.href='profil.php'">Annonce</button>
						<button id="choix" class="list-group-item" onclick="document.location.href='fiche-choix.php'">Fiche des Choix</button>
						<button id="resultat" class="list-group-item" onclick="document.location.href='resultats.php'">Resultats d'Affectation</button>
						<button id="stages_detail" class="list-group-item" onclick="document.location.href='list-stages.php'">Stages</button>
						<button id="ensemble" class="list-group-item " onclick="document.location.href='noschoix.php'">Nos Choix</button>
						<button id="mesnotes" class="list-group-item" onclick="document.location.href='nosnotes.php'">Nos Notes</button>
					</ul>
			 	</div>

			 	<div class="col-sm-12 col-md-8 col-lg-8" style="margin-top:40px;">

			 		<div id="profilshow" class="row" >
			 				</br>
			 				<div id="notyet">
								<?php
									
									 if($affecter==-1){
											if(strcmp($exited, 'false')==0){

								?>		 	<div id="annonce" >
													<fieldset class="alert alert-info">Annonce-<?php echo $_SESSION['niveau'] ?></fieldset>
														<label type="text" class="col-md-2">Publication</label>
														<div class="col-md-10">
														<label type="text" class="form-control"><?php echo $ann_row['publication'] ?></label>
														</div>

														<label type="text" class="col-md-2">Expiration</label>
														<div class="col-md-10">
														<label type="text" class="form-control"><?php echo $ann_row['expiration'] ?></label>
														</div>								
											</div>
											<?php if($choix_v == 0 && $_SESSION['vue2']==0 ) {
												echo '<script> alert(\'Veuillez faire vos choix: '.$delai.' \'); </script>';
											} ?>
											<?php }else{ 
															$_SESSION['exited']='true';	?>	
								 			<div class="starter-template">
								 				<h1 style="color:red; margin-left:63px; margin-top:-1px;" >Temps écoulè</h1>
								 				<div class="row">
									 				<div class="form-group" >
										 				<div class="col-md-1" ></div>
										 					<div class="col-md-9">
												 				<div class="alert alert-danger" >
												 					<strong>Vous avez ratè la saisie des choix !</strong>
												 				</div>
											 				</div>
										 				</div>
								 				</div>
								 			</div>
											<script>
													document.getElementById('choix').disabled=true;
													document.getElementById('resultat').disabled=true;
													document.getElementById('stages_detail').disabled=true;
													document.getElementById('ensemble').disabled=true;
											</script>					
								<?php }
									}else if($affecter==0){ ?> 	

								 			<div class="starter-template">
								 				<h1 style="color:red; margin-left:63px; margin-top:-1px; font-family: 'Comic Sans MS';" >Annonce</h1>
								 				<div class="row">
									 				<div class="form-group" >
										 				<div class="col-md-1" ></div>
										 					<div class="col-md-9">
												 				<div class="alert alert-info" >
												 					<strong>Nous vous informons que les stages que vous avez choisit ont étaient pris par d'autre binômes plus benificiares,ainsi nous vous invitons à refaire des nouveaux choix dans les stages qui restent    </strong>
												 				</div>
												 				<small class="pull-right label label-danger">Bonne Chance</small>
											 				</div>
										 				</div>
								 				</div>
								 			</div>
								 			<script> document.getElementById('resultat').disabled=true; </script>
								<?php }else{ ?> 														 	
								 			<div class="starter-template">
								 				<h1 style="color:red; margin-left:45px; margin-top:-1px; font-family: 'Comic Sans MS' " >Affectation faite</h1>
								 				<div class="row">
									 				<div class="form-group" >
										 				<div class="col-md-1" ></div>
										 					<div class="col-md-9">
												 				<div class="alert alert-info" style="margin-left:-25px;" >
												 					<strong>Nous vous informons que l'affectation est lançè par l'Admin,Taper Sur Resultats </strong>
												 				</div>
											 				</div>
										 				</div>
								 				</div>
								 			</div>
								<?php } ?>															
			 				</div>

			 		</div>
						<div id="aff_show" class="row" hidden="hidden" style="margin-left:10px;" >
							<div class="form-group">

		  				    	<div  class="form-group col-md-12">
		  				  			<div class="alert alert-info">
										<strong>déjà affecter !</strong>
									</div>
		  						</div>
							</div>
						</div>			 		
			 	</div>
			 </section>
 	  </div>
  	  		<?php if(strcmp($value, 'Enregistrer')==0) 
 	  			  echo '<script>var boolean=true;</script>';
 	  			  else echo '<script>var boolean=false; </script>';
 	  		?>
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