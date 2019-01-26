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
 	if(strcmp($_SESSION['niveau'], '1A')==0){
 		 $table_choix='binomes1a_choix';
 	}
 	else{
 		 $table_choix='binomes2a_choix';
 	}
 	 $query=$bdd->prepare("SELECT * FROM $table_choix WHERE idb=?");
 	 $query->execute(array($_SESSION['idb']));
 	 $ligne=$query->fetch();
 	 //--
  	 if(empty($ligne)){
	  	$query=$bdd->prepare("INSERT INTO $table_choix(idb,choix1,choix2,choix3,choix4,choix5) VALUES (?,?,?,?,?,?) ");
	 	$query->execute(array($_SESSION['idb'],$_POST[1],$_POST[2],$_POST[3],$_POST[4],$_POST[5]));
	 	$bdd->exec("UPDATE $table_choix set affecter=0 where idb=".$_SESSION['idb']." ");
 	 }else{
 	 	echo $_POST['nombre_choix'];
 	 	$choix=array(0,0,0,0,0);
 	 	for($i=1;$i<=$_POST['nombre_choix'];$i++){
 	 		$choix[$i-1]=$_POST[$i];
 	 	}
 	  $query=$bdd->prepare("UPDATE $table_choix SET choix1=?,choix2=?,choix3=?,choix4=?,choix5=? WHERE idb=?");
 	  $query->execute(array($choix[0],$choix[1],$choix[2],$choix[3],$choix[4],$_SESSION['idb']));
 	  $bdd->exec("UPDATE $table_choix set affecter=0 where idb=".$_SESSION['idb']." ");
 	 }
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
			 		<p>Bonjour <?php echo $_SESSION['nomb']?></p>
			 	</div>
			 </header>
			 <section class="row">
			 	<div class=" col-md-offset-3 col-sm-12 col-md-5 col-lg-5">
				 	<div class="alert alert-info" >
				 		<strong style="color:red;" ><h3>enregistré</h3></strong>
				 		<p>Vos Choix on étaient correctement enregistrés,Merci</p>
				 		<p>par <strong style="color:green;"><a href="profil.php" >ici</a></strong> pour revenir</p> 
				 	</div>
			 	</div>
			 	<div class="col-sm-12 col-md-7 col-lg-7">
			 		
			 	</div>
			 </section>			
		</div>
</body>
</html>