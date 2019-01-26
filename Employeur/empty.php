<?php
	session_start();
	session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Employeur</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
	  <div class="container">
			<div class="row">
				<nav class="navbar navbar-inverse col-md-12 col-sm-12">
					<ul class="nav navbar-nav">
						<li><a href="Accueil.html">AGS</a></li>
						<li class="active"><a href="Inscription.php">Inscription</a></li>
						<li><a href="login.php">Login</a></li>
					</ul>
				</nav>
			 </div>
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px; ">
			 		<h1>AGS</h1>
			 		<h3 style="color:red;" ><p>Toujours Simple</p></h3>
			 	</div>
			 </header>
			 <section class="row">
			 	<div class=" col-md-offset-3 col-sm-12 col-md-5 col-lg-6 login " >
			 		<div class="alert span5 alert-info">
			 			<h2>Alert</h2>
			 			<p>La formation <? echo $_GET['formation'] ?> n'est pas disponible pour le moment, veuillez contacter l'admin pour l'ajouter au systeme,Merci</p>
			 			<p><strong style="color:red;">revenir</strong>, par ici	<button class="btn btn-info" onclick="document.location.href='Inscription.php'" >Page 0</button>
			 		</div>
			 	</div>			 	
			 </section>
		</div>
</body>
</html>			 