
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
	 //--------------------------------------//

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
						<li><a href="Accueil.html" >AGS</a></li>
						<li class="active"><a href="admin.php">Administrateur</a></li>						
					</ul> 
					<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
				</nav>
			</div>
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px; ">
			 	<div class="jumbotron" style="padding:1.0em; width:1152px; margin-left:-10px;">
			 		<h1 >AGS</h1>
			 		<h5 style="color:red;"><p>Espace Administrative</p></h5>
			 	</div>
			 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes, ENSIAS  </p></h3>
			 </header>
			 <section>

			    <div class="row" style="margin-top:5px;">
					<div  class="col-sm-12 col-md-4 col-lg-4">
				 		<h4 class="w3-bar-item"><p>Menu</p></h4>
				 		<div>
			 			    <button id="profil" class="list-group-item list-group-item-info active"  onclick="document.location.href='profil.php'">Profil</button> 
			 			    <button id="btn-import" class="list-group-item"  onclick="document.location.href='imports-selection.php'">Importer un Fichier</button>
			 			    <button class="list-group-item" onclick="document.location.href='addformation.php'" >Ajouter une formation</button>
			 			    <button id="btn-affectation" class="list-group-item" onclick="document.location.href='affectation-page.php'">Annoncer une Affectation</button>
			 		   		<button id="btn-deroulement" class="list-group-item "  onclick="document.location.href='deroulement.php'">Dérouler l'affectation</button> 
			 			    <button class="list-group-item" id="stagiaires" onclick="document.location.href='stagiaires-selection.php'">Gestion des Stagiaires</button>
			 			    <button class="list-group-item" id="employeurs" onclick="document.location.href='professeurs.php'">Gestion des Employeurs</button>
				 		</div>
			    	</div>
			    	<div class="col-sm-12 col-md-8 col-lg-8"  style="margin-top:50px;" >

						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Information</h3>
							</div>
							<div class="panel-body">Contenu</div>
								
							</div>
			    	</div>

			    </div>
			 </section>
	  </div>
	  	<script>
	  			//---------------------------------------------------------------------------------//
	  	</script>
</body>
</html>

