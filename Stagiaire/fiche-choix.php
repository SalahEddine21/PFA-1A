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

 	$stages_test=$bdd->prepare('SELECT count(idstage) as nombre from stages where formation = ? ');
 	$stages_test->execute(array($_SESSION['formation']));
 	$stage_data=$stages_test->fetch();

 	$binomes_test=$bdd->prepare("SELECT count(id_binome) as nombre from $table where formation = ? ");
 	$binomes_test->execute(array($_SESSION['formation']));
 	$binomes_data=$binomes_test->fetch();

 	if( ( intval($stage_data['nombre']) < intval($binomes_data['nombre']) ) or  (intval($stage_data['nombre']) < 5) )
 		header('location:stages_nsuff.php');
 	

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
 	
 	$query=$bdd->prepare("SELECT * FROM $table_choix WHERE idb=?");
 	$query->execute(array($_SESSION['idb']));
 	$ligne=$query->fetch();

 	if(empty($ligne)){
 	 	 $value='Enregistrer';
 	 	 $affecter=-1;
 	}
 	else{
	 	$entre=$bdd->prepare("SELECT affecter FROM $table_choix WHERE idb=?");
		$entre->execute(array($_SESSION['idb']));
		$etat=$entre->fetch();
		$affecter=$etat['affecter'];		
 		$value='Modifier';
 	}

 	$notes=array('M1'=>0,'M2'=>0,'M3'=>0,'M4'=>0,'M5'=>0,'M6'=>0,'M7'=>0,'M8'=>0);	
 	foreach ($notes as $key => $valeur) {
 		$m=$entre1[$key];
 		$m1=$entre2[$key];
 		$notes[$key]=($m+$m1)/2;
 	}

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
 		$formation=$_SESSION['formation'];

 		$etat_q=$bdd->prepare("SELECT COUNT(idb) as total from $table_choix where affecter=0 and idb in (select idb from $table where formation=? ) ");
 		$etat_q->execute(array($formation));
 		$etat_q=$etat_q->fetch();

 		$total=$bdd->prepare("SELECT COUNT(idb) as total from $table_choix where idb in (select idb from $table where formation=?) ");
 		$total->execute(array($formation));
 		$total=$total->fetch();
 
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

  	$annonce=$bdd->prepare('SELECT * FROM annonce_admin WHERE niveau= ?');
 	$annonce->execute(array($_SESSION['niveau']));
 	$ann_row=$annonce->fetch();

 	if(empty($ann_row)) $ann_ind='Vide';
 	else{
 		$ann_ind='VideBar';
	 	$date = date("j, n, Y");
	 	$parts = explode(",", $date); // date du jour
	 	$exited=false;
	 	$parts1=explode("-",$ann_row['expiration']); // date d'expiration
	 	if($parts[2] > $parts1[0]) $exited=true;
	 	else if($parts[1] > $parts1[1]) $exited=true;
	 	else if($parts[0]>$parts1[2]) $exited=true;
 	}
 	//-------------------------------------------------------------------------------------------------------------------//

 	//-------------------------------------------------------------------------------------------------------------------//
 	$query=$bdd->prepare('SELECT COUNT(idstage) as nombre from stages WHERE niveau=? and formation=? AND affectation=0');
 	$query->execute(array($_SESSION['niveau'],$_SESSION['formation']));
 	$lign_number=$query->fetch();
 	$bound=$lign_number['nombre'];
 	if($bound>5) $bound=5;
 	$_SESSION['vue1']=1;
 	$_SESSION['vue2']=1;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
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
						<button id="choix" class="list-group-item  active" onclick="document.location.href='fiche-choix.php'">Fiche des Choix</button>
						<button id="choix" class="list-group-item" onclick="document.location.href='resultats.php'">Resultats d'Affectation</button>						
						<button id="stages_detail" class="list-group-item" onclick="document.location.href='list-stages.php'">Stages</button>
						<button id="ensemble" class="list-group-item " onclick="document.location.href='noschoix.php'">Nos Choix</button>
						<button id="mesnotes" class="list-group-item" onclick="document.location.href='nosnotes.php'">Nos Notes</button>
					</ul>
			 	</div>

			 	<div class="col-sm-12 col-md-8 col-lg-8" style="margin-top:40px;">
			 		<?php if(!empty($bound)) { ?>								
	 				 <form  id="form" class="form-horizontal" action="enregistrement-choix.php" method="post" onsubmit="return(test());">
	  				
			 			<div class="starter-template">
			 				<h1>Stages Disponible (<?php echo $aff['formation'] ?>)</h1>
			 				<p class="lead">c'est fortement recommendèe de Choisir des stages</br>
			 				<strong style="color:red">Convenable</strong> à vos Notes</p>
			 				<small class="pull-right btn btn-danger">Bonne Chance</small>
			 				</br>
			 			</div>
			 			<div style="margin-left:10px;">

				 			<?php echo '</br>';
				 				for($i=1; $i<=$bound ;$i++)
				 				{
				 					echo '</br>';
		 						 $query=$bdd->prepare('SELECT * from stages WHERE niveau=? and formation=? and affectation=0');
		 						 $query->execute(array($_SESSION['niveau'] ,$_SESSION['formation']));
		 						 $c=0;
		 							 echo
		 							 	'<div class="row">
		 							 		<div class="form-group">
		 							 		 <label type="text" class="col-md-2">Choix'.$i.':</label>
		 							 		  <div class="col-md-10">
				 							 	<select id='.$i.' name='.$i.' class="form-control">';
		 							 while($ligne=$query->fetch()) 
		 							 {

				echo '<option value='.$ligne['idstage'].'>'.$ligne['titre'] . ' Nôte: '.$noteB_stageI[$c]->node['Note'].'</option>' ;
										$c=$c+1;
				 						// nôte du stagiaire dans ce stage
		 							 }
		 							 echo 
		 							 			'</select>
		 							 		  </div>
		 							 		 </div>
		 							 		</div>';

				 				}
				 			?>
			 			</div>
			 			<input type="hidden" id="nombre_choix" name="nombre_choix" >

						<div id="danger" class="row" hidden="hidden" style="margin-left:10px;" >
							<div class="form-group">
								<label class="col-md-2" style="color:red"></label>
		  				    	<div  class="form-group col-md-10">
		  				  			<div class="alert alert-danger">
										<strong>Stage redoublè !!</strong>
									</div>
		  						</div>
							</div>
						</div>

						<div id="modification_choix" class="row" hidden="hidden" style="margin-left:10px;" >
							<div class="form-group">
								<label class="col-md-2" style="color:red"></label>
		  				    	<div  class="form-group col-md-10">
		  				  			<div class="alert alert-info">
										<strong>Vous avez déjà fait vos choix,refaire des nouveaux si necessaire puis taper Modifier</strong>
									</div>
		  						</div>
							</div>
						</div>	
						<div id="etat_aff" class="row" hidden="hidden" style="margin-left:10px;" >
							<div class="form-group">
								<label class="col-md-2" style="color:red"></label>
		  				    	<div  class="form-group col-md-10">
		  				  			<div class="alert alert-danger">
										<strong>les stages que vous avez choisis ont étaient pris par les majorants, on vous invite à refaire vos choix dans les stages qui restent</strong>
									</div>
		  						</div>
							</div>
						</div>
			 			<div class="form-group">
			 				<button type="submit" id="envoie" name="valider" class="btn btn-primary pull-right"><?php echo $value ?></button>
			 			</div>
				</form>
				<?php }else{ ?>
					<div class="row" >
						<div class="form-group">
							 <div class="col-md-12 col-sm-12 col-lg-12">
			  				  	<div class="alert alert-info">
									<strong>Pas de stages pur le moments veuillez contacter vos prof</strong>
								</div>
							 </div>
						</div>
					</div>
				<?php } ?>
	
			 		
			 	</div>	
		</section>			

	</div>

		<script>
			var boolean;
		 	var exited='<?php echo $exited ?>';
		 	var affecter='<?php echo $affecter ?>';


			if(affecter==0) { 

 	  			Choix.hidden=false;
 	  			document.getElementById('etat_aff').hidden=false;

 	  		}else if(!exited){ // si non on verifie l'exigence des dates (pas encore depassè)

 	  			Choix.hidden=false;
 	  			if(boolean==false) document.getElementById('modification_choix').hidden=false;
 	  		}
 	  		else document.getElementById('out').hidden=false; // si le temp est dèpasser le binôme est out 

	 	  	function test()
	 	  	{
	 	  		var select,nextselect,boolean,nombre;
	 	  		nombre='<?php echo $bound ?>';
	 	  		document.getElementById('nombre_choix').value=nombre;

	 	  		for(i=1;i<nombre;i++) 
	 	  		{
	 	  			select=document.getElementById(i);
	 	  			for(j=i+1;j<=nombre;j++)
	 	  			{
	 	  				nextselect=document.getElementById(j);
	 	  				if(select.options[select.selectedIndex].innerHTML==nextselect.options[nextselect.selectedIndex].innerHTML) boolean=true;
	 	  			}
	 	  		}
	 	  		if(boolean==true){
	 	  			document.getElementById('danger').hidden=false;
	 	  			return false;
	 	  		}else{
	 	  			document.getElementById('danger').hidden=true;
	 	  			return true;
	 	  		}
	 	  	}
		</script>

	</body>

</html>		