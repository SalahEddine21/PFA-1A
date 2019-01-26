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

	$query=$bdd->query('SELECT * from annonce_admin where  niveau=\'1A\' ');
	$query=$query->fetch();
	$q1=0; $q2=0;
	if(empty($query['expiration'])) $q1=1;
	$query1=$bdd->query('SELECT * from annonce_admin where  niveau=\'2A\' ');
	$query1=$query1->fetch();
	if(empty($query1['expiration'])) $q2=1;

	$Binomes1a = $bdd->query('SELECT count(id_binome) as nombre from Binomes1a');
	$Binomes1a = $Binomes1a->fetch();
	$Binomes2a = $bdd->query('SELECT count(id_binome) as nombre from Binomes2a ');
	$Binomes2a = $Binomes2a->fetch();
	$affected1a = $bdd->query('SELECT count(id_binome) as nombre from Binomes1a where affectation <> 0 and satisfaction <> 0 ');
	$affected1a = $affected1a->fetch();
	$affected2a = $bdd->query('SELECT count(id_binome) as nombre from Binomes2a where affectation <> 0 and satisfaction <> 0 ');
	$affected2a = $affected2a->fetch();

	if(!empty($Binomes1a['nombre'])){
		if( intval($Binomes1a['nombre']) == intval($affected1a['nombre']) ) $q1=1;
	} 
	if(!empty($Binomes2a['nombre'])){
		if( intval($Binomes2a['nombre']) == intval($affected2a['nombre']) ) $q2=1;
	}

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
						<li class="active"><a href="imports-selection.php">Accueil</a></li>						
					</ul> 
					<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
				</nav>
			</div>
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em;  width:1152px; margin-left:-10px;">
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
			 			   <button id="btn-import" class="list-group-item list-group-item-info active"  onclick="document.location.href='imports-selection.php'">Importer un Fichier</button>
			 			   <button class="list-group-item" onclick="document.location.href='addformation.php'" >Ajouter une formation</button>
			 			   <button id="btn-affectation" class="list-group-item" onclick="document.location.href='affectation-page.php'">Annoncer une Affectation</button>
			 		   		<button id="btn-deroulement" class="list-group-item "  onclick="document.location.href='deroulement.php'">Dérouler l'affectation</button> 
			 			    <button class="list-group-item" id="stagiaires" onclick="document.location.href='stagiaires-selection.php'">Gestion des Stagiaires</button>
			 			    <button class="list-group-item" id="employeurs" onclick="document.location.href='professeurs.php'">Gestion des Employeurs</button>
				 		</div>
			    	</div>
			    	<div class="col-sm-12 col-md-8 col-lg-8"  style="margin-top:50px;" >

						<form  id="import" class="form-horizontal" action="imports-page.php" method="post" enctype="multipart/form-data">

							<div class="row">
					   			<div class="form-group">
					   				<legend style="margin-left:5px;" >Fichier des:</legend>
					   			</div>
							</div>

				   			<div class="row">
					   			<div class="form-group">
					   			<label type="text" class="col-md-2 col-lg-2 col-sm-12">Niveau:</label>
						   			<div class="col-md-10 col-lg-10">
					   					<select class="form-control" name="personne" id="preso" required>
					   						<option value="Professeur">Professeurs</option>
					   						<option value="Etudiants">Etudiants</option>
					   					</select>						   				
						   			</div>
					   			</div>
				   			</div>
						   	<div class="form-group"><input type="submit" id="but" class="pull-right btn btn-primary" value="Suivant"></div>	
						   	</br>

						</form>
					</div>
				</div>
			</section>
		</div>
		<script>
		
		var vue='<?php echo $_SESSION['vue'] ?>';

		if(vue == 0)
		{
			var exp1a='<?php echo $query['expiration'] ?>';
			var q1='<?php echo $q1 ?>';
			var exp2a='<?php echo $query1['expiration'] ?>';
			var q2='<?php echo $q2 ?>';

			if(q1==0){
		  		var parts =exp1a.split('-');
		  		var expdate = new Date(parts[0],parts[1],parts[2]);
		  		var day = new Date();
		  		if(day.getFullYear()==expdate.getFullYear()){
		  			if((day.getMonth()+1)>expdate.getMonth()){
		  				d=31-day.getDate();
		  				d=d+expdate.getDate();
		  				m=(day.getMonth()+1)-expdate.getMonth();
		  				alert('Rappel: Affectation des 1A reste: '+m+' mois et '+d+' jours');
		  			}else if((day.getMonth()+1) == expdate.getMonth()){

		  				if(day.getDate() < expdate.getDate()){
		  					d=expdate.getDate()-day.getDate();
		  					alert('Rappel: Affectation des 1A reste: '+d+' jours');
		  				}else alert('Jour d\'affectation des 1A ');
		  			}
		  		}				
			}

			if(q2==0){
		  		var parts =exp2a.split('-');
		  		var expdate = new Date(parts[0],parts[1],parts[2]);
		  		var day = new Date();
		  		if(day.getFullYear()==expdate.getFullYear()){
		  			if((day.getMonth()+1)>expdate.getMonth()){
		  				d=31-day.getDate();
		  				d=d+expdate.getDate();
		  				m=(day.getMonth()+1)-expdate.getMonth();
		  				alert('Rappel: Affectation des 2A reste: '+m+' mois et '+d+' jours');
		  			}else if((day.getMonth()+1) == expdate.getMonth()){
		  				if(day.getDate()>expdate.getDate()){
		  					d=expdate.getDate()-day.getDate();
		  					alert('Rappel: Affectation des 2A reste: '+d+' jours');
		  				}
		  			}
		  		}				
			}
		}
		</script>
	</body>
</html>		