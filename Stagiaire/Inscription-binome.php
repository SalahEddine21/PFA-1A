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
						<li><a href="Accueil.html">AGS</a></li>
						<li><a href="Inscription.php">Inscription</a></li>
						<li class="active"><a href="Inscription-binomes.php">Binomes-Inscription</a></li>	
						<li><a href="login-binomes.php">Binomes-Login</a> </li>					
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
					 <h3><span class="label label-success">Enregistrè</span></h3>
				 		<blockquote>
				 			Votre Candidature a était Bien enregistrè</br>Veuillez Contacter Votre Binome à fin de remplir les informations
				 			devant et faire Vos premières choix</br>
				 			<p>Tapez ici pour y revenir</p>
				 			<button class="btn btn-success pull-right" onclick="document.location.href='Inscription.php'">Revenir</button>
				 			</br>
				 			<small class="pull-right"><p><span class="label label-danger">Bonne-Chance</span></p></small>
				 		</blockquote>		 		
			 	</div>
			 	<div class=" col-offset-lg-1 col-offset-md-1 col-sm-12 col-md-7 col-lg-7">

			 		<form class="form-horizontal" action="test.php" method="post" style="margin-top:30px;" >
			 			<div class="form-group">
			 				<legend>Information-Binomes</legend>
			 			</div>
			 			<fieldset>
			 				<legend>Stagiaire 1:</legend>
					 			<div class="row">
					 				<div class="form-group">
					 					<label type="text" class="col-md-2" style="margin-left:35px;" >Code: </label>
					 					<div class="col-md-9">
					 						<input type="text" name="code1" class="form-control" placeholder="Code Stagiaire 1" >
					 					</div>
					 				</div>
					 			</div>
					 			<div class="row">
					 				<div class="form-group">
					 					<label type="text" class="col-md-2" style="margin-left:35px;" >Pass: </label>
					 					<div class="col-md-9">
					 						<input type="password" name="pass1" class="form-control" placeholder="Pass du Stagiaire 1" >
					 					</div>
					 				</div>
					 			</div>			 				
			 			</fieldset>

			 			<fieldset>
			 				<legend>Stagiaire 2:</legend>
					 			<div class="row">
					 				<div class="form-group">
					 					<label type="text" class="col-md-2" style="margin-left:35px;">Code: </label>
					 					<div class="col-md-9">
					 						<input type="text" name="code2" class="form-control" placeholder="Code Stagiaire 2" >
					 					</div>
					 				</div>
					 			</div>
					 			<div class="row">
					 				<div class="form-group">
					 					<label type="text" class="col-md-2" style="margin-left:35px;">Pass: </label>
					 					<div class="col-md-9">
					 						 <input type="password" name="pass2" class="form-control" placeholder="Pass du Stagiaire 2" >
					 					</div>
					 				</div>
					 			</div>			 				
			 			</fieldset>
						<fieldset>
							<legend>Binôme: </legend>
					 			<div class="row">
					 				<div class="form-group">
					 					<label type="text" class="col-md-2" style="margin-left:35px;">Identifiant: </label>
					 					<div class="col-md-9">
					 						 <input type="text" name="nomb" class="form-control" placeholder="Nom du Binome" >
					 					</div>
					 				</div>
					 			</div>
							 	<div class="row"> 
						 			<div class="form-group">
						 				<label type="text" class="col-md-2" style="margin-left:35px;">Niveau:</label>
						 				 <div class="col-md-9">
						 				 	<select name="niveau" class="form-control">
						 				 		<option value="1A" >1A</option>
						 				 		<option value="2A" >2A</option>
						 				 	</select>
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
