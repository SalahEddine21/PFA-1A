<?php
	 session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Stagiaires</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
		<div class="container">
			<div class="row">
				<nav class="navbar navbar-inverse col-md-12 col-sm-12">
					<ul class="nav navbar-nav">
						<li class="active"><a href="enregistrement-binome.php" class="active">Finalisation</a></li>
					</ul> 
				</nav>
			 </div>  
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em;">
			 		<h1>AGS</h1>
			 		<p>Bonjour</p>
			 	</div>
			 </header>
			 <section class="row">
			 	<div class="col-sm-12 col-md-5 col-offset-md-1 col-offset-lg-1 ">
					 <h3><span class="label label-success">Finalisation d'inscription</span></h3>
				 		<blockquote>
				 			Votre Candidature a était Bien enregistrè</br>Veuillez Contacter Votre Binome à fin de remplir les informations
				 			devant et faire Vos premières choix</br>
				 			<p>Tapez ici pour une deuxième inscription</p>
				 			<button class="btn btn-success pull-right" onclick="document.location.href='Inscription.php'">Revenir</button>
				 			</br>
				 			<small class="pull-right"><p><span class="label label-danger">Bonne-Chance</span></p></small>
				 		</blockquote>		 		
			 	</div>
			 	<div class=" col-offset-lg-1 col-offset-md-1 col-sm-12 col-md-7 col-lg-7">

			 		<form class="form-horizontal" action="test.php" method="post" style="margin-top:30px;" >
			 			<div class="form-group">
			 				<legend>Information-Binômes</legend>
			 			</div>
			 			<fieldset>
						<fieldset>
					 			<div class="row">
					 				<div class="form-group">
					 					<label type="text" class="col-md-2" style="margin-left:35px;">Nom Binôme: </label>
					 					<div class="col-md-9">
					 						 <input type="text" name="nomb" class="form-control" placeholder="Nom du Binome" >
					 					</div>
					 				</div>
					 			</div>
				 			
					 			<div class="row">
					 				<div class="form-group">
					 					<label type="text" class="col-md-2" style="margin-left:35px;">Pass: </label>
					 					<div class="col-md-9">
					 						 <input type="password" name="passb" class="form-control" placeholder="Pass du Binome" >
					 					</div>
					 				</div>
					 			</div>								
						</fieldset>		 			
			 			 <div class="form-group"><input type="submit" id="but" class="pull-right btn btn-primary" value="Suivant"></div>
			 		</form>
			 	</div>
			 </section>
		</div>
</body>
</html>
