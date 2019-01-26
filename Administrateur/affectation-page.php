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
    //-------------------------------------------------------//

 	$query1=$bdd->query('SELECT * FROM annonce_admin WHERE niveau=\'1A\'');
 	$ligne1=$query1->fetch();

 	if(empty($ligne1)) $value='Enregistrer';
 	else $value='Modifier';

 	$query2=$bdd->query('SELECT * FROM annonce_admin WHERE niveau=\'2A\'');
  	$ligne2=$query2->fetch();

 	if(empty($ligne2)) $value1='Enregistrer';
 	else $value1='Modifier';
 	

    //------------------------------------------------------//
 	$aff_1a=$bdd->query('SELECT affectation FROM binomes1a');
 	$aff_1a=$aff_1a->fetch();

 	if(empty($aff_1a['affectation'])) $aff_ind='Vide';
 	else $aff_ind='VideBar';
 	//------------------------------------------------------//
 	$aff_2a=$bdd->query('SELECT affectation FROM binomes2a');
 	$aff_2a=$aff_2a->fetch();

 	if(empty($aff_2a['affectation'])) $aff2a_ind='Vide';
 	else $aff2a_ind='VideBar';
	$_SESSION['vue']=1;


?>
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
			 	<div class="jumbotron" style="padding:0.5em;">
			 		<h1>AGS</h1>
			 		<h5 style="color:red;"><p>Espace Administrative</p></h5>
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
			 			    <button id="btn-affectation" class="list-group-item list-group-item-info active" onclick="document.location.href='affectation-page.php'">Annoncer une Affectation</button>
			 		   		<button id="btn-deroulement" class="list-group-item "  onclick="document.location.href='deroulement.php'">Dérouler l'affectation</button> 
			 			    <button class="list-group-item" id="stagiaires" onclick="document.location.href='stagiaires-selection.php'">Gestion des Stagiaires</button>
			 			    <button class="list-group-item" id="employeurs" onclick="document.location.href='professeurs.php'">Gestion des Employeurs</button>
				 		</div>
			    	</div>
			    	<div class="col-sm-12 col-md-8 col-lg-8" style="margin-top:50px;">
			    			<form id="form" class="form-horizontal" action="annonce-affectation.php" method="post" >

			    			    <fieldset>
			    			    	<legend>Information d'annonce</legend>
						    			<div class="row">
						    				<div class="form-group">
						    					<label type="text" class="col-md-2" style="margin-left:30px;" >Nom :</label>
						    					<div class="col-md-9">
						    						<input type="text" name="annonce" class="form-control" placeholder="Nom d'annonce" required>
						    					</div>
						    				</div>
						    			</div>			    			    	
			    			    </fieldset>

				    			<fieldset>
									<legend>Date</legend>

						    			<div class="row">
						    				<div class="form-group">
						    					<label type="text" class="col-md-2" style="margin-left:30px;" >Publication:</label>
						    					<div class="col-md-9">
						    						<input type="date" name="datep"  class="form-control">
						    					</div>
						    				</div>
						    			</div>
						    			</br>

						    			<div class="row">
						    				<div class="form-group">
						    					<label type="text" class="col-md-2" style="margin-left:30px;" >Expiration:</label>
						    					<div class="col-md-9">
						    						<input type="date" name="datex" class="form-control">
						    					</div>
						    				</div>
						    			</div>
						    			</br>

				    			</fieldset>

				    			<fieldset>
				    				<legend>Scolaire</legend>
						    			<div class="row">
						    				<div class="form-group">
						    					<label type="text" class="col-md-2" style="margin-left:30px;">Niveau:</label>
						    						<div class=" col-md-9">
									   					<select class="form-control pull-right " id="niveau" name="niveau" required>
									   						<option value="Default">Default</option>
									   						<option value="1A">1A</option>
									   						<option value="2A" >2A</option>
									   					</select>		    						
						    						</div>
						    				</div>
						    			</div>

				    			</fieldset>	

								<div class="row">
				  		  			  <div class="form-group">
				  		  				 <div class="col-md-2" style="margin-left:30px;" ></div>
				  		  			     <div  class="col-md-9" >

					  				  			<div id="1af" class="alert alert-infos" hidden="hidden">
													<strong>y'a déjè une Affectation pour cette selection,Enregistrer quant même ?</strong>
												</div>
					  				  			<div id="aff" class="alert alert-danger" hidden="hidden">
													<strong>déjà affectès !</strong>
												</div>												

				  		  			     </div>

									<input type="submit" id="but" class="btn btn-success col-md-3" value="Valider" style="margin-left:555px;" >
		  							  </div>								
								</div>	

			    			</form>			    		
			    	</div>
			    </div>
			   </section>
		</div>
		<script>

	  		var val='<?php echo $value ?>';
	  		var val1='<?php echo $value1 ?>';
			var aff_ind='<?php echo $aff_ind ?>';
	  		var select=document.getElementById('niveau');

	  		select.addEventListener('change',function (){

		  				if(select.options[select.selectedIndex].innerHTML=='1A')
		  				{
		  					document.getElementById('aff').hidden=true;

		  					if(aff_ind=='Vide'){

			  					if(val=='Modifier') 
			  					{
			  						document.getElementById('2af').hidden=true;
			  						document.getElementById('1af').hidden=false;
			  					}else{
			  						document.getElementById('2af').hidden=true;
			  					}		  
		  					}else document.getElementById('aff').hidden=false;
		  					
		  				}else if(select.options[select.selectedIndex].innerHTML=='2A') {

		  					document.getElementById('aff').hidden=true;

							if(val1=='Modifier')
							{
		  						document.getElementById('1af').hidden=true;
		  						document.getElementById('2af').hidden=false;								
							}else{
								document.getElementById('1af').hidden=true;
							}	
  					
		  				}else{	
		  					document.getElementById('aff').hidden=true;	  					
		  				}
		  		},true); 
		</script>
	</body>
</html>			    	