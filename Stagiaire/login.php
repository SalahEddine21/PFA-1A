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
						<li><a href="Inscription.php">Inscription-Etudiant</a></li>
						<li class="active"><a href="login.php" >Login-Binômes</a></li>
					</ul>
				</nav>
			 </div>
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px; ">
			 		<h1>AGS</h1>
			 		<h3 style="color:red;" ><p>Toujours Simple</p></h3>
			 	</div>
			 </header>
			 <section class="row" >

				<form class="form-horizontal  col-md-offset-3 col-sm-12 col-md-6 col-lg-6" action="test-login.php" method="post" style="margin-top:30px; ">
					<div class="form-group">
						<legend>Vos Information</legend>
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

				 	<div class="row"> 
			 			<div class="form-group">
			 				<label type="text" class="col-md-2">Pass:</label>
			 				 <div class="col-md-10"><input type="password" id="pass" name="pass" placeholder="Votre Pass" class="form-control" required></div>
			 			</div>
			 		</div>	
			 		</br>
			 		<div class="form-group">
			 			<div>
			 				<a href="pass-oublie.php" style="margin-left:400px; color:red;" >Pass oubliè ?</a>
			 				<input type="submit" id="but" class="pull-right btn btn-success col-md-2" style="margin-top:-5px;" value="Suivant">
			 			</div>
			 		</div>
				</form>
			 </section>

			 <footer class="row" style="background-color: #272833; margin-right: 5px; margin-left: 5px; margin-top: 150px; border-radius: 10px; ">
				 <div class="text-center" style="color:white" >
				 		<p>Developped By SalahEddine/Ysf -ENSIAS.2017 </p>
				 		<p>&copy; Untitled. All rights reserved.</p>
				 </div>
			 </footer>
	 </div>
</body>
</html>