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
 	if(strcmp($_SESSION['table'], 'etudiant1a')==0) $binome='Binomes1A';
 	else $binome='Binomes2A';

 	 $table=$_SESSION['table'];
 	 $table_bin=$_SESSION['table_bin'];
 	 $formation=$_SESSION['formation'];

 	 $query=$bdd->prepare("SELECT * from $table where formation=? and codeEtudiant not in ( select stagiaire1 from binomes1a where etat=1 and formation=?) and codeEtudiant not in (select stagiaire2 from binomes1a where etat=1 and formation=?) and CodeEtudiant <>  ? ");

 	 $query->execute(array($formation,$formation,$formation,$_SESSION['stagiaire1'],));
 	 //$query->execute(array($_SESSION['formation']));


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
						<li class="active"><a href="binome-selection.php">Inscription</a></li>						
					</ul> 
					<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
				</nav>
			 </div>  
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em;  width:1152px; margin-left:-10px;">
			 		<h1>AGS</h1>
			 		<p>Bonjour <?php echo $_SESSION['prenom']?></p>
			 	</div>
			 </header>
			 <section class="row">
			 	<div class="col-sm-12 col-md-12 col-lg-12">
			 		<h3 style="font-family:  'Comic Sans MS';" >Veuillez CHoisir parmis ceux cités dessous votre Binôme</h3>
			 		</br>
			 			<div class="row">
						 		<form class=" col-sm-12 col-md-7 col-lg-7 form-horizontal" action="Inscription-bin-fin.php" style="margin-left:35px;" method="post">
							 		<div class="row">
							 			<div class="form-group">
								 				<div class="col-md-9">
								 					<select name="binome" class="form-control" >
												 		<?php 
											 			 while($ligne=$query->fetch())
											 			 	echo '<option value='.$ligne['codeEtudiant'].'>'.$ligne['prenom'].'-'.$ligne['nom'].'</option>';
											 			?>					
								 					</select>
								 				</div>	
											 	<div class="col-md-2">
										 				<button type="submit" class="btn btn-primary">Sauvegarder</button>
										 		</div>
							 			</div>
							 		</div>
						 		</form>
					 	</div>	
					 	<div class="row" style="margin-left:35px;">
					 		</br>
					 		<p><strong style="color:red; font-family: 'Comic Sans MS'; " >Notice: </strong>Aucune Candidature ne sera prise en compte si votre binôme a selectionné un autre</p>
					 	</div>
			 		</div>
			 	</div>
			 </section>			
		</div>
</body>
</html>