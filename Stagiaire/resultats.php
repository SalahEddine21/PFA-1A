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
 	 if(empty($ligne)){
 	 	 $value='Enregistrer';
 	 	 $affecter=-1;
 	 }
 	 else $value='Modifier';
 	 //-------------------------Affichage des choix pour ceux qui l'ont déjà fait------------------------//
 	 $choix=array();

 	 if(strcmp($value, 'Modifier')==0){

		$entre=$bdd->prepare("SELECT affecter FROM $table_choix WHERE idb=?");
		$entre->execute(array($_SESSION['idb']));
		$etat=$entre->fetch();
		$affecter=$etat['affecter'];

		if($affecter == 1){

	 	$ligne2=$bdd->prepare("SELECT * FROM $table WHERE id_binome=? ");
	 	$ligne2->execute(array($_SESSION['idb']));
	 	$aff=$ligne2->fetch();	

 		$ligne3=$bdd->prepare('SELECT titre,description FROM stages WHERE idstage= ?');
 		$ligne3->execute(array($aff['affectation']));
 		$stage=$ligne3->fetch();

 		$ligne4=$bdd->prepare('SELECT email from employeurs where idemp in (select idemp from  stages_detail where idstage = ? ) ');
 		$ligne4->execute(array($aff['affectation']));
 		$emp=$ligne4->fetch();

		}else if($affecter==0){
			
			$query=$bdd->prepare("SELECT count(affecter) as affecter from $table_choix where affecter=1 and idb in (select idb from $table where formation=?) ");
			$query->execute(array($_SESSION['formation']));
			$ligne_n=$query->fetch();
			if(empty($ligne_n['affecter'] )) $affecter=-1;
		}

 	}
 	$_SESSION['vue']=1;
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
			 		<h3 style="color:red;" ><p>Bonjour <?php echo $_SESSION['nomb']?></p></h3>
			 	</div>
			 </header>

		<section class="row">
			 	<div class="col-sm-12 col-md-4 col-lg-4">
  					<h4 class="w3-bar-item"><b>Menu</b></h4>
			 		<ul class="list-group">
						<button id="profil" class="list-group-item" onclick="document.location.href='profil.php'">Annonce</button>
						<button id="choix" class="list-group-item" onclick="document.location.href='fiche-choix.php'">Fiche des Choix</button>
						<button id="resultat" class="list-group-item  active" onclick="document.location.href='resultats.php'">Resultats d'Affectation</button>						
						<button id="stages_detail" class="list-group-item" onclick="document.location.href='list-stages.php'">Stages</button>
						<button id="ensemble" class="list-group-item " onclick="document.location.href='noschoix.php'">Nos Choix</button>
						<button id="mesnotes" class="list-group-item" onclick="document.location.href='nosnotes.php'">Nos Notes</button>
					</ul>
			 	</div>

			 	<div class="col-sm-12 col-md-8 col-lg-8" style="margin-top:30px;">
			 		<?php if($affecter==-1){ ?>
								 	<div style="margin-top:25px;">
								 		<div class="row">
									 		<div class="form-group" >
										 				<div class="col-md-offset-1 col-md-9">
												 			<div class="alert alert-info" >
												 				<h2><strong>Pas Encore !</strong></h2>
												 				<p>L'administrateur n'a pas lançé l'algorithme ,veuillez consulter régulièrement cette page et n'oublier surtout pas de faire vos choix,Merci</p>
												 			</div>
											 			</div>
										 		</div>
								 			</div>
								 	</div>
					<?php }else if($affecter==0){ ?>
						<div id="etat_aff" class="row" style="margin-left:10px;" >
							<div class="form-group">
								<label class="col-md-2" style="color:red"></label>
		  				    	<div  class="form-group col-md-10">
		  				  			<div class="alert alert-danger">
										<strong>les stages que vous avez choisis ont étaient pris par les majorants, on vous invite à refaire vos choix dans les stages qui restent (taper sur la fiche des choix ) </strong>
									</div>
		  						</div>
							</div>
						</div>
					<?php }else { ?>
			 		<div id="affected" class="row"  >
			 		
			 			<h2><strong style="font-family: Verdana;" >C'est Fait</strong>,Voilà le resultats: </h2>
			 			</br>
			 			<div class="form-group">
			 				<label type="text" class="col-md-2" >Votre Id: </label>
			 				<div class="col-md-10">
			 					<label type="text" class="form-control"><?php echo $_SESSION['idb'] ?></label>
			 				</div>	

			 				<label type="text" class="col-md-2" >Votre Nom: </label>
			 				<div class="col-md-10">
			 					<label type="text" class="form-control"><?php echo $_SESSION['nomb'] ?></label>
			 				</div>

			 				<label type="text" class="col-md-2" >Votre Stage: </label>
			 				<div class="col-md-10">
			 					<label type="text" class="form-control"><?php echo $stage['titre'] ?></label>
			 				</div>	

			 				<label type="text" class="col-md-2" >Description Stage: </label>
			 				<div class="col-md-10">
			 					<label type="text" class="form-control"><?php echo $stage['description'] ?></label>
			 				</div>				 						 				
			 			</div>
			 		</div>
			 		<div class="row" >
			 			<div class="form-group" >
			 				<label type="text" class="col-md-2" >Email encadrant: </label>
			 				<div class="col-md-10">
			 					<label type="text" class="form-control"><?php echo $emp['email'] ?></label>
			 				</div>	
			 			</div>
			 		</div>	
			 		<?php } ?>	
			 	</div>	
		</section>			

	</div>
	<script>
		var affecter='<?php echo $affecter ?>';
		var vue1='<?php echo $_SESSION['vue1'] ?>';

		if(affecter==1){
				document.getElementById('choix').disabled=true;
				document.getElementById('stages_detail').disabled=true;			
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