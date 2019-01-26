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
 	//---------------------------------------------------------------//extraction de stage dont le binôme est affecté
 	function getNote($modules,$note){
 		$s=0;
 		foreach ($note as $key2 => $value2) {
 			$s=$s+$modules[$key2]*$note[$key2];
 		}
 		return $s;
 	}

 	$ligne2=$bdd->prepare("SELECT * FROM $table WHERE id_binome=? ");
 	$ligne2->execute(array($_SESSION['idb']));
 	$aff=$ligne2->fetch();

 	if(empty($aff['affectation'])){
 		$aff_ind='Vide'; //affectation indice

 		//------pour savoir si le binôme est affectè pendant le lancement de l'algo ou pas encore------//

 		$etat_q=$bdd->query("SELECT COUNT(idb) as total from $table_choix where affecter=0 ");
 		$total=$bdd->query("SELECT COUNT(idb) as total from $table_choix ");
 		$total=$total->fetch();
 		$etat_q=$etat_q->fetch();
 		if(strcmp($total['total'], $etat_q['total'])==0) $affecter=-1;
 		//==================================================================================================//
 		$compteur=0;
 		$list=$bdd->prepare('SELECT idstage FROM stages where niveau=? and formation=? and affectation=0 and satisfaction=0');
 		$list->execute(array($_SESSION['niveau'],$_SESSION['formation']));

 		while($ligne_stage=$list->fetch()){

 			// obtention du list des modules du stage i
 			$modules_list_stage=$bdd->prepare('SELECT * from stages_detail where idstage=? ');
 			$modules_list_stage->execute(array($ligne_stage['idstage']));
 			$list_module=$modules_list_stage->fetch();
 			//---calcul du note du binôme dans ce stage i---//

 			$noteB_stageI[$compteur] = new Choix();
 			$noteB_stageI[$compteur]->node['stage']=$ligne_stage['idstage'];
 			$noteB_stageI[$compteur]->node['Note']=getNote($list_module,$notes);
 			$compteur=$compteur+1;
 		}
 	}
  	$query=$bdd->prepare('SELECT COUNT(idstage) as nombre from stages WHERE niveau=? and formation=? AND affectation=0');
 	$query->execute(array($_SESSION['niveau'],$_SESSION['formation']));
 	$lign_number=$query->fetch();

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
			 	<div class="jumbotron" style="padding:0.5em;  width:1152px; margin-left:-10px;">
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
						<button id="choix" class="list-group-item" onclick="document.location.href='resultats.php'">Resultats d'Affectation</button>						
						<button id="stages_detail" class="list-group-item   active" onclick="document.location.href='list-stages.php'">Stages</button>
						<button id="ensemble" class="list-group-item " onclick="document.location.href='noschoix.php'">Nos Choix</button>
						<button id="mesnotes" class="list-group-item" onclick="document.location.href='nosnotes.php'">Nos Notes</button>
					</ul>
			 	</div>

			 	<div class="col-sm-12 col-md-8 col-lg-8" style="margin-top:40px;">
			 		<?php if(!empty($lign_number['nombre'])) { ?>
				 		<div id="stages">

						<?php
			 				$query=$bdd->prepare('SELECT * from stages WHERE niveau=? and formation=? and affectation=0');
			 				$query->execute(array($_SESSION['niveau'] ,$_SESSION['formation'])); ?>
			 				
				 			<table class="table table-bordered table-striped table-condensed">
				 				<caption>Liste des stages</caption>
				 				<head>
				 					<tr>
					 					<th>Titre</th>
					 					<th>Votre nôte</th>
					 					<th>Detail</th>
				 					</tr>
				 				</head>
				 				<tbody>
				 					<?php $c=0;
						 				while($ligne=$query->fetch()){
						 					echo "<tr class='active' >";
						 						echo "<td>".$ligne['titre']."</td> ";
						 						echo "<td>".$noteB_stageI[$c]->node['Note']."</td>";
						 						echo "<td> <a href='detail_stage.php?idstage=".$ligne['idstage']."' >Voir plus..<a> </td>";
						 					echo "</tr>";
						 					$c=$c+1;	
						 				}
				 					?>		
				 				</tbody>
				 			</table>		 				
				 			
				 		</div>	

						<?php }else{ ?>
							<div class="row" >
								<div class="form-group">
									 <div class="col-md-12 col-sm-12 col-lg-12">
					  				  	<div class="alert alert-info">
											<strong>Pas de stages pour le moments veuillez contacter vos prof</strong>
										</div>
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
 			if(affecter==0 && vue1==0){
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