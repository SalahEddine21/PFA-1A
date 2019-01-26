<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');
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

			 <section>
				 <div class="row" >
				 	<div class="col-md-offset-3 col-md-5 col-lg-5 ">
				 		<div class="alert alert-info" >
				 			<strong><h1>Alert !</h1></strong>
				 			<p>Le nombre des stages dans votre formation ne respecte pas les contraintes de l'algorithme !</p>
				 			<p>Taper <a style="color:red;" href="profil.php" >ICI</a> pour revenir </p>
				 		</div>
				 	</div>
				 </div>
			 </section>
	</div>
</body>
</html>			 