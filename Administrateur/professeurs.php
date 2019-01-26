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

 	$emp=$bdd->query('SELECT * FROM employeurs');
 	$ligne7=$emp->fetch();

 	if(empty($ligne7)) $emp_ind='Vide';
 	else $emp_ind='Videbar';
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
			 		<h5 style="color:red;" ><p>Espace Administrative</p></h5>
			 	</div>
			 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes, <strong style="color:red;"> ENSIAS </strong>   </p></h3>
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
			 			    <button class="list-group-item" id="stagiaires" onclick="document.location.href='stagiaires-selection.php'">Gestion des Stagiaires</button>
			 			    <button class="list-group-item list-group-item-info active" id="employeurs" onclick="document.location.href='professeurs.php'">Gestion des Professeurs</button>
				 		</div>
			    	</div>
			    	<div class=" col-sm-12 col-md-7 col-lg-7"  style="margin-top:50px;" >

			    		<?php if(!empty($ligne7)){ ?>
				    		<table class="table table-bordered table-striped table-condensed">
				    			<caption>Employeurs</caption>
				    				<head>
				    					<tr>
				    						<th>Nom</th>
				    						<th>Prènom</th>
				    						<th>email</th>
				    						<th>Inscrit</th>
				    					</tr>
				    				</head>
				    				<tbody>

				    					<?php

				    						echo "<tr class='active' >";
					    						echo "<td>".$ligne7['nom']."</td>";
					    						echo "<td>".$ligne7['prenom']."</td>";
					    						echo "<td>".$ligne7['email']."</td>";
					    						echo "<td>".$ligne7['Confirmation']."</td>";
				    						echo "</tr>";	

				    						while($ligne7=$emp->fetch())
				    						{
				    							echo "<tr class='active' >";
					    							echo "<td>".$ligne7['nom']."</td>";
					    							echo "<td>".$ligne7['prenom']."</td>";
					    							echo "<td>".$ligne7['email']."</td>";
					    							echo "<td>".$ligne7['Confirmation']."</td>";
				    							echo "</tr>";	
				    						}

				    					?>
				    				</tbody>
				    		</table>
				    	<?php }else{ ?>
								 	<div class="starter-template">
								 		<h1 style="color:red; margin-left:63px; margin-top:-1px;" >Oops...</h1>
								 			<div class="row">
									 			<div class="form-group" >
										 			<div class="col-md-1" ></div>
										 				<div class="col-md-9">
												 			<div class="alert alert-info" >
												 				<strong>Aucun Prof n'est inscrit ! </strong>
												 			</div>
											 			</div>
										 		</div>
								 			</div>
								 	</div>	
						<?php } ?>		 				    			
			    	</div>
			    </div>
			 </section>
		</div>
	</body>
</html>			    		