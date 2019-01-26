<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:login.php');
	//--
 	try
 	{
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	}catch(Exception $e)
 	{
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	}

 	class Binomes{
 		public $buffer;
 		function __construct($nom1,$prenom1,$nom2,$prenom2)
 		{	
 			if(strcmp($nom1, 'rong')!=0) $this->buffer=$nom1.' '.$prenom1.'</br>'.$nom2.'-'.$prenom2;
 			else $this->buffer="Pas encore" ;
 		}
 		public function showB(){
 			echo $this->buffer.'</br>' ;
 		}
 	}

 	$query=$bdd->prepare('SELECT * from stages where idstage in (select idstage from stages_detail where idemp=? ) ');
 	$query->execute(array($_SESSION['idemp']));	
 	$i=0;
 	while($ligne=$query->fetch()){

 		if(!empty($ligne['affectation'])){

	 		if(strcmp($ligne['niveau'] , '1A')==0){
	 		 $table='Binomes1A';
	 		 $table_etud='etudiants1a';
	 		}
	 		else{
	 		 $table='Binomes2A';
	 		 $table_etud='etudiants2a';
	 		}
	 		
	 		$query1=$bdd->prepare("SELECT * FROM $table where id_binome=? ");
	 		$query1->execute(array($ligne['affectation']));
	 		$ligne1=$query1->fetch();

	 		$query1=$bdd->prepare("SELECT * FROM $table_etud where codeEtudiant=? ");
	 		$query1->execute(array($ligne1['stagiaire1']));
	 		$ligne2=$query1->fetch();

	 		$query1=$bdd->prepare("SELECT * FROM $table_etud where codeEtudiant=? ");
	 		$query1->execute(array($ligne1['stagiaire2']));
	 		$ligne3=$query1->fetch();

	 		$Binomes[$i] = new Binomes($ligne2['nom'],$ligne2['prenom'],$ligne3['nom'],$ligne3['prenom']);
	 		$i=$i+1;
 		}else{
 			$Binomes[$i] = new Binomes('rong','','','');
 			$i=$i+1;
 		}
 	}

 	$query=$bdd->prepare('SELECT * from stages where idstage in (select idstage from stages_detail where idemp=? ) ');
 	$query->execute(array($_SESSION['idemp']));	
 	$ligne=$query->fetch();
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
				 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px;  ">
				 		<h1>AGS</h1>
				 		<h3 style="color:red;" ><p>Bonjour <?php echo $_SESSION['nom'].' '.$_SESSION['prenom'] ?></p></h3>
				 	</div>
				 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes,<strong style="color:red;" > ENSIAS </strong> </p></h3>
				 </header>

				 <section class="row">

				 	<div class="col-sm-12 col-md-4 col-lg-4">
				 		<ul class="list-group">
						   <button id="profil" class="list-group-item" onclick="document.location.href='profil.php'">Mon Profil</button>
							<button id="annonce" class="list-group-item" onclick="document.location.href='addannonce.php'">Ajouter une Annonce</button>
							<button id="ensemble" class="list-group-item  active" onclick="document.location.href='mesannonce.php'">Mes Annonces</button>
							<button id="mesinfos" class="list-group-item" onclick="document.location.href='addformation.php'">Ajouter Formation</button>
						</ul>
				 	</div>	
				 	<div class="col-sm-12 col-md-8 col-lg-8">
						<?php if(!empty($ligne)){ $c=1 ?>	
				 		<table class="table table-bordered table-striped table-condensed">
				 			<caption>Vos Annonces</caption>
				 			<head>
				 				<tr>
					 				<th>Titre</th>
					 				<th>Niveau</th>
					 				<th>Formation</th>
					 				<th>Affectation</th>
					 				<th>Satisfaction</th>
				 				</tr>
				 			</head>
				 			<tbody>
								<?php
										echo "<tr class='active' >";
										if(strcmp($Binomes[$c]->buffer, 'Pas encore')==0){
												echo "<td style='color:red;' >".$ligne['titre']."</td>";
												echo "<td style='color:red;' >".$ligne['niveau']."</td>";
												echo "<td style='color:red;' >".$ligne['formation']."</td>";
												echo "<td style='color:red;' >".$Binomes[$c]->buffer."</td>";
												echo "<td style='color:red;' >"."-1"."</td>";
											}
											else{
												echo "<td>".$ligne['titre']."</td>";
												echo "<td>".$ligne['niveau']."</td>";
												echo "<td>".$ligne['formation']."</td>";												
												echo "<td>".$Binomes[$c]->buffer."</td>";
												echo "<td>".$ligne['satisfaction']."</td>";
											}
										echo "</tr>";

									while($ligne=$query->fetch()){

										echo "<tr class='active' >";
										if(strcmp($Binomes[$c]->buffer, 'Pas encore')==0){
												echo "<td style='color:red;' >".$ligne['titre']."</td>";
												echo "<td style='color:red;' >".$ligne['niveau']."</td>";
												echo "<td style='color:red;' >".$ligne['formation']."</td>";
												echo "<td style='color:red;' >".$Binomes[$c]->buffer."</td>";
												echo "<td style='color:red;' >"."-1"."</td>";
											}
											else{
												echo "<td>".$ligne['titre']."</td>";
												echo "<td>".$ligne['niveau']."</td>";
												echo "<td>".$ligne['formation']."</td>";												
												echo "<td>".$Binomes[$c]->buffer."</td>";
												echo "<td>".$ligne['satisfaction']."</td>";
											}
										echo "</tr>";
										$c=$c+1;									
									}	
								?>
				 			</tbody>
				 		</table>	
				 	<?php }else{ ?>
				 		<div class="row">
				 			<div class="form-group" >
				 				<div class="alert alert-infos" >
				 					<strong>Vous n'avez publiè aucune annonces !</strong>
				 				</div>
				 			</div>
				 		</div>	
				 	<?php } ?>	
				 	</div>								 	
				 </section>
		</div>	
	</body>
</html>		 