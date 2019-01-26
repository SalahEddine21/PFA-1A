<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:login.php');
	if(!isset($_POST['titre']) OR !isset($_POST['desc']) ) header('location:profil.php');

	 $nombrechoix=$_POST['nombrechoix'];
	 $indice=0; $indice_note=11;
	 $choix=array(); $note=array();

	 for($i=1; $i<=$nombrechoix; $i++) // récupération des modules ainsi que les notes attribués à eux;
	 {
	 		$choix[$indice]=$_POST[$i];
	 		$note[$indice]=$_POST[$indice_note];
	 		echo 'Module: '.$choix[$indice].' Note: '.$note[$indice].'</br>';
	 		$indice++;
	 		$indice_note++;
	 }
 	 try
 	 {
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	));
 	 }catch(Exception $e)
 	 {
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	 }

$query=$bdd->prepare('INSERT INTO stages(titre,description,niveau,formation,Publication,affectation,satisfaction) VALUES (?,?,?,?,NOW(),0,0)');
 	$query->execute(array($_POST['titre'],$_POST['desc'],$_POST['niveau'],$_POST['formation']));

 	 $query=$bdd->query('SELECT MAX(idstage) as idstage FROM stages');
 	 $ligne=$query->fetch();
 	 $idstage=$ligne['idstage'];
 	 
 	 $list=array('M1'=>0,'M2'=>0,'M3'=>0,'M4'=>0,'M5'=>0,'M6'=>0,'M7'=>0,'M8'=>0);

 	 foreach ($list as $key => $value) {
 	 	$i=0;
 	 	while($i<$indice AND strcmp($choix[$i], $key)!=0) $i++;
 	 	if($i<$indice) $list[$key]=$note[$i];
 	 }
 	 $query=$bdd->prepare('INSERT INTO stages_detail(idstage,idemp,M1,M2,M3,M4,M5,M6,M7,M8) VALUES (?,?,?,?,?,?,?,?,?,?)');	  
 	   $query->execute(array($idstage,$_SESSION['idemp'],$list['M1'],$list['M2'],$list['M3'],$list['M4'],$list['M5'],$list['M6'],$list['M7'],   $list['M8']));
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
			 		<div class="jumbotron" style="padding:0.5em;  width:1152px; margin-left:-10px;">
			 			<h1>AGS</h1>
			 			<h3  style="color:red;" ><p>Bonjour <?php echo $_SESSION['nom'].' '.$_SESSION['prenom'] ?></p></h3>
			 		</div>
				 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes,<strong style="color:red;" > ENSIAS </strong> </p></h3>
			 </header>
			 <section class="row">
			 	<div class=" col-md-offset-3 col-sm-12 col-md-5 col-lg-5">
				 	<div class="alert alert-info" style="margin-top:50px;" >
				 		<strong><h1>Confirmation</h1></strong>
				 		<p style="font-size:16px;" >Votre annonce a était bien ajouté dans le systeme,Merci</p>
				 		<p>Taper sur <button class="btn btn-success" onclick="document.location.href='profil.php'">0</button> pour revenir</p>
				 	</div>
			 	</div>
			 </section>			
		</div>
</body>
</html>