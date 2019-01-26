<?php
	 session_start();
	 if(isset($_SESSION['connexion'])) header('location:profil.php');

 	try
 	{
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	}catch(Exception $e)
 	{
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	}

 	if(strcmp($_POST['niveau'], '1A')==0){
 	 	 $table='binomes1a';
 	 	 $niveau='1A';
 	 	 $etudiant='etudiants1a';
 	}
 	else{
 	 	$table='Binomes2A';
 	 	$niveau='2A';
 	 	$etudiant='etudiants2a';
 	}	 
 	$query=$bdd->prepare("SELECT * FROM $table where nom_binome=? ");
 	$query->execute(array($_POST['nomb']));
 	$ligne=$query->fetch();

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
						<li><a href="Accueil.html">AGS</a></li>
						<li><a href="Inscription.php">Inscription-Etudiant</a></li>
						<li><a href="Inscription-bin.php">Inscription-Binôme</a></li>
						<li class="active"><a href="login.php" >Login</a></li>
					</ul>
				</nav>
			 </div>
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em;">
			 		<h1>AGS</h1>
			 		<p>Binômes-login</p>
			 	</div>
			 </header>
			 <section class="row">

				 <?php if(empty($ligne['nom_binome'])) { ?>
				      <div class="starter-template" style="text-align:center" >

				        <h1 style="color:red">Inexistant !</h1>
				        <p class="lead">Veuillez verifier vos Information svp !</p>
				      </div>
				 <?php }else{ 
				 		$query_stg1=$bdd->prepare("SELECT * from $etudiant where codeEtudiant=? ");
				 		$query_stg1->execute(array($ligne['stagiaire1']));
				 		$stagiaire1=$query_stg1->fetch();

				 		$query_stg2=$bdd->prepare("SELECT * from $etudiant where codeEtudiant=? ");
				 		$query_stg2->execute(array($ligne['stagiaire2']));
				 		$stagiaire2=$query_stg2->fetch();	

				 		$to=$stagiaire1['email'].',';
				 		$to .= $stagiaire2['email'];

				 		$subject='AGS-nouveau pass';
				 		$pass=mt_rand(369,369854);
				 		$msg='Bonjour'.$ligne['nom_binome'].'Voilà votre nouveau mot de pass'.$pass.'nôtre le Svp,Merci';
				 		$message = wordwrap($msg, 70, "\r\n");	
						$headers = 'From: AGS Founders' . "\r\n" .
	     				'Reply-To:'.$ligne['nom_binome']. "\r\n";
	     				//ini_set('SMTP','smtp-auth.menara.ma');
				 }
				 ?>

			 </section>
	 </div>
</body>
</html>