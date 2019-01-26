<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:login.php');

 	try
 	{
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	}catch(Exception $e)
 	{
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	}
 	$query=$bdd->prepare('SELECT nom from formation where id in (select idformation from formation_prof where idprof = ? ) ');
 	$query->execute(array($_SESSION['idemp']));

 	$filiere = $bdd->prepare('SELECT nom from formation where id in (select idformation from  formation_prof where idprof = ? ) ');
 	$filiere->execute(array($_SESSION['idemp']));
 	$manquante = array(); $i=0;

 	while($filiere1 = $filiere->fetch()){

 		$stage = $bdd->prepare('SELECT * from stages where formation = ? and idstage in (select idstage from stages_detail where idemp = ? ) ');
 		$stage->execute(array($filiere1['nom'],$_SESSION['idemp']));
 		$stage=$stage->fetch();
 		if(empty($stage['idstage'])){
 			$manquante[$i]=$filiere1['nom'];
 			$i=$i+1;
 		}
 	}
 	if(sizeof($manquante)==0) $indicateur=0;
 	else $indicateur=1;
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
						<li class="active"><a href="profil.php">Accueil</a></li>						
					</ul> 
					<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
				</nav>
			 </div>  
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px;">
			 		<h1>AGS</h1>
			 		<h3 style="color:red;" ><p>Bonjour <?php echo $_SESSION['nom'].' '.$_SESSION['prenom'] ?></p></h3>
			 	</div>
				 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes, <strong style="color:red;" > ENSIAS </strong> </p></h3>
			 </header>

			 <section class="row">
			 	<div class="col-sm-12 col-md-4 col-lg-4">
				 		<ul class="list-group">
						   <button id="profil" class="list-group-item active" onclick="document.location.href='profil.php'">Mon Profil</button>
							<button id="annonce" class="list-group-item" onclick="document.location.href='addannonce.php'">Ajouter une Annonce</button>
							<button id="ensemble" class="list-group-item " onclick="document.location.href='mesannonce.php'">Mes Annonces</button>
							<button id="mesinfos" class="list-group-item" onclick="document.location.href='addformation.php'">Ajouter Formation</button>
						</ul>
			 	</div>
			 	<div class="col-sm-12 col-md-8 col-lg-8"> 
				 	<div class="panel panel-info">
				 		<div class="panel-heading" >
				 			<h3 class="panel-title" style="font-family:" >Vos Information</h3>
				 		</div>
				 		<div class="panel-body">

					 		<div class="row">
				 				<label type="text" class="col-md-2" >Nom: </label>
				 				<div class="col-md-8">
				 					<label type="text" class="form-control"><?php echo $_SESSION['nom'] ?></label>
				 				</div>
					 		</div>

					 		<div class="row">
				 				<label type="text" class="col-md-2" >prenom: </label>
				 				<div class="col-md-8">
				 					<label type="text" class="form-control"><?php echo $_SESSION['prenom'] ?></label>
				 				</div>
					 		</div>
					 		<div class="row">
				 				<label type="text" class="col-md-2" >email: </label>
				 				<div class="col-md-8">
				 					<label type="text" class="form-control"><?php echo $_SESSION['email'] ?></label>
				 				</div>
					 		</div>

					 		<div class="row">
					 			<label type="text" class="col-md-2">Formation: </label>
					 			<div class="col-md-8">
					 				<ul>
					 					</br>
					 					<?php
					 					while($formation=$query->fetch()) echo '<li style="font-family: Verdana; color:gray; " >'.$formation['nom'].'</li>';
					 					?>
					 				</ul>
					 			</div>
					 		</div>
				 		</div>
				 	</div>

				 	<div class="row">
				 		<?php if($indicateur==1) { ?>
				 		
				 			<strong><h4 type="text" class="col-md-2" style="color:red; margin-top:-0.5px;" >Rappel: </h4></strong>
				 			<div class="col-md-10">
				 				<strong><p>Vous n'avez pas ajouter aucun stage dans les formations suivantes: </p></strong>
				 				</br>
				 			</div>

						 		<?php 
						 			for($i=0;$i<sizeof($manquante);$i++) echo '<li class="col-md-offset-2" style="font-family: Verdana; color:red; margin-left:155px; " >'.$manquante[$i].'</li>';
						 		} ?>

				 	</div>

			 	</div>
			 </section>
	  </div>
	  <script>
 		 var ind = '<?php echo $indicateur ?>';
 		 if(ind==1){	

 		 }
	  </script>
</body>
</html>