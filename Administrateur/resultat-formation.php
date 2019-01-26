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

	if(strcmp($_SESSION['niveau'] , '1A')==0){
	 	$table='binomes1a';
	 	$table_etud='etudiants1a';
	}else{
	 	$table='binomes2a';
	 	$table_etud='etudiants2a';
	}
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
				 	<div class="col-md-5 col-lg-5 col-sm-12">
				 		<h4>Note:</h4>
				 		<blockquote>
				 			<p>Veuillez chosir une filière</br> Où Tapez Ici pour revenir:</br>
				 			<button class="btn btn-danger pull-right" onclick="document.location.href='imports-selection.php'">Back</button>
				 			</p>
				 		</blockquote>
				 	</div>
				 	<div class="col-md-7 col-lg-7 col-sm-12 ">
					 	<header>
					 		<h3 style="color:red;" >Resultat de la filière: </h3>
					 	</header>
					 	<form class="form-horizontal" action="resultat.php" method="post" >

						 	<?php 
						 		$formation=$bdd->query("SELECT DISTINCT formation from $table");
						 	?>
						 		<select class="form-control" name="formation" >
							<?php
						 		while($ligne=$formation->fetch())
						 			echo '<option value='.$ligne['formation'].' >'.$ligne['formation'].'</option>';
						 	?>
						 		</select>
						 		</br>
						 		<div class="form-group">
						 			<input type="submit" id="but" class="btn btn-success col-md-3" value="Valider" style="margin-left:500px;">
						 		</div>		

					 	</form>
					</div> 	
				</section>
		</div>
	</body>
</html>					
