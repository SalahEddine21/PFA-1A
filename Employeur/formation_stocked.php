<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:login.php');
	if(!isset($_SESSION['old']) or !isset($_SESSION['nexist'])) header('location:addformation.php');

	$old=$_SESSION['old'];
	$nexist=$_SESSION['nexist'];

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
						<li><a href="profil.php">Accueil</a></li>						
					</ul> 
					<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
				</nav>
			 </div>  
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px;">
			 		<h1>AGS</h1>
			 		<h3 style="color:red;" ><p>Bonjour <?php echo $_SESSION['nom'].' '.$_SESSION['prenom'] ?></p></h3>
			 	</div>
				 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes,<strong style="color:red;" >ENSIAS</strong>  </p></h3>
			 </header>

			 <section class="row">
			 	<div class=" col-md-offset-3 col-sm-12 col-md-6 col-lg-6">
			 		<?php if(sizeof($nexist)>0){ ?>
				 		<div class="alert alert-info text-center"><h2><strong style="color:red;" >ERROR-404</strong></h2></div>
				 		<p style="font-size:20px;">les filières citées dessous n'éxistent pas dans le systeme !</p>
				 		<ul>
						 	<?php
						 		for($i=0;$i<sizeof($nexist);$i++) echo '<li style="font-size:20px;">'. $nexist[$i] .'</li>';
						 		echo '</br>';
						 	?>	
				 		<ul>
				 	<?php }if(sizeof($old)>0){ ?>

				 		<div class="alert alert-info text-center"><h2><strong style="color:red;" >Redondance !</strong></h2></div>
				 		<div class="row" >
					 		<div class="col-md-offset-3"  >
							 	<p style="font-size:20px;">Vous enseignez déjà les filières dessous ! </p>
						 		<ul>
								 	<?php
								 		for($i=0;$i<sizeof($old);$i++) echo '<li style="font-size:20px;">'. $old[$i] .'</li>';
								 		echo '</br>';
								 	?>					 		
						 		</ul>
					 		</div>
				 		</div>

				 	<?php } ?>

				 	<?php if(sizeof($old)==0 and sizeof($nexist)==0) { ?>

				 		<div class="alert alert-info text-center"><h2><strong style="color:green;" >Stocké</strong></h2></div>
				 		<div class="row" >
					 		<div class="col-md-offset-3"  >
				 				<p style="font-size:20px;">Vos mise à jour sont correctement ajoutés</p>
				 			</div>
				 		</div>		

				 	<?php } ?>
				 		<div class="row" >
					 		<div class="col-md-offset-3"  >
				 				<p style="font-size:20px;" >Tapez sur <a href="profil.php" style="color:red;font-family: 'Comic Sans MS'" > Acceuil </a> pour revenir</p>
				 			</div>
				 		</div>			
			 	</div>
			 </section>
		</div>
</body>
</html>			 