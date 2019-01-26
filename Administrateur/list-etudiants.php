<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');

    try
    {
		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
    }catch(Exception $e)
    {
     	echo 'Error : '.$e.getmessage();
    }
    if(strcmp($_POST['niveau'] , '1A')==0){
    	$table='etudiants1a';
    }elseif (strcmp($_POST['niveau'] , '2A')==0) {
    	$table='etudiants2a';
    }else header('location:stagiaires-selection.php');
$_SESSION['vue']=1;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>AGS-ADMIN</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
	  <div class="container">
			<div class="row">
				<nav class="navbar navbar-inverse col-md-12 col-sm-12">
					<ul class="nav navbar-nav">
						<li><a href="imports-selection.php">Accueil</a></li>						
					</ul> 
					<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
				</nav>
			</div>
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em;">
			 		<h1>AGS</h1>
			 		<h5 style="color:red;"><p>Espace Administrative</p></h5>
			 	</div>
			 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes, ENSIAS  </p></h3>
			 </header>
			 <section>

			    <div class="row" style="margin-top:5px;">
					<div  class="col-sm-12 col-md-4 col-lg-4">
				 		<h4 class="w3-bar-item"><p>Menu</p></h4>
				 		<div>
			 			    <button id="btn-import" class="list-group-item"  onclick="document.location.href='imports-selection.php'">Importer un Fichier</button>
			 			    <button class="list-group-item" onclick="document.location.href='addformation.php'">Ajouter une formation</button>
			 			    <button id="btn-affectation" class="list-group-item" onclick="document.location.href='affectation-page.php'">Annoncer une Affectation</button>
			 		   		<button id="btn-deroulement" class="list-group-item "  onclick="document.location.href='deroulement.php'">Dérouler l'affectation</button> 
			 			    <button class="list-group-item active " id="stagiaires" onclick="document.location.href='stagiaires-selection.php'">Gestion des Stagiaires</button>
			 			    <button class="list-group-item" id="employeurs" onclick="document.location.href='professeurs.php'">Gestion des Employeurs</button>
				 		</div>
			    	</div>
			    	<div class="col-sm-12 col-md-8 col-lg-8"  style="margin-top:50px;" >
			    		<?php 
			    			 $formation_q=$bdd->query("SELECT DISTINCT formation from $table");
			    			 while($ligne=$formation_q->fetch()){
			    			 	$list=$bdd->prepare("SELECT * from $table where formation=? ");
			    			 	$list->execute(array($ligne['formation'])); ?>

			    				<table class="table table-bordered table-striped table-condensed">
			    					<caption>formation -<?php echo $ligne['formation']?> </caption>
			    						<head>
			    							<tr>
			    								<th>Nom</th>
			    								<th>Prènom</th>
			    								<th>email</th>
			    								<th>inscrit</th>
			    							</tr>
			    						</head>		
			    						<tbody>

			    		<?php	 while($etudiant=$list->fetch()){

			    					if(	$etudiant['confirmation']==0){
			    						echo "<tr class='active' >";
			    							echo "<td style='color:red;' >".$etudiant['nom']."</td>";
			    							echo "<td style='color:red;' >".$etudiant['prenom']."</td>";
			    							echo "<td style='color:red;' >".$etudiant['email']."</td>";
			    							echo "<td style='color:red;' >Pas encore</td>";
			    						echo "</tr>";	
			    					}else{
			    						echo "<tr class='active' >";
			    							echo "<td>".$etudiant['nom']."</td>";
			    							echo "<td>".$etudiant['prenom']."</td>";
			    							echo "<td>".$etudiant['email']."</td>";
			    							echo "<td>1</td>";
			    						echo "</tr>";	
			    					}
			    				}	
			    				echo '</br>';
			    			}	
			    		?>

			    	</div>
			    </div>
			 </section>
		</div>
	</body>
</html>			    	