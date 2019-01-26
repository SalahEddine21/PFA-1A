<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');
     try
     {
		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
     }catch(Exception $e)
     {
     	echo 'Error : '.$e.getmessage();
     	exit();
     }

     $query=$bdd->prepare('SELECT * from annonce_admin where nom=?');
     $query->execute(array($_POST['annonce']));
     $ligne=$query->fetch();

     if(empty($ligne)){
     $query=$bdd->prepare('INSERT INTO annonce_admin(nom,niveau,publication,expiration) VALUES (?,?,?,?)');
     $query->execute(array($_POST['annonce'],$_POST['niveau'],date($_POST['datep']),date($_POST['datex'])));
     }else{
     	$query=$bdd->prepare('UPDATE annonce_admin SET nom=?,niveau=?,publication=?,expiration=? WHERE id=?');
     	$query->execute(array($_POST['annonce'],$_POST['niveau'],date($_POST['datep']),date($_POST['datex']),$ligne['id']));
     }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Admin</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
		<div class="container">
			<div class="row">
				<nav class="navbar navbar-inverse col-md-12 col-sm-12">
					<ul class="nav navbar-nav">
						<li class="active"><a href="admin.php">Administrateur</a></li>						
					</ul> 
					<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
				</nav>
			 </div>  
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px;">
			 		<h1>AGS</h1>
			 		<h3><p style="color:red">Espace Administartive</p></h3>
			 	</div>
			 </header>
			 <section class="row">
			 	<div class=" col-md-offset-3 col-sm-12 col-md-5 col-lg-5">
				 	<div class="alert alert-info">
				 		<h3><strong><p>Annonce Enregistrée</p></strong></h3>
				 		</br>
				 		<p>Votre annonce sera diffusé vers les Binômes du niveau <?php echo $_POST['niveau']?>,Merci </p>
				 		<p>Tapez Sur 
				 		<button class="btn btn-danger " onclick="document.location.href='imports-selection.php'">Revenir</button></p>
				 		</br>
				 	</div>
			 	</div>
			 </section>			
		</div>
</body>
</html>