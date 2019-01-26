<?php
	 session_start();
	 if(isset($_SESSION['connexion'])) header('location:profil.php');
?>	 
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
	 <div class="container">
			<div class="row">
				<nav class="navbar navbar-inverse col-md-12 col-sm-12">
					<ul class="nav navbar-nav">
						<li><a href="Accueil.html">AGS</a></li>
						<li><a href="Inscription.php">Inscription-Etudiant</a></li>
						<li><a href="login.php">Login-Binômes</a></li>
					</ul>
				</nav>
			 </div>
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em;  width:1152px; margin-left:-10px;">
			 		<h1>AGS</h1>
			 		<h3 style="color:red;" ><p>Toujours Simple</p></h3>
			 	</div>
			 </header>
			 <section class="row">
			 	<div class="col-sm-12 col-md-5 col-lg-5" style="margin-top:30px;">
			 		<blockquote>
			 			merci de nous remplir les informations devant,un email vous sera envoyer ultèrieurement
			 		</blockquote>
			 	</div>
				<form class="form-horizontal col-sm-12 col-md-6 col-lg-6" action="send-pass.php" method="post" style="margin-top:30px; text-align:center;  margin-left: 10px; ">
					<div class="form-group">
						<legend></legend>
					</div>

					<div class="row">
						<div class="form-group">
							<label type="text" class="col-md-2" >Identifiant:</label>
							<div class="col-md-10"><input type="text" name="nomb" class="form-control" placeholder="Nom du Binome" required="">  </div>
						</div>
					</div>

				 	<div class="row"> 
			 			<div class="form-group">
			 				<label type="text" class="col-md-2">Niveau:</label>
			 				 <div class="col-md-10">
			 				 	<select name="niveau" class="form-control">
			 				 		<option value="1A" >1A</option>
			 				 		<option value="2A" >2A</option>
			 				 	</select>
			 				 </div>
			 			</div>
			 		</div>	
			 		<div class="form-group">
			 			<input type="submit" id="but" class="pull-right btn btn-danger col-md-2" value="Envoyer">
			 		</div>
				</form>
			 </section>
	 </div>
</body>
</html>