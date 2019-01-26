<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');
    try
    {
		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
    }catch(Exception $e)
    {
     	echo 'Error : '.$e.getmessage();
    }

    //------------------------------------------------------//
 	$aff_1a=$bdd->query('SELECT affectation FROM binomes1a');
 	$aff_1a=$aff_1a->fetch();

 	if(empty($aff_1a['affectation'])){
 		$aff_ind='Vide';
 		$etat_aff='noone';
 		}
 	else{

 		$aff_ind='VideBar';
	 	$reste_1a=$bdd->query('SELECT COUNT(idb) as total from binomes1a_choix where affecter=1');
	 	$total=$bdd->query('SELECT COUNT(idb) as tous from binomes1a_choix');

	 	$reste_1a=$reste_1a->fetch();

		$total=$total->fetch();
		if(strcmp($reste_1a['total'], $total['tous'])==0) $etat_aff='affall';
		else $etat_aff='notall';
 	}
 	//------------------------------------------------------//
 	$aff_2a=$bdd->query('SELECT affectation FROM binomes2a');
 	$aff_2a=$aff_2a->fetch();

 	if(empty($aff_2a['affectation'])){
 		 $aff2a_ind='Vide';
 		 $etat_aff2a='noone';
 	}
 	else{

 		$aff2a_ind='VideBar';
	 	$reste_2a=$bdd->query('SELECT COUNT(idb) as total from binomes2a_choix where affecter=1');
	 	$total=$bdd->query('SELECT COUNT(idb) as tous from binomes2a_choix');

	 	$reste_2a=$reste_2a->fetch();

		$total=$total->fetch();
		if(strcmp($reste_2a['total'], $total['tous'])==0) $etat_aff2a='affall';
		else $etat_aff2a='notall';

 	}
 	//------------------------------------------------------//

 	$query1=$bdd->query('SELECT * FROM annonce_admin WHERE niveau=\'1A\'');
 	$ligne1=$query1->fetch();

 	if(empty($ligne1)) $value='Enregistrer';	
 	else{
 		$value='Modifier';
 		$query3=$bdd->query('SELECT Publication,Expiration FROM annonce_admin WHERE niveau=\'1A\' ');
 		$ligne3=$query3->fetch(); 
 	}

 	$query2=$bdd->query('SELECT * FROM annonce_admin WHERE niveau=\'2A\'');
  	$ligne2=$query2->fetch();

 	if(empty($ligne2)) $value1='Enregistrer';
 	else{
 		$value1='Modifier';
 	  	$query4=$bdd->query('SELECT Publication,Expiration FROM annonce_admin WHERE niveau=\'2A\' ');
 		$ligne4=$query4->fetch();
 	}

 	//------------------------------------------------------//

 	//------------------------------------------------------//
   $_SESSION['vue']=1;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>AGS-ADMIN</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
	<div class="container">
			<div class="row">
				<nav class="navbar navbar-inverse col-md-12 col-sm-12">
					<ul class="nav navbar-nav">
						<li><a href="imports-selection.php">Accueil</a></li>						
					</ul> 
					<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
				</nav>
			</div>
			<header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px;  ">
			 		<h1>AGS</h1>
			 		<h5><p style="color:red" >Espace Administrative</p></h5>
			 	</div>
			 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes, <strong style="color:red;"> ENSIAS </strong>   </p></h3>
			</header>
			<section>

			    <div class="row" style="margin-top:5px;">
					<div  class="col-sm-12 col-md-4 col-lg-4">
				 		<h4 class="w3-bar-item"><p>Menu</p></h4>
				 		<div>
			 			    <button id="btn-import" class="list-group-item"  onclick="document.location.href='imports-selection.php'">Importer un Fichier</button>
			 			    <button class="list-group-item" onclick="document.location.href='addformation.php'">Ajouter une formation</button>
			 			    <button id="btn-affectation" class="list-group-item" onclick="document.location.href='affectation-page.php'">Annoncer une Affectation</button>
			 		   		<button id="btn-deroulement" class="list-group-item list-group-item-info active"  onclick="document.location.href='deroulement.php'">Dérouler l'affectation</button> 
			 			    <button class="list-group-item" id="stagiaires" onclick="document.location.href='stagiaires-selection.php'">Gestion des Stagiaires</button>
			 			    <button class="list-group-item" id="employeurs" onclick="document.location.href='professeurs.php'">Gestion des Professeurs</button>
				 		</div>
			    	</div>
			    	<div class="col-sm-12 col-md-8 col-lg-8"  style="margin-top:50px;" >

					<form id="affectation_n"  class="form-horizontal" action="contraints-test.php" method="post"  onsubmit="return(aff());" >

			    				<div class="row">
			    						<div class="form-group">
			    							<label type="text" class="col-md-2">Niveau:</label>
			    							<div class="col-md-10">
			    								<select id="niveau_affectation" name="level" class="form-control" >
			    									<option value="default">Default</option>
			    									<option value="1A">1A</option>
			    									<option value="2A">2A</option>
			    								</select>
			    							</div>
			    						</div>
			    				</div>

			    				<div id="date-1a" hidden="hidden" >
			    						<div class="row">
			    							<div class="form-group">
				    							<label type="text" class="col-md-2">Publication:</label>
			    									<div class="col-md-10">
			    										<label type="text" class="form-control"><?php echo $ligne3['Publication'] ?></label>
			    									</div>
			    							</div>
			    						</div>
			    						<div class="row">
			    							<div class="form-group">
				    							<label type="text" class="col-md-2">Expiration:</label>
			    									<div class="col-md-10">
			    										<label type="text" class="form-control"><?php echo $ligne3['Expiration'] ?></label>
			    									</div>
			    							</div>
			    						</div>
			    				</div>
			    				
			    				<div id="date-2a" hidden="hidden">
			    						<div class="row">
			    							<div class="form-group">
				    							<label type="text" class="col-md-2">Publication:</label>
			    									<div class="col-md-10">
			    										<label type="text" class="form-control"><?php echo $ligne4['Publication'] ?></label>
			    									</div>
			    							</div>
			    						</div>
			    						<div class="row">
			    							<div class="form-group">
				    							<label type="text" class="col-md-2">Expiration:</label>
			    									<div class="col-md-10">
			    										<label type="text" class="form-control"><?php echo $ligne4['Expiration'] ?></label>
			    									</div>
			    							</div>
			    						</div>
			    				</div>

			    				<div class="row">
			    					<div class="form-group">
			    							<div id="out" hidden="hidden">
			    								<label type="text" class="col-md-2" style="margin-top:-15px;" ></br>Affectation: </label>
			    								<div class="col-md-10">
					  				  					<div id="1af" class="alert alert-info">
															<strong style="color:gray">expiré</strong>
														</div>			    									
			    								</div>
			    							</div>
			    							<div id="na-vide" hidden="hidden">
			    								 		<div class="col-md-2"></div>
			    								 	<div class="col-md-10">
					  				  					<div  class="alert alert-warning">
															<strong>Y'a aucune Annonce,Veuillez Ajouter une !</strong>
														</div>				    								 	
			    								    </div>
			    							</div>	
			    							<div id="aff_ex" hidden="hidden">
			    								 		<div class="col-md-2"></div>
			    								 	<div class="col-md-10">
					  				  					<div  class="alert alert-info">
															<strong>Les Binômes sont déjà affectés !</strong>
														</div>				    								 	
			    								    </div>
			    							</div>		

			    							<div id="aff_re" hidden="hidden">
			    								 		<div class="col-md-2"></div>
			    								 	<div class="col-md-10">
					  				  					<div  class="alert alert-info">
															<strong>2 éme étape</strong>
														</div>				    								 	
			    								    </div>
			    							</div>		

			    						<button id="submit" type="submit" class="btn btn-default col-md-3" style="margin-left:590px;" >Affecter</button>
			    					</div>
			    				</div>

			    		</form>			    		
			    	</div>
			    </div>
			</section>
	</div>	
	<script>
				var niveauaffectation=document.getElementById('niveau_affectation');
	  			var pub1a='<?php echo $ligne3['Publication'] ?>';
	  			var exp1a='<?php echo $ligne3['Expiration'] ?>';
		  		var parts =exp1a.split('-');
		  		var expdate = new Date(parts[0],parts[1],parts[2]);


		  		var day = new Date();


		  		var indicateur=false;
		  		// indice d'affectation des 1A //
		  		var aff_ind='<?php echo $aff_ind ?>';  // si les 1A sont affectès
		  		var aff2a_ind='<?php echo $aff2a_ind ?>';
	  			var val='<?php echo $value ?>';
	  			var val1='<?php echo $value1 ?>';

	  			niveauaffectation.addEventListener('change',function(){

	  				if(niveauaffectation.options[niveauaffectation.selectedIndex].innerHTML=='1A')
	  				{
		  				document.getElementById('date-2a').hidden=true;	  	
		  				document.getElementById('out').hidden=true;
		  				document.getElementById('na-vide').hidden=true;
		  				document.getElementById('aff_re').hidden=true;

	  					if(aff_ind=='Vide'){ //s'ils sont pas encore affecter
		  					document.getElementById('aff_ex').hidden=true;

		  					if(val=='Modifier'){

		  							document.getElementById('date-1a').hidden=false;
		  							indicateur=true; //indicateur de l'envoie (test si y'a une affectation)
			  						if(day.getFullYear()==expdate.getFullYear()) 
		  							{

		  								if((day.getMonth()+1)>expdate.getMonth() || day.getDate()>expdate.getDate()) {
		  									document.getElementById('out').hidden=false;
		  									document.getElementById('submit').className='btn btn-danger col-md-3';
		  								}
		  				

		  							}else if( day.getFullYear()>expdate.getFullYear() ) {
		  								document.getElementById('out').hidden=false;
		  								document.getElementById('submit').className='btn btn-danger col-md-3';
		  							}

		  					}else{
		  						document.getElementById('na-vide').hidden=false;
		  						indicateur=false; // pas d'affectation -> on block l'envoie
		  					} 
	  					}else{ // s'ils sont affecter
	  						var etat_aff='<?php echo $etat_aff ?>';
	  						if(etat_aff=='affall'){

		  						document.getElementById('aff_ex').hidden=false;
		  						//alert(indicateur);
		  						indicateur=false; // changer à false pour blocker l'envoie

	  						}else{
	  							document.getElementById('aff_re').hidden=false;
	  							indicateur=true;
	  						}

	  					}
	  				}else if(niveauaffectation.options[niveauaffectation.selectedIndex].innerHTML=='2A'){
	  					document.getElementById('date-1a').hidden=true;
	  					document.getElementById('out').hidden=true;
	  					document.getElementById('na-vide').hidden=true;
	  					document.getElementById('aff_ex').hidden=true;
	  					document.getElementById('aff_re').hidden=true;

	  						if(aff2a_ind=='Vide'){

		  						if(val1=='Modifier'){
		  							document.getElementById('date-2a').hidden=false;
		  							indicateur=true;

			  						if(day.getFullYear()==expdate.getFullYear()) 
		  							{

		  								if((day.getMonth()+1)>expdate.getMonth() || day.getDate()>expdate.getDate()) {
		  									document.getElementById('out').hidden=false;
		  									document.getElementById('submit').className='btn btn-danger col-md-3';
		  								}		  		

		  							} else if( day.getFullYear()>expdate.getFullYear() ) {
		  								document.getElementById('out').hidden=false;
		  								document.getElementById('submit').className='btn btn-danger col-md-3';
		  							}

		  						}else{
		  								document.getElementById('na-vide').hidden=false;
		  								indicateur=false;
		  						}
		  					}else{	
		  						etat_aff2a='<?php echo $etat_aff2a ?>';

		  						if(etat_aff2a=='affall'){

			  						document.getElementById('aff_ex').hidden=false;
			  						//alert(indicateur);
			  						indicateur=true; // changer à false pour blocker l'envoie

		  						}else{
		  							document.getElementById('aff_re').hidden=false;
		  							indicateur=true;
		  						}
		  					}		  						

		  			}else{
	  					document.getElementById('date-2a').hidden=true;
	  					document.getElementById('date-1a').hidden=true;
	  					document.getElementById('na-vide').hidden=true;
	  					document.getElementById('out').hidden=true;
	  					document.getElementById('aff_ex').hidden=true;
	  					indicateur=false;
	  				}
	  					  					
	  			},true);

			function aff(){

		    	if(indicateur==true) return true;
		    	return false;
		    }	
	</script>
</body>
</html>		 	