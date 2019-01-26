<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');
	$_SESSION['vue']=1;

?>
<!DOCTYPE html>
<html>
	<head>
		<title>AGS-resultat</title>
		<meta charset="utf-8">
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
				 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes, ENSIAS  </p></h3>
				</header>
				<section class="row">
					<div class="col-md-offset-3 col-sm-12 col-md-5 col-lg-5 ">
					</br>
						<div class="alert span5 alert-info">
							<h2>Information: </h2>
							<p>On vous informe qu'aucun binôme n'a fait leur propre choix !,</br><strong style="color:red;" >Algorithme non lançè</strong></p>
							<p>Pour revenir , par ici <button class="btn btn-danger" onclick="document.location.href='imports-selection.php'">Back</button></br></p>
						</div>
					</div>
				</section>
		</div>
	</body>
</html>						