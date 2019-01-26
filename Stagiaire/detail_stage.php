<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');
	if(!isset($_GET['idstage']) or !is_numeric($_GET['idstage'])) header('location:profil.php');
 	try
 	{
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	}catch(Exception $e)
 	{
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	}	
 	$query=$bdd->prepare('SELECT * FROM stages where idstage=?');
 	$query->execute(array($_GET['idstage']));
 	$ligne=$query->fetch();

 	if(!empty($ligne)){
	 	$query1=$bdd->prepare('SELECT email from employeurs where idemp in (SELECT idemp from stages_detail where idstage=? )');
	 	$query1->execute(array($ligne['idstage']));
	 	$ligne1=$query1->fetch();

	 	$list=$bdd->prepare('SELECT * from stages_detail where idstage=?');
	 	$list->execute(array($ligne['idstage']));
	 	$module=$list->fetch();

	 	$array=array('M1'=>0,'M2'=>0,'M3'=>0,'M4'=>0,'M5'=>0,'M6'=>0,'M7'=>0,'M8'=>0);
	 	$etat_stage='Founded';
 	}else $etat_stage='NotFound';
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
			 	<div class="jumbotron" style="padding:0.5em;">
			 		<h1>AGS</h1>
			 		<h3 style="color:red;" ><p>Bonjour <?php echo $_SESSION['nomb']?></p></h3>
			 	</div>
			 </header>
			 <section class="row">
			 	<div class="col-sm-12 col-md-4 col-lg-4">
			 		<blockquote class="input-medium">
			 			Voilà les details du stage 
			 			</br>
			 			<p>Tapez ici pour y revenir</p>
			 			<button class="btn btn-danger pull-right" onclick="document.location.href='profil.php'">Revenir</button>
			 		</blockquote>
			 	</div>
			 	<div class="col-sm-12 col-md-8 col-lg-8">

			 		<?php if(!empty($ligne)){ ?>

				 		<div class="starter-template row">
				 				<h1>Detail</h1>
				 				<p class="alert alert-info">Liser attentivement les informations dessous</p>
				 				<small class="pull-right">Bonne Chance</small>
				 				</br>
				 		</div>
				 			</br>
				 		<div class="row">
				 			<div class="form-group">
				 				<label type="text" class="col-md-2" >Titre: </label>
				 				<div class="col-md-10">
				 					<label type="text" class="form-control"> <?php echo $ligne['titre']  ?> </label>
				 				</div>
				 			</div>
				 		</div>
				 		<div class="row">
				 			<div class="form-group">
				 				<label type="text" class="col-md-2" >Description: </label>
				 				<div class="col-md-10">
				 					<label type="text" class="form-control"> <?php echo $ligne['description']  ?> </label>
				 				</div>
				 			</div>
				 		</div>	
				 		<div class="row">
				 			<div class="form-group">
				 				<label type="text" class="col-md-2" >Employeur-email: </label>
				 				<div class="col-md-10">
				 					<label type="text" class="form-control"> <?php echo $ligne1['email']  ?> </label>
				 				</div>
				 			</div>
				 		</div>		
				 		<div class="row">
				 			<div class="form-group">
				 				<label type="text" class="col-md-2" >Publication: </label>
				 				<div class="col-md-10">
				 					<label type="text" class="form-control"> <?php echo $ligne['Publication']  ?> </label>
				 				</div>
				 			</div>
				 		</div>		

				 		<table class="table table-bordered table-striped table-condensed">
				 			<caption>Liste des Modules demandès</caption>
				 				<head>
				 					<tr>
					 					<th>M1</th>
					 					<th>M2</th>
					 					<th>M3</th>
					 					<th>M4</th>
					 					<th>M5</th>
					 					<th>M6</th>
					 					<th>M7</th>
					 					<th>M8</th>
				 					</tr>
				 				</head>
				 				<tbody>
				 					<?php 
				 							echo "<tr class='active'>";
				 								echo "<td>".$module['M1']."</td>";
				 								echo "<td>".$module['M2']."</td>";
				 								echo "<td>".$module['M3']."</td>";
				 								echo "<td>".$module['M4']."</td>";
				 								echo "<td>".$module['M5']."</td>";
				 								echo "<td>".$module['M6']."</td>";
				 								echo "<td>".$module['M7']."</td>";
				 								echo "<td>".$module['M8']."</td>";
				 							echo "</tr>";	

				 					?>		
				 				</tbody>
				 		</table>	
				 	<?php }else{ ?>
				 		<div class="row">
				 			<div class="starter-template" >
       							 <h1 style="color:red;" >Erreur</h1>
    					  		 <p class="lead">Pas la peine de jouer avec le contenu de l'URL </p>
				 			</div>
				 		</div>
				 	<?php } ?>	
			 	</div>
			 </section>			
		</div>
</body>
</html>