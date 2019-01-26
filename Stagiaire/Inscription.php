<?php
	session_start();
	if(isset($_SESSION['connexion'])) header('location:profil.php');

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
						<li  class="active"><a href="Inscription.php">Inscription-Etudiant</a></li>
						<li><a href="login.php" >Login-Binômes</a></li>
					</ul>
				</nav>
			 </div>
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px;">
			 		<h1>AGS</h1>
			 		<h3 style="color:red;" ><p>Toujours Simple</p></h3>
			 	</div>
			 </header>

			 <section class="row" >
			 	<div class=" col-md-offset-1 col-sm-12 col-md-5 col-lg-5" >
			 		<img src="images/stg.jpg"  class="img-rounded" alt="Stagiaires-logo" >
			 	</div>
			 	<div class="col-sm-12 col-offset-lg-1 col-offset-md-1 col-md-6 col-lg-6">
			 	  <form class="form-horizontal" action="traitement.php" method="post" style="margin-top:30px;" onsubmit="return(test1());">
			 			<div class="form-group">
			 				<legend>Information-Personnel</legend>
			 			</div>

			 			<div class="row"> 
			 				<div class="form-group">
			 					<label type="text" class="col-md-2">Nom:</label>
			 				   <div class="col-md-10"><input type="text" name="nom" placeholder="Votre Nom" class="form-control" required></div>
			 				</div>
			 			</div>
			 			<div class="row"> 
			 				<div class="form-group">
			 					<label type="text" class="col-md-2">Prénom:</label>
			 				   <div class="col-md-10"><input type="text" name="prenom" placeholder="Votre Prénom" class="form-control" required></div>
			 				</div>
			 			</div>	
			 			<div class="row" > 
			 				<div class="form-group" id="mail" >
			 					  <label type="text" class="col-md-2">Email:</label>
			 				      <div class="col-md-10" id="mail_nv" ><input id="email" type="text" name="email" placeholder="Votre Email" class="form-control" required></div>
			 				</div>
			 			</div>
			 			<div class="row"> 
			 				<div class="form-group">
			 					  <label type="text" class="col-md-2">Niveau:</label>
			 				      <div class="col-md-10">
			 				      	<select name="niveau" class="form-control">
			 				      		<option value="1A" selected="selected">1A</option>
			 				      		<option value="2A">2A</option>
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

				             <div class="form-group"><input type="submit" id="but" class="pull-right btn btn-primary" value="Suivant"></div>
			 		</form>
			 	</div>
			 </section>
	  </div>
	  <script>
	  	//var pass=document.getElementById('pass'),pass1=document.getElementById('pass1');
	  	function test1(){

			if (/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(document.getElementById('email').value)) return true;
			else {
				var span=document.createElement('span');
				span.className="help-block ";
				span.appendChild(document.createTextNode('Corrigez l\'erreur s\'il vous plait'));
				document.getElementById('mail_nv').appendChild(span);
				document.getElementById('mail').className='form-group has-error has-feedback';
				return false;
			}	 
	  	}
	  </script>
</body>
</html>