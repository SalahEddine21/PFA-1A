<?php
	session_start();
	session_destroy();
?>
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
						<li><a href="Inscription.php">Inscription-Etudiant</a></li>
						<li><a href="login.php" >Login-Binômes</a></li>				
					</ul> 
				</nav>
			 </div>  
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em;">
			 		<h1>AGS</h1>
			 		<h3 style="color:red;" ><p>Toujours Simple</p></h3>
			 	</div>
			 </header>
			 <section class="row">
			 	<div class=" col-md-offset-2 col-sm-12 col-md-8">
			 		<div>
						<h3><span class="label label-success">Finalisation d'inscription</span></h3>
						<h4><p style="font-family: 'Comic Sans MS' " >Votre Candidature a était bien enregistré,Votre Binôme doit confirmer votre selection</br></br>Tapez sur revenir pour une nouvelle inscription</p></h4>
						</br>
						<button class="btn btn-primary pull-right" onclick="document.location.href='Inscription.php'">Revenir</button>
				 	</div> 							 				 		
			 	</div>
			 	<div class=" col-offset-lg-1 col-offset-md-1 col-sm-12 col-md-7 col-lg-7">
			 		
			 	</div>
			 </section>
		</div>
</body>
</html>
