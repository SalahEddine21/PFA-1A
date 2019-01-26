<?php
	 session_start();
 	try
 	{
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	}catch(Exception $e)
 	{
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	}
 	require_once('binome.class.php');
 	$query=$bdd->prepare('SELECT * FROM stages_detail WHERE idstage=?');
 	$query->execute(array($_SESSION['idemp']));
 	$ligne=$query->fetch();
 	if(empty($ligne)) $indicateur=true;
 	else $indicateur=false;

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
						<li class="active"><a href="admin.php">Employeur</a></li>						
					</ul> 
					<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
				</nav>
			 </div>  
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em;">
			 		<h1>AGS</h1>
			 		<p>Bonjour <?php echo $_SESSION['nom'].' '.$_SESSION['prenom'] ?></p>
			 	</div>
			 </header>
			 <section class="row">
			 	<div class="col-sm-12 col-md-4 col-lg-4">
			 		<blockquote class="input-medium blockquote">
			 			<p style="padding:1em;">Voilà Vos Annonces,à vous de jouer</p>
			 		</blockquote>
			 	</div>
			 	<div class="col-sm-12 col-md-8 col-lg-8">
			 	<?php
			 		 if($indicateur!=true){
			 		 	echo 
				 		 	'<table class="table table-bordered table-striped table-condensed" hidden="hidden">
					 			<caption>
					 				Annonces
					 			</caption>
					 			<thead>
						 			<tr class="row">
						 				<th class="col-md-4">Annonce</th>
						 				<th class="col-md-4">Date</th>
						 				<th class="col-md-4">Opération</th>
						 			</tr>
					 			</thead>
					 			<tbody>'

					 			'</tbody>
				 			</table>';
			 		 }else{
			 		 	echo 
				 		 	'<div id="empty_ann" hidden="hidden">
					 			<h2 style="color:red; text-align: center;">Aucune Annonce</h2>
					 			<p style="padding:0.5em;">Veuillez ajouter un annonce d\'abord avant l\'expiration du date</p>
				 			</div>';
			 		 }
			 	?>
			 	</div>
			 </section>
	  </div>
</body>
</html>