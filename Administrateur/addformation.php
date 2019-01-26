<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');
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
			 	<div class="jumbotron" style="padding:0.5em;  width:1152px; margin-left:-10px; ">
			 		<h1>AGS</h1>
			 		<h5><p style="color:red;" >Espace Administartive</p></h5>
			 	</div>
			 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes, <strong style="color:red;"> ENSIAS </strong>   </p></h3>
			 </header>
			<section>

			    <div class="row" style="margin-top:5px;">
					<div  class="col-sm-12 col-md-4 col-lg-4">
				 		<h4 class="w3-bar-item"><p>Menu</p></h4>
				 		<div>
			 			    <button id="btn-import" class="list-group-item"  onclick="document.location.href='imports-selection.php'">Importer un Fichier</button>
			 			    <button class="list-group-item list-group-item-info active" onclick="document.location.href='addformation.php'">Ajouter une formation</button>
			 			    <button id="btn-affectation" class="list-group-item" onclick="document.location.href='affectation-page.php'">Annoncer une Affectation</button>
			 		   		<button id="btn-deroulement" class="list-group-item "  onclick="document.location.href='deroulement.php'">Dérouler l'affectation</button> 
			 			    <button class="list-group-item " id="stagiaires" onclick="document.location.href='stagiaires-selection.php'">Gestion des Stagiaires</button>
			 			    <button class="list-group-item" id="employeurs" onclick="document.location.href='professeurs.php'">Gestion des Professeurs</button>
				 		</div>
			    	</div>
			    	<div class="col-sm-12 col-md-8 col-lg-8"  style="margin-top:50px;" >
							<form  class="form-horizontal" action="enregistrement-formations.php" method="post" >
						    	<fieldset>
						    		<legend>Formations</legend>
								    	<div class="row">
								    		<div  id="form" class="form-group">
								    			<label id="360" type="text" class="col-md-2" style="margin-left:30px;">Formation 1:</label>
								    				<div class=" col-md-9">
														<input type="text" name="1" class="form-control" placeholder="Formation ici" >   
													</div>													
								    		</div>
											<div class="form-group">
												<div class="col-md-2" style="margin-left:30px;" ></div>
												<div class="col-md-9">
														<a class="btn btn-primary col-offset-md-1" onclick="inserer()">Ajouter Input</a>
														<a class="btn btn-danger" onclick="hide()" >Cacher Input</a>
												</div>
											</div>								    		
								    	</div>		
								</fieldset>	
								<input type="hidden" id="nombreformation" name="nombre_f" value="1" hidden>
							
								<input type="submit" id="but" class="btn btn-success col-md-3" value="Valider" style="margin-left:555px;">
							</form>	    		
			    	</div>
			    </div>
			</section> 	
		</div>
		<script>
			var i=1,nombre,j=1,k=360 ;
			nombre=document.getElementById('nombreformation');

			function inserer(){
				i++;
				k++;
				j=i;
				nombre.value=i;
				//------------------------------------------------------------//
		  		label=document.createElement('label');
		  		label.type='text';
		  		label.className='col-md-2';
		  		label.style='margin-left:30px;';
		  		label.id=k;
		  		label.appendChild(document.createTextNode('Formation '+i+':'));
		  		//------------------------------------------------------------//
		  		div=document.createElement('div');
		  		div.className='col-md-9';
		  		div.id=j;
		  		//------------------------------------------------------------//
		  		input=document.createElement('input');
		  		input.type="text";
		  		input.className='form-control';
		  		input.name=i;
		  		input.placeholder='Formation ici';
		  		//------------------------------------------------------------//
		  		//ctrl=document.createElement('/br');
		  		//ctrl.id='ctrl';
		  		//------------------------------------------------------------//
		  		div.appendChild(input);
		  		//------------------------------------------------------------//

		  		fieldset=document.getElementById('form');
		  		//fieldset.appendChild(ctrl);
		  		fieldset.appendChild(label);
		  		fieldset.appendChild(div);
		  		//------------------------------------------------------------//
			}
			function hide(){
				if(j!=1 && k!=360){
					input=document.getElementById('form');
					label=document.getElementById(k);
					child=document.getElementById(j); // div

					input.removeChild(label);
					input.removeChild(child);
					i=i-1;
					j=j-1;
					k=k-1;
					nombre.value=nombre.value-1;
				}
			}
		</script>
	</body>
</html>		